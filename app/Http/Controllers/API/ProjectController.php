<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\tbl_project;
use App\Models\tbl_phase;
use App\Models\tbl_role_project;
use App\Models\tbl_team_members;
use App\Models\tbl_task_assignments;
use App\Models\tbl_activities;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    /**
     * @OA\Get(
     *     path="/project",
     *     tags={"Project"},
     *     operationId="listProjects",
     *     summary="Project - Get All",
     *     description="Get all projects data",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Berhasil mengambil Data Project",
     *             "data": {
     *                 {
     *                     "project_id": 1,
     *                     "project_name": "Project A",
     *                     "project_desc": "Project Description",
     *                     "user_id": 1,
     *                     "start_date": "2024-01-14",
     *                     "end_date": "2024-12-31",
     *                     "status": "active",
     *                     "phases": {},
     *                     "role_projects": {}
     *                 }
     *             }
     *         })
     *     )
     * )
     */
    public function index()
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $projects = tbl_project::where('status', '!=', 'deleted')
                    ->with('phases')
                    ->get();

                $formattedProjects = $projects->map(function ($project) {
                    $phases = tbl_phase::where('project_id', $project->project_id)->get();

                    $projectCompletion = 0;
                    if ($phases->count() > 0) {
                        $totalPhaseCompletion = 0;

                        foreach ($phases as $phase) {
                            $activities = tbl_activities::where('phase_id', $phase->phase_id)->get();

                            $phaseCompletion = 0;
                            if ($activities->count() > 0) {
                                $totalActivityCompletion = 0;
                                foreach ($activities as $activity) {
                                    $completionValue = str_replace('%', '', $activity->completion);
                                    $totalActivityCompletion += (float)$completionValue;
                                }
                                $phaseCompletion = $totalActivityCompletion / $activities->count();
                            }

                            $totalPhaseCompletion += $phaseCompletion;
                        }

                        $projectCompletion = round($totalPhaseCompletion / $phases->count(), 2);
                    }

                    return [
                        'project_id' => $project->project_id,
                        'user_id' => $project->user_id,
                        'project_name' => $project->project_name,
                        'project_desc' => $project->project_desc,
                        'start_date' => $project->start_date,
                        'end_date' => $project->end_date,
                        'status' => $project->status,
                        'completion' => $projectCompletion,
                        'created_at' => $project->created_at,
                        'updated_at' => $project->updated_at
                    ];
                });

                $success = true;
                $message = 'Berhasil mengambil Data Project';
                $data = $formattedProjects;
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $data
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\Post(
     *     path="/project",
     *     tags={"Project"},
     *     operationId="createProject",
     *     summary="Project - Create",
     *     description="Create a new project with phases, roles, and optionally assign team members to roles.",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"project_name","start_date","user_id","status","phases","roles"},
     *             @OA\Property(property="project_name", type="string", example="Project A"),
     *             @OA\Property(property="project_desc", type="string", example="Project Description"),
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-01-14"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="status", type="string", example="active"),
     *             @OA\Property(
     *                 property="phases",
     *                 type="array",
     *                 @OA\Items(
     *                     required={"phase_name","start_date","end_date"},
     *                     @OA\Property(property="phase_name", type="string", example="Phase 1"),
     *                     @OA\Property(property="phase_desc", type="string", example="Phase Description"),
     *                     @OA\Property(property="start_date", type="string", format="date", example="2024-01-14"),
     *                     @OA\Property(property="end_date", type="string", format="date", example="2024-03-31")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 @OA\Items(
     *                     required={"rolep_name"},
     *                     @OA\Property(property="rolep_name", type="string", example="Project Manager"),
     *                     @OA\Property(property="rolep_desc", type="string", example="Role Description")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="team_members",
     *                 type="array",
     *                 description="Optional: Assign team members to roles",
     *                 @OA\Items(
     *                     required={"user_id","rolep_id"},
     *                     @OA\Property(property="user_id", type="integer", example=2),
     *                     @OA\Property(property="rolep_id", type="integer", example=1),
     *                     @OA\Property(property="assigned_date", type="string", format="date", example="2024-01-14")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Project, phases, roles, and team members created successfully",
     *             "data": {
     *                 "project_id": 1,
     *                 "project_name": "Project A",
     *                 "user_id": 1,
     *                 "project_desc": "Project Description",
     *                 "start_date": "2024-01-14",
     *                 "end_date": "2024-12-31",
     *                 "status": "active",
     *                 "created_at": "2024-01-14T12:00:00.000000Z",
     *                 "updated_at": "2024-01-14T12:00:00.000000Z"
     *             }
     *         })
     *     ),
     *     @OA\Response(
     *         response="422",
     *         description="Validation Error",
     *         @OA\JsonContent(example={
     *             "message": "The given data was invalid.",
     *             "errors": {
     *                 "project_name": {"The project name field is required."},
     *                 "phases.0.phase_name": {"The phases.0.phase_name field is required."}
     *             }
     *         })
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Internal Server Error",
     *         @OA\JsonContent(example={
     *             "success": false,
     *             "message": "Error creating project: SQLSTATE[23000]: Integrity constraint violation"
     *         })
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Modify validator to handle nested team members
        $validator = Validator::make($request->all(), [
            'project_name' => 'required',
            'start_date' => 'required',
            'user_id' => 'required|integer',
            'status' => 'required',
            'phases' => 'required|array',
            'phases.*.phase_name' => 'required|string',
            'phases.*.start_date' => 'required|date',
            'phases.*.end_date' => 'required|date',
            'roles' => 'required|array',
            'roles.*.rolep_name' => 'required|string',
            'roles.*.team_members' => 'array',
            'roles.*.team_members.*.user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $token = request()->bearerToken();
        if (!$this->checkToken($token)) {
            return response()->json([
                'success' => false,
                'message' => "Authorization Failed"
            ]);
        }

        try {
            DB::beginTransaction();

            // Create the project
            $project = tbl_project::create([
                'project_name' => $request->project_name,
                'user_id' => $request->user_id,
                'project_desc' => $request->project_desc,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            // Create the phases
            foreach ($request->phases as $phaseData) {
                tbl_phase::create([
                    'project_id' => $project->project_id,
                    'phase_name' => $phaseData['phase_name'],
                    'phase_desc' => $phaseData['phase_desc'] ?? null,
                    'status' => 'created',
                    'start_date' => $phaseData['start_date'],
                    'end_date' => $phaseData['end_date'],
                ]);
            }

            // Create roles and their team members
            foreach ($request->roles as $roleData) {
                // Create role
                $role = tbl_role_project::create([
                    'project_id' => $project->project_id,
                    'rolep_name' => $roleData['rolep_name'],
                    'rolep_desc' => $roleData['rolep_desc'] ?? null,
                    'add_activity_ability' => $roleData['add_activity_ability'] ?? null,
                    'mark_done_activity' => $roleData['mark_done_activity'] ?? null
                ]);

                // Create team members for this role
                if (isset($roleData['team_members']) && is_array($roleData['team_members'])) {
                    foreach ($roleData['team_members'] as $memberData) {
                        tbl_team_members::create([
                            'user_id' => $memberData['user_id'],
                            'rolep_id' => $role->rolep_id,
                            'project_id' => $project->project_id,
                            'assigned_date' => now(),
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Project, phases, roles, and team members created successfully',
                'data' => $project
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error creating project: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/project/{id}",
     *     tags={"Project"},
     *     operationId="getProject",
     *     summary="Project - Get By ID",
     *     description="Get project data by ID",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Berhasil mengambil Data Project",
     *             "data": {
     *                 "project_id": 1,
     *                 "project_name": "Project A",
     *                 "project_desc": "Project Description",
     *                 "user_id": 1,
     *                 "start_date": "2024-01-14",
     *                 "end_date": "2024-12-31",
     *                 "status": "active",
     *                 "phases": {},
     *                 "role_projects": {}
     *             }
     *         })
     *     )
     * )
     */
    public function showById($id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $project = tbl_project::select(
                    'tbl_projects.*',
                    'tbl_phases.phase_id',
                    'tbl_phases.phase_name',
                    'tbl_phases.phase_desc',
                    'tbl_phases.status as phase_status',
                    'tbl_phases.start_date as phase_start_date',
                    'tbl_phases.end_date as phase_end_date',
                    'tbl_role_projects.rolep_id',
                    'tbl_role_projects.rolep_name',
                    'tbl_role_projects.rolep_desc',
                    'tbl_role_projects.add_activity_ability',
                    'tbl_role_projects.mark_done_activity',
                    'tbl_team_members.member_id',
                    'tbl_team_members.assigned_date',
                    'tbl_user.user_id',
                    'tbl_user.nama',
                    'tbl_user.username'
                )
                    ->leftJoin('tbl_phases', 'tbl_projects.project_id', '=', 'tbl_phases.project_id')
                    ->leftJoin('tbl_role_projects', 'tbl_projects.project_id', '=', 'tbl_role_projects.project_id')
                    ->leftJoin('tbl_team_members', 'tbl_role_projects.rolep_id', '=', 'tbl_team_members.rolep_id')
                    ->leftJoin('tbl_user', 'tbl_team_members.user_id', '=', 'tbl_user.user_id')
                    ->where('tbl_projects.project_id', $id)
                    ->get();

                if ($project->isEmpty()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Project not found',
                    ], 404);
                }

                $formattedProject = $this->formatProjectData($project);
                $success = true;
                $message = 'Berhasil mengambil Data Project';
                $data = $formattedProject;
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $data
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function formatProjectData($rawData)
    {
        $firstRow = $rawData->first();
        $projectId = $firstRow->project_id;

        $project = [
            'user_id' => $firstRow->user_id,
            'project_id' => $projectId,
            'project_name' => $firstRow->project_name,
            'project_desc' => $firstRow->project_desc,
            'start_date' => $firstRow->start_date,
            'end_date' => $firstRow->end_date,
            'status' => $firstRow->status,
            'completion' => 0,
            'phases' => [],
            'role_projects' => []
        ];

        // Get phases for this project
        $projectPhases = tbl_phase::where('project_id', $projectId)->pluck('phase_id');
        // dd($projectPhases);

        // Get all activities for THIS project only
        $allActivities = tbl_activities::whereIn('phase_id', $projectPhases)->get();
        // dd($allActivities);
        $totalActivities = $allActivities->count();
        $memberActivityStats = [];

        // Calculate statistics for each member within the project
        foreach ($rawData as $row) {
            if ($row->user_id) {
                // Only count activities for this specific user AND within this project's phases
                $userActivities = $allActivities->where('user_id', $row->user_id);

                if (!isset($memberActivityStats[$row->user_id])) {
                    $memberActivityStats[$row->user_id] = [
                        'total_activities' => 0,
                        'completed_activities' => 0,
                        'in_progress_activities' => 0,
                        'pending_activities' => 0,
                        'total_completion' => 0
                    ];
                }

                foreach ($userActivities as $activity) {
                    $memberActivityStats[$row->user_id]['total_activities']++;

                    $completionValue = (float) str_replace('%', '', $activity->completion);
                    $memberActivityStats[$row->user_id]['total_completion'] += $completionValue;

                    switch ($activity->status) {
                        case 'Done':
                            $memberActivityStats[$row->user_id]['completed_activities']++;
                            break;
                        case 'In Progress':
                        case 'Review':
                            $memberActivityStats[$row->user_id]['in_progress_activities']++;
                            break;
                        default:
                            $memberActivityStats[$row->user_id]['pending_activities']++;
                            break;
                    }
                }
            }
        }

        // Group phases with completion calculation
        $phases = $rawData->unique('phase_id')->filter(function ($item) {
            return !is_null($item->phase_id);
        })->map(function ($phase) {
            $activities = tbl_activities::where('phase_id', $phase->phase_id)->get();
            $completion = 0;

            if ($activities->count() > 0) {
                $totalCompletion = 0;
                foreach ($activities as $activity) {
                    $completionValue = str_replace('%', '', $activity->completion);
                    $totalCompletion += (float)$completionValue;
                }
                $completion = round($totalCompletion / $activities->count(), 2);
            }

            return [
                'phase_id' => $phase->phase_id,
                'phase_name' => $phase->phase_name,
                'phase_desc' => $phase->phase_desc,
                'status' => $phase->phase_status,
                'start_date' => $phase->phase_start_date,
                'end_date' => $phase->phase_end_date,
                'completion' => $completion
            ];
        })->values();

        // Calculate project completion
        if ($phases->count() > 0) {
            $totalProjectCompletion = 0;
            foreach ($phases as $phase) {
                $totalProjectCompletion += $phase['completion'];
            }
            $project['completion'] = round($totalProjectCompletion / $phases->count(), 2);
        }

        // Group roles and team members with activity statistics
        $roles = [];
        foreach ($rawData as $row) {
            if ($row->rolep_id) {
                if (!isset($roles[$row->rolep_id])) {
                    $roles[$row->rolep_id] = [
                        'rolep_id' => $row->rolep_id,
                        'rolep_name' => $row->rolep_name,
                        'rolep_desc' => $row->rolep_desc,
                        'add_activity_ability' => $row->add_activity_ability,
                        'mark_done_activity' => $row->mark_done_activity,
                        'team_members' => []
                    ];
                }
                if ($row->member_id) {
                    $memberExists = collect($roles[$row->rolep_id]['team_members'])->contains(function ($member) use ($row) {
                        return $member['member_id'] === $row->member_id;
                    });

                    if (!$memberExists && isset($row->user_id)) {
                        $memberStats = $memberActivityStats[$row->user_id] ?? [
                            'total_activities' => 0,
                            'completed_activities' => 0,
                            'in_progress_activities' => 0,
                            'pending_activities' => 0,
                            'total_completion' => 0
                        ];

                        $roles[$row->rolep_id]['team_members'][] = [
                            'member_id' => $row->member_id,
                            'assigned_date' => $row->assigned_date,
                            'user' => [
                                'user_id' => $row->user_id,
                                'nama' => $row->nama,
                                'username' => $row->username
                            ],
                            'activity_statistics' => [
                                'total_assigned' => $memberStats['total_activities'],
                                'completed' => $memberStats['completed_activities'],
                                'in_progress' => $memberStats['in_progress_activities'],
                                'pending' => $memberStats['pending_activities'],
                                'completion_percentage' => $memberStats['total_activities'] > 0
                                    ? round($memberStats['total_completion'] / $memberStats['total_activities'], 2)
                                    : 0,
                                'workload_percentage' => $totalActivities > 0
                                    ? round(($memberStats['total_activities'] / $totalActivities) * 100, 2)
                                    : 0
                            ]
                        ];
                    }
                }
            }
        }

        $project['phases'] = $phases;
        $project['role_projects'] = array_values($roles);

        return $project;
    }

    /**
     * @OA\Put(
     *     path="/project/{id}",
     *     tags={"Project"},
     *     operationId="updateProject",
     *     summary="Project - Update",
     *     description="Update project data with phases and roles, including new and updated items",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="project_name", type="string", example="Project A Updated"),
     *             @OA\Property(property="project_desc", type="string", example="Updated Description"),
     *             @OA\Property(property="start_date", type="string", format="date", example="2024-01-14"),
     *             @OA\Property(property="end_date", type="string", format="date", example="2024-12-31"),
     *             @OA\Property(property="status", type="string", example="active"),
     *             @OA\Property(
     *                 property="phases",
     *                 type="array",
     *                 description="Array of phases. Use 'new_' prefix in phase_id for new phases",
     *                 @OA\Items(
     *                     @OA\Property(property="phase_id", type="string", example="1", description="Use 'new_1' format for new phases"),
     *                     @OA\Property(property="phase_name", type="string", example="Phase 1"),
     *                     @OA\Property(property="phase_desc", type="string", example="Phase Description", nullable=true),
     *                     @OA\Property(property="start_date", type="string", format="date", example="2024-01-14"),
     *                     @OA\Property(property="end_date", type="string", format="date", example="2024-03-31")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="roles",
     *                 type="array",
     *                 description="Array of roles. Use 'new_' prefix in rolep_id for new roles",
     *                 @OA\Items(
     *                     @OA\Property(property="rolep_id", type="string", example="1", description="Use 'new_1' format for new roles"),
     *                     @OA\Property(property="rolep_name", type="string", example="Project Manager"),
     *                     @OA\Property(property="rolep_desc", type="string", example="Role Description", nullable=true),
     *                     @OA\Property(
     *                         property="team_members",
     *                         type="array",
     *                         description="Array of team members (only for new roles)",
     *                         @OA\Items(
     *                             @OA\Property(property="user_id", type="integer", example=1),
     *                             @OA\Property(property="assigned_date", type="string", format="date", example="2024-01-14")
     *                         )
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Data berhasil diubah"),
     *             @OA\Property(property="data", type="null", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Project not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Project not found")
     *         )
     *     )
     * )
     */
    public function update(Request $request, $project_id)
    {
        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                DB::beginTransaction();

                // Find and update project
                $project = tbl_project::find($project_id);
                if (!$project) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Project not found',
                    ], 404);
                }

                // Update project details
                $project->update($request->only([
                    'project_name',
                    'project_desc',
                    'start_date',
                    'end_date',
                    'status'
                ]));

                // Handle phases
                if ($request->has('phases')) {
                    foreach ($request->phases as $phaseData) {
                        // Check if it's a new phase (ID starts with 'new_')
                        if (is_string($phaseData['phase_id']) && str_starts_with($phaseData['phase_id'], 'new_')) {
                            // Create new phase
                            tbl_phase::create([
                                'project_id' => $project_id,
                                'phase_name' => $phaseData['phase_name'],
                                'phase_desc' => $phaseData['phase_desc'] ?? null,
                                'status' => $phaseData['status'],
                                'start_date' => $phaseData['start_date'],
                                'end_date' => $phaseData['end_date'],
                            ]);
                        } else {
                            // Update existing phase
                            tbl_phase::where('phase_id', $phaseData['phase_id'])
                                ->where('project_id', $project_id)
                                ->update([
                                    'phase_name' => $phaseData['phase_name'],
                                    'phase_desc' => $phaseData['phase_desc'] ?? null,
                                    'status' => $phaseData['status'],
                                    'start_date' => $phaseData['start_date'],
                                    'end_date' => $phaseData['end_date'],
                                ]);
                        }
                    }
                }

                // Handle roles
                if ($request->has('roles')) {
                    foreach ($request->roles as $roleData) {
                        if (is_string($roleData['rolep_id']) && str_starts_with($roleData['rolep_id'], 'new_')) {
                            // Create new role
                            $role = tbl_role_project::create([
                                'project_id' => $project_id,
                                'rolep_name' => $roleData['rolep_name'],
                                'rolep_desc' => $roleData['rolep_desc'] ?? null,
                                'add_activity_ability' => $roleData['add_activity_ability'] ?? null,
                                'mark_done_activity' => $roleData['mark_done_activity'] ?? null
                            ]);

                            $roleId = $role->rolep_id;
                        } else {
                            // Update existing role
                            $roleId = $roleData['rolep_id'];
                            tbl_role_project::where('rolep_id', $roleId)
                                ->where('project_id', $project_id)
                                ->update([
                                    'rolep_name' => $roleData['rolep_name'],
                                    'rolep_desc' => $roleData['rolep_desc'] ?? null,
                                    'add_activity_ability' => $roleData['add_activity_ability'] ?? null,
                                    'mark_done_activity' => $roleData['mark_done_activity'] ?? null
                                ]);
                        }

                        // Handle team members for both new and existing roles
                        if (isset($roleData['team_members'])) {
                            $existingMemberIds = [];

                            foreach ($roleData['team_members'] as $memberData) {
                                if (!isset($memberData['member_id']) || str_starts_with($memberData['member_id'], 'new_')) {
                                    // Create new team member
                                    $member = tbl_team_members::create([
                                        'user_id' => $memberData['user_id'],
                                        'rolep_id' => $roleId,
                                        'project_id' => $project_id,
                                        'assigned_date' => $memberData['assigned_date'],
                                    ]);
                                    $existingMemberIds[] = $member->member_id;
                                } else {
                                    // Update existing team member
                                    tbl_team_members::where('member_id', $memberData['member_id'])
                                        ->where('rolep_id', $roleId)
                                        ->update([
                                            'user_id' => $memberData['user_id'],
                                            'assigned_date' => $memberData['assigned_date'],
                                        ]);
                                    $existingMemberIds[] = $memberData['member_id'];
                                }
                            }

                            // Remove team members that are no longer in the role
                            tbl_team_members::where('rolep_id', $roleId)
                                ->where('project_id', $project_id)
                                ->whereNotIn('member_id', $existingMemberIds)
                                ->delete();
                        }
                    }
                }

                // Handle deleted phases
                if ($request->has('deleted_phases')) {
                    tbl_phase::whereIn('phase_id', $request->deleted_phases)
                        ->where('project_id', $project_id)
                        ->delete();
                }

                // Handle deleted roles
                if ($request->has('deleted_roles')) {
                    tbl_role_project::whereIn('rolep_id', $request->deleted_roles)
                        ->where('project_id', $project_id)
                        ->delete();
                }

                // Handle deleted team members
                if ($request->has('deleted_team_members')) {
                    tbl_team_members::whereIn('member_id', $request->deleted_team_members)
                        ->where('project_id', $project_id)
                        ->delete();
                }

                DB::commit();

                $success = true;
                $message = 'Project updated successfully';
                $data = $project->fresh();
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Error updating project: ' . $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/project-by-user/{user_id}",
     *     tags={"Project"},
     *     operationId="getProjectsByUser",
     *     summary="Project - Get By User ID",
     *     description="Get all projects for a specific user",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Projects fetched successfully",
     *             "data": {
     *                 {
     *                     "project_id": 1,
     *                     "project_name": "Project A",
     *                     "project_desc": "Project Description",
     *                     "user_id": 1,
     *                     "start_date": "2024-01-14",
     *                     "end_date": "2024-12-31",
     *                     "status": "active"
     *                 }
     *             }
     *         })
     *     )
     * )
     */
    public function showByUser($user_id)
    {
        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";
        $data = null;

        if ($this->checkToken($token)) {
            try {
                // Fetch projects where the user is the project creator
                $projectsAsCreator = tbl_project::where('user_id', $user_id)
                    ->where('status', '!=', 'deleted')
                    ->get();

                // Fetch projects where the user is a team member
                $projectsAsMember = tbl_project::whereHas('team_members', function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })
                    ->where('status', '!=', 'deleted')
                    ->get();

                // Merge the two collections and remove duplicates
                $projects = $projectsAsCreator->merge($projectsAsMember)->unique('project_id');

                $success = true;
                $message = 'Projects fetched successfully';
                $data = $projects;
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error fetching projects: ' . $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    /**
     * @OA\Delete(
     *     path="/project/{id}",
     *     tags={"Project"},
     *     operationId="deleteProject",
     *     summary="Project - Delete",
     *     description="Delete project data with associated phases and roles",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Project ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Data berhasil dihapus",
     *             "data": null
     *         })
     *     )
     * )
     */
    public function destroy($project_id)
    {
        $token = request()->bearerToken();
        $success = false;
        $message = "Authorization Failed";

        if ($this->checkToken($token)) {
            try {
                $project = tbl_project::find($project_id);

                if (!$project) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Project not found',
                    ], 404);
                }
                tbl_phase::where('project_id', $project_id)->delete();

                tbl_role_project::where('project_id', $project_id)->delete();

                $project->delete();

                $success = true;
                $message = 'Project, phases, and roles deleted successfully';
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error deleting project: ' . $e->getMessage(),
                ], 500);
            }
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
        ], 200);
    }

    public function softDelete($project_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";

            if ($this->checkToken($token)) {

                $project = tbl_project::where('project_id', $project_id)
                    ->where('status', '!=', 'deleted')
                    ->first();

                if (!$project) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Project not found or already deleted'
                    ], 404);
                }

                // Update the project status
                $project->update(['status' => 'deleted']);

                $success = true;
                $message = 'Project successfully deleted';
            }

            return response()->json([
                'success' => $success,
                'message' => $message
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function assignTask(Request $request)
    {
        // Validate the task assignment data
        $validator = Validator::make($request->all(), [
            'task_id' => 'required|integer',
            'member_id' => 'required|integer',
            'assigned_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        try {
            // Assign the task to the team member
            $assignment = tbl_task_assignments::create([
                'task_id' => $request->task_id,
                'member_id' => $request->member_id,
                'assigned_date' => $request->assigned_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Task assigned successfully',
                'data' => $assignment,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error assigning task: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function getUserTasks($userId, $projectId)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                // Get phases that belong to the specified project
                $projectPhaseIds = tbl_phase::where('project_id', $projectId)
                    ->pluck('phase_id')
                    ->toArray();

                // Get activities that belong to these phases and assigned to the specified user
                $tasks = tbl_activities::whereIn('phase_id', $projectPhaseIds)
                    ->where('user_id', $userId)
                    ->select(
                        'activity_id',
                        'phase_id',
                        'activity_name',
                        'activity_desc',
                        'status',
                        'start_date',
                        'end_date',
                        'completion'
                    )
                    ->get();

                // Optionally, you can include phase information for each activity
                $tasks = $tasks->map(function ($task) {
                    $phase = tbl_phase::find($task->phase_id);
                    $task->phase_name = $phase ? $phase->phase_name : null;
                    return $task;
                });

                $success = true;
                $message = 'Berhasil mengambil Data Tugas';
                $data = $tasks;
            }

            return response()->json([
                'success' => $success,
                'message' => $message,
                'data' => $data
            ], 200);
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
