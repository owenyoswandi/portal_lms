<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use App\Models\tbl_activities;
use App\Models\tbl_phase;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *     path="/activities/{phase_id}",
     *     tags={"Activities"},
     *     operationId="index",
     *     summary="Activities - Get All by Phase",
     *     description="Get all activities for a specific phase",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="phase_id",
     *         in="path",
     *         required=true,
     *         description="ID of the phase",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Successfully retrieved activities",
     *             "data": {
     *                 {
     *                     "activity_id": 1,
     *                     "phase_id": 1,
     *                     "activity_name": "Database Design",
     *                     "activity_desc": "Design the database schema",
     *                     "start_date": "2024-02-13",
     *                     "end_date": "2024-02-20",
     *                     "complexity": "Medium",
     *                     "status": "In Progress",
     *                     "duration": "02:30:00",
     *                     "completion": "50%",
     *                     "user_id": 1
     *                 }
     *             }
     *         })
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(example={
     *             "success": false,
     *             "message": "Phase not found"
     *         })
     *     )
     * )
     */
    public function index($phase_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Group';
                $phase = tbl_phase::where('phase_id', $phase_id);
                if (!$phase) {
                    return response()->json(['success' => false, 'message' => 'Phase not found'], 404);
                }

                // Fetch activities for the phase
                $data = tbl_activities::where('phase_id', $phase_id)->get();
                return response()->json([
                    'success' => $success,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @OA\Get(
     *     path="/activities/{phase_id}/{user_id}",
     *     tags={"Activities"},
     *     operationId="showById",
     *     summary="Activities - Get All by Phase and User",
     *     description="Get activities for a specific phase and user",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="phase_id",
     *         in="path",
     *         required=true,
     *         description="ID of the phase",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Successfully retrieved activities",
     *             "data": {
     *                 {
     *                     "activity_id": 1,
     *                     "phase_id": 1,
     *                     "activity_name": "Database Design",
     *                     "activity_desc": "Design the database schema",
     *                     "start_date": "2024-02-13",
     *                     "end_date": "2024-02-20",
     *                     "complexity": "Medium",
     *                     "status": "In Progress",
     *                     "duration": "02:30:00",
     *                     "completion": "50%",
     *                     "user_id": 1
     *                 }
     *             }
     *         })
     *     )
     * )
     */

     public function showByUser($phase_id, $user_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data activity';
                $phase = tbl_phase::where('phase_id', $phase_id);
                if (!$phase) {
                    return response()->json(['success' => false, 'message' => 'Phase not found'], 404);
                }

                // Fetch activities for the phase and user
                $data = tbl_activities::where('phase_id', $phase_id)
                    ->where('user_id', $user_id)
                    ->get();

                return response()->json([
                    'success' => $success,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function showById($activity_id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data activity';
                $data = tbl_activities::where('activity_id', $activity_id)
                    ->get();

                return response()->json([
                    'success' => $success,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Post(
     *     path="/activities",
     *     tags={"Activities"},
     *     operationId="store",
     *     summary="Activities - Create",
     *     description="Create a new activity",
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(example={
     *             "phase_id": 1,
     *             "activity_name": "Database Design",
     *             "activity_desc": "Design the database schema",
     *             "start_date": "2024-02-13",
     *             "end_date": "2024-02-20",
     *             "complexity": "Medium",
     *             "status": "In Progress",
     *             "duration": "02:30:00",
     *             "completion": "50%",
     *             "user_id": 1
     *         })
     *     ),
     *     @OA\Response(
     *         response="201",
     *         description="Created",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Activity created successfully",
     *             "data": {
     *                 "activity_id": 1,
     *                 "phase_id": 1,
     *                 "activity_name": "Database Design",
     *                 "activity_desc": "Design the database schema",
     *                 "start_date": "2024-02-13",
     *                 "end_date": "2024-02-20",
     *                 "complexity": "Medium",
     *                 "status": "In Progress",
     *                 "duration": "02:30:00",
     *                 "completion": "50%",
     *                 "user_id": 1
     *             }
     *         })
     *     ),
     *     @OA\Response(
     *         response="400",
     *         description="Bad Request",
     *         @OA\JsonContent(example={
     *             "success": false,
     *             "message": "Validation error",
     *             "errors": {
     *                 "activity_name": {"The activity name field is required."}
     *             }
     *         })
     *     )
     * )
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'phase_id' => 'required|exists:tbl_phases,phase_id',
            'activity_name' => 'required|string|max:255',
            'activity_desc' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'complexity' => 'required|string',
            'status' => 'required|string',
            'duration' => 'required|date_format:H:i:s',
            'completion' => 'required|string',
            'user_id' => 'required|exists:tbl_user,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Group';
                $data = tbl_activities::create($request->all());

                return response()->json([
                    'success' => $success,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Create the activity

    }

    /**
     * @OA\Put(
     *     path="/activity/{id}",
     *     tags={"Activities"},
     *     operationId="update",
     *     summary="Activities - Update",
     *     description="Update an existing activity",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the activity",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(example={
     *             "phase_id": 1,
     *             "activity_name": "Updated Database Design",
     *             "activity_desc": "Updated database schema design",
     *             "start_date": "2024-02-13",
     *             "end_date": "2024-02-20",
     *             "complexity": "High",
     *             "status": "Completed",
     *             "duration": "03:30:00",
     *             "completion": "100%",
     *             "user_id": 1
     *         })
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Activity updated successfully",
     *             "data": {
     *                 "activity_id": 1,
     *                 "phase_id": 1,
     *                 "activity_name": "Updated Database Design",
     *                 "activity_desc": "Updated database schema design",
     *                 "start_date": "2024-02-13",
     *                 "end_date": "2024-02-20",
     *                 "complexity": "High",
     *                 "status": "Completed",
     *                 "duration": "03:30:00",
     *                 "completion": "100%",
     *                 "user_id": 1
     *             }
     *         })
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'phase_id' => 'sometimes|exists:tbl_phases,phase_id',
            'activity_name' => 'sometimes|string|max:255',
            'activity_desc' => 'nullable|string',
            'start_date' => 'sometimes|date',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
            'complexity' => 'sometimes|string',
            'status' => 'sometimes|string',
            'duration' => 'sometimes|date_format:H:i:s',
            'completion' => 'sometimes|string',
            'user_id' => 'sometimes|exists:tbl_user,user_id',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                // Find the activity
                $data = tbl_activities::where('activity_id', $id);
                if (!$data) {
                    return response()->json(['success' => false, 'message' => 'Activity not found'], 404);
                }

                $success = true;
                $message = 'Berhasil mengambil Data Group';
                $data->update($request->all());

                return response()->json([
                    'success' => $success,
                    'message' => $message,
                    'data' => $data
                ], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        // Update the activity

    }

    /**
     * @OA\Delete(
     *     path="/activity/{id}",
     *     tags={"Activities"},
     *     operationId="delete",
     *     summary="Activities - Delete",
     *     description="Delete an activity",
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the activity",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Success",
     *         @OA\JsonContent(example={
     *             "success": true,
     *             "message": "Activity deleted successfully"
     *         })
     *     ),
     *     @OA\Response(
     *         response="404",
     *         description="Not Found",
     *         @OA\JsonContent(example={
     *             "success": false,
     *             "message": "Activity not found"
     *         })
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $token = request()->bearerToken();
            $success = false;
            $message = "Authorization Failed";
            $data = null;

            if ($this->checkToken($token)) {
                $success = true;
                $message = 'Berhasil mengambil Data Group';
                $activity = tbl_activities::where('activity_id', $id);
                if (!$activity) {
                    return response()->json(['success' => false, 'message' => 'Activity not found'], 404);
                }

                // Delete the activity
                $activity->delete();

                return response()->json(['success' => true, 'message' => 'Activity deleted successfully'], 200);
            }
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:To Do,In Progress,Review,Done'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }

        try {
            $token = request()->bearerToken();
            if ($this->checkToken($token)) {
                $activity = tbl_activities::where('activity_id', $id)->first();
                if (!$activity) {
                    return response()->json(['success' => false, 'message' => 'Activity not found'], 404);
                }

                $activity->status = $request->status;
                $activity->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Status updated successfully',
                    'data' => $activity
                ], 200);
            }
            return response()->json(['success' => false, 'message' => 'Authorization Failed'], 401);
        } catch (QueryException $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
