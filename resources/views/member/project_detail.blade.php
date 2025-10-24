@extends('layouts.user.base')

@section('title', 'Project Detail')

@section('content')
    <div class="pagetitle">
        <h1>Project Detail</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/member/project') }}">My Projects</a></li>
                <li class="breadcrumb-item active">Project Detail</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <!-- Project Info Card -->
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Project Information</h5>
                            <button class="btn btn-primary btn-sm" id="toggleEditBtn" onclick="toggleEditMode()">
                                <i class="bi bi-pencil"></i> Edit
                            </button>
                        </div>

                        <!-- View Mode -->
                        <div id="viewMode">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold">Project Name</h6>
                                    <p id="view_project_name"></p>

                                    <h6 class="fw-bold">Project Description</h6>
                                    <p id="view_project_desc"></p>
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Start Date</h6>
                                            <p id="view_start_date"></p>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">End Date</h6>
                                            <p id="view_end_date"></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Status</h6>
                                            <span id="view_status" class="badge"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <h6 class="fw-bold">Completion</h6>
                                            <p id="view_completion"></p>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                        <!-- Edit Mode -->
                        <div id="editMode" style="display: none;">
                            <form id="projectForm">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Project Name</label>
                                            <input type="text" class="form-control" id="edit_project_name"
                                                name="project_name" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Project Description</label>
                                            <textarea class="form-control" id="edit_project_desc" name="project_desc" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="date" class="form-control" id="edit_start_date"
                                                        name="start_date" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <label class="form-label">End Date</label>
                                                    <input type="date" class="form-control" id="edit_end_date"
                                                        name="end_date" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-control" id="edit_status" name="status" required>
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                                <option value="completed">Completed</option>
                                                <option value="deleted">Deleted</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Team Activity Statistics</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Member Name</th>
                                        <th>Role</th>
                                        <th>Total Tasks</th>
                                        <th>Completed</th>
                                        <th>In Progress</th>
                                        <th>Pending</th>
                                        <th>Completion %</th>
                                        <th>Workload %</th>
                                    </tr>
                                </thead>
                                <tbody id="teamStatsTableBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Phases Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Project Phases</h5>
                            <button type="button" class="btn btn-sm btn-dark edit-mode" style="display: none;"
                                onclick="addPhase()">
                                <i class="bi bi-plus"></i> Add Phase
                            </button>
                        </div>
                        <div id="phasesList"></div>
                    </div>
                </div>
            </div>

            <!-- Roles Card -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="card-title mb-0">Project Roles</h5>
                            <button type="button" class="btn btn-sm btn-dark edit-mode" style="display: none;"
                                onclick="addRole()">
                                <i class="bi bi-plus"></i> Add Role
                            </button>
                        </div>
                        <div id="rolesList"></div>
                    </div>
                </div>
            </div>

            <!-- Save Changes Button -->
            <div class="col-12 mt-3" id="saveButtonContainer" style="display: none;">
                <button class="btn btn-primary" onclick="saveChanges()">Save Changes</button>
                <button class="btn btn-secondary" onclick="cancelEdit()">Cancel</button>
            </div>
        </div>
        <!-- Add this modal structure at the end of your Blade file -->
        <div class="modal fade" id="taskDetailsModal" tabindex="-1" aria-labelledby="taskDetailsModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskDetailsModalLabel">Task Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Task Name</th>
                                    <th>Status</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Completion %</th>
                                </tr>
                            </thead>
                            <tbody id="taskDetailsBody">
                                <!-- Task details will be populated here dynamically -->
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('java_script')
    <script>
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const accessToken = '{{ session('token') }}';
        const projectId = @json($project_id);
        const currentUserRole = '{{ session('role') }}';
        const currentUserId = {{ session('id') }};
        let currentProject = null;
        let phaseCount = 0;
        let roleCount = 0;
        let deletedPhases = [];
        let deletedRoles = [];

        function canUserEdit(project) {
            return currentUserRole === 'Admin' || (project && project.user_id === currentUserId);
        }
        // Fetch project details
        function fetchProjectDetails() {
            axios.get(`${apiUrl}/project/${projectId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    }
                })
                .then(response => {
                    if (response.data.success) {
                        currentProject = response.data.data;
                        phaseCount = currentProject.phases.length;
                        roleCount = currentProject.role_projects.length;
                        deletedPhases = [];
                        deletedRoles = [];
                        renderProjectDetails(currentProject);
                        populateEditForm(currentProject);
                        console.log(currentProject)

                        const toggleEditBtn = document.getElementById('toggleEditBtn');
                        // const addPhaseButtons = document.querySelectorAll('.edit-mode');
                        if (canUserEdit(currentProject)) {
                            toggleEditBtn.style.display = 'block';
                            // addPhaseButtons.forEach(btn => btn.style.display = 'block');
                        } else {
                            toggleEditBtn.style.display = 'none';
                            // addPhaseButtons.forEach(btn => btn.style.display = 'none');
                        }
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching project details.');
                });
        }

        let users = [];

        function fetchUsers() {
            axios.get(`${apiUrl}/users`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    }
                })
                .then(response => {
                    fetchProjectDetails();
                    if (response.data.success) {
                        users = response.data.data;
                    }
                })
                .catch(error => {
                    console.error('Error fetching users:', error);
                });
        }

        function addPhase() {
            const phaseId = 'new_' + phaseCount; // Use simple counter for new phases
            const phaseElement = document.createElement('div');
            phaseElement.className = 'card mb-3';
            phaseElement.innerHTML = `
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <input type="hidden" name="phases[${phaseCount}][phase_id]" value="${phaseId}">
                    <div class="mb-2">
                        <input type="text" class="form-control" name="phases[${phaseCount}][phase_name]" placeholder="Phase Name" required>
                    </div>
                    <div class="mb-2">
                        <textarea class="form-control" name="phases[${phaseCount}][phase_desc]" rows="2" placeholder="Phase Description"></textarea>
                    </div>
                    <div class="mb-2">
                        <select class="form-select" name="phases[${phaseCount}][status]" required>
                            <option value="" disabled selected>Select Status</option>
                            <option value="created">Created</option>
                            <option value="in_progress">In Progress</option>
                            <option value="complete">Complete</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <input type="date" class="form-control" name="phases[${phaseCount}][start_date]" required>
                        </div>
                        <div class="col-6">
                            <input type="date" class="form-control" name="phases[${phaseCount}][end_date]" required>
                        </div>
                    </div>
                    <div class="mt-2 text-end">
                        <button type="button" class="btn btn-danger btn-sm" onclick="removePhase('${phaseId}', this)">
                            <i class="bi bi-trash"></i> Remove
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;

            document.getElementById('phasesList').appendChild(phaseElement);
            phaseCount++;
        }

        function addRole() {
            const roleId = 'new_' + roleCount; // Use simple counter for new roles
            const roleElement = document.createElement('div');
            roleElement.className = 'card mb-3';
            roleElement.innerHTML = `
        <div class="card-body">
            <input type="hidden" name="roles[${roleCount}][rolep_id]" value="${roleId}">
            <div class="mb-2">
                <input type="text" class="form-control" name="roles[${roleCount}][rolep_name]" placeholder="Role Name" required>
            </div>
            <div class="mb-2">
                <textarea class="form-control" name="roles[${roleCount}][rolep_desc]" rows="2" placeholder="Role Description"></textarea>
            </div>
            <div class="mb-2">
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="roles[0][add_activity_ability]">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="roles[0][add_activity_ability]"
                                                    value="1"
                                                    id="activityAbility0"
                                                <label class="form-check-label" for="activityAbility0">Activity Ability</label>
                                            </div>
                                        </div>
              <div class="mb-2">
                                            <div class="form-check form-switch">
                                                <input type="hidden" name="roles[0][mark_done_activity]">
                                                <input class="form-check-input"
                                                    type="checkbox"
                                                    name="roles[0][mark_done_activity]"
                                                    value="1"
                                                    id="markDoneAtivity0"
                                                <label class="form-check-label" for="markDoneAtivity0">Mark Done Activity Ability</label>
                                            </div>
                                        </div>
            <div class="team-members mt-3">
                <h6>Team Members</h6>
                <div class="team-member mb-2">
                    <select class="form-control" name="roles[${roleCount}][team_members][0][user_id]" required>
                        <option value="">Select Team Member</option>
                        ${users.map(user => `<option value="${user.user_id}">${user.nama} (${user.username})</option>`).join('')}
                    </select>
                    <input type="date" class="form-control mt-2" name="roles[${roleCount}][team_members][0][assigned_date]" required>
                </div>
            </div>
            <div class="mt-2">
                <button type="button" class="btn btn-secondary btn-sm" onclick="addTeamMember(this, ${roleCount})">
                    <i class="bi bi-plus"></i> Add Team Member
                </button>
            </div>
            <div class="mt-2 text-end">
                <button type="button" class="btn btn-danger btn-sm" onclick="removeRole('${roleId}', this)">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </div>
        </div>
    `;

            document.getElementById('rolesList').appendChild(roleElement);
            roleCount++;
        }



        function removePhase(phaseId, element) {
            if (phaseId && !phaseId.startsWith('new_')) {
                deletedPhases.push(phaseId);
            }
            element.closest('.card').remove();
        }

        function removeRole(roleId, element) {
            if (roleId && !roleId.startsWith('new_')) {
                deletedRoles.push(roleId);
            }
            element.closest('.card').remove();
        }

        function getStatusBadgeClass(status) {
            switch (status) {
                case 'created':
                    return 'bg-primary';
                case 'in_progress':
                    return 'bg-warning text-dark';
                case 'complete':
                    return 'bg-success';
                default:
                    return 'bg-secondary';
            }
        }

        // Render project details in view mode
        function renderProjectDetails(project) {
            // Project Info
            document.getElementById('view_project_name').textContent = project.project_name;
            document.getElementById('view_project_desc').textContent = project.project_desc;
            document.getElementById('view_start_date').textContent = project.start_date;
            document.getElementById('view_end_date').textContent = project.end_date;
            document.getElementById('view_completion').textContent = project.completion + '%';

            const statusBadge = document.getElementById('view_status');
            statusBadge.textContent = project.status;
            statusBadge.className = `badge ${project.status === 'active' ? 'bg-success' : 'bg-secondary'}`;

            // Render phases with remove button
            const phasesHtml = project.phases.map((phase, index) => `
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col view-mode position-relative p-3 border rounded">
                            <a href="phase/${phase.phase_id}/${projectId}" class="btn btn-primary btn-sm position-absolute" style="top: 10px; right: 10px;">
                                Detail
                            </a>
                            <h6 class="fw-bold">${phase.phase_name}</h6>
                            <p class="mb-2">${phase.phase_desc || ''}</p>
                            <div class="row">
                                <div class="col-6">
                                    <small class="text-muted">Start: ${phase.start_date}</small>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">End: ${phase.end_date}</small>
                                </div>
                            </div>
                            <!-- Add Phase Status Badge -->
                            <div class="mt-2">
                                <span class="badge ${getStatusBadgeClass(phase.status)}">
                                    ${phase.status}
                                </span>
                            </div>
                            <div class="mt-2">
                                <small>Completion: ${phase.completion}%</small>
                            </div>
                        </div>
                        <div class="col edit-mode" style="display: none;">
                            <input type="hidden" name="phases[${index}][phase_id]" value="${phase.phase_id}">
                            <div class="mb-2">
                                <input type="text" class="form-control" name="phases[${index}][phase_name]" value="${phase.phase_name}" placeholder="Phase Name" required>
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control" name="phases[${index}][phase_desc]" rows="2" placeholder="Phase Description">${phase.phase_desc || ''}</textarea>
                            </div>
                            <div class="mb-2">
                                <select class="form-select" name="phases[${index}][status]" required>
                                    <option value="created" ${phase.status === 'created' ? 'selected' : ''}>Created</option>
                                    <option value="in_progress" ${phase.status === 'in_progress' ? 'selected' : ''}>In Progress</option>
                                    <option value="complete" ${phase.status === 'complete' ? 'selected' : ''}>Complete</option>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <input type="date" class="form-control" name="phases[${index}][start_date]" value="${phase.start_date}" required>
                                </div>
                                <div class="col-6">
                                    <input type="date" class="form-control" name="phases[${index}][end_date]" value="${phase.end_date}" required>
                                </div>
                            </div>
                            <!-- Add Phase Status Select Input -->

                            <div class="mt-2 text-end">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removePhase('${phase.phase_id}', this)">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');

            document.getElementById('phasesList').innerHTML = phasesHtml;
            // Update the rolesHtml in renderProjectDetails function:
            const rolesHtml = project.role_projects.map((role, index) => `
                <div class="card mb-3">
                    <div class="card-body py-3">
                        <div class="view-mode">
                            <h6 class="fw-bold">${role.rolep_name}</h6>
                            <p>${role.rolep_desc || ''}</p>
                           ${role.add_activity_ability == 1 ? '<span class="badge bg-success">Can Add Activity</span>' : ''}
                            ${role.mark_done_activity == 1 ? '<span class="badge bg-success">Can Mark Done Activities</span>' : ''}
                            ${role.team_members && role.team_members.length > 0 ? `
                                                                                                <div class="mt-3">
                                                                                                    <h6 class="fw-bold">Team Members:</h6>
                                                                                                    <ul class="list-unstyled">
                                                                                                        ${role.team_members.map(member => `
                                            <li class="mb-1">
                                                <i class="bi bi-person"></i>
                                                ${member.user.nama} (${member.user.username})
                                                <br>
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar"></i>
                                                    Assigned: ${member.assigned_date}
                                                </small>
                                            </li>
                                        `).join('')}
                                                                                                    </ul>
                                                                                                </div>
                                                                                            ` : ''}
                        </div>
                        <div class="edit-mode" style="display: none;">
                            <input type="hidden" name="roles[${index}][rolep_id]" value="${role.rolep_id}">
                            <div class="mb-2">
                                <input type="text" class="form-control" name="roles[${index}][rolep_name]" value="${role.rolep_name}" placeholder="Role Name" required>
                            </div>
                            <div class="mb-2">
                                <textarea class="form-control" name="roles[${index}][rolep_desc]" rows="2" placeholder="Role Description">${role.rolep_desc || ''}</textarea>
                            </div>
                            <div class="form-check form-switch">
                                <input type="hidden" name="roles[${index}][add_activity_ability]">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="roles[${index}][add_activity_ability]"
                                    value="1"
                                    id="activityAbility${index}"
                                    ${role.add_activity_ability == 1 ? 'checked' : ''}>
                                <label class="form-check-label" for="activityAbility${index}">Activity Ability</label>
                            </div>
                            <div class="form-check form-switch">
                                <input type="hidden" name="roles[${index}][mark_done_activity]">
                                <input class="form-check-input"
                                    type="checkbox"
                                    name="roles[${index}][mark_done_activity]"
                                    value="1"
                                    id="markDoneActivity${index}"
                                    ${role.mark_done_activity == 1 ? 'checked' : ''}>
                                <label class="form-check-label" for="markDoneActivity${index}">Mark Done Activity Ability</label>
                            </div>
                            <div class="team-members mt-3">
                                <h6>Team Members</h6>
                                ${role.team_members && role.team_members.length > 0 ?
                                    role.team_members.map((member, memberIndex) => `
                                                                                                        <div class="team-member mb-2">
                                                                                                            <input type="hidden" name="roles[${index}][team_members][${memberIndex}][member_id]" value="${member.member_id || ''}">
                                                                                                            <div class="d-flex gap-2">
                                                                                                                <div class="flex-grow-1">
                                                                                                                    <select class="form-control" name="roles[${index}][team_members][${memberIndex}][user_id]" required>
                                                                                                                        <option value="">Select Team Member</option>

                                                                                                                        ${users.map(user => `
                                                                        <option value="${user.user_id}" ${Number(user.user_id) === Number(member.user.user_id) ? 'selected' : ''}>
                                                                            ${user.nama} (${user.username})
                                                                        </option>
                                                                    `).join('')}
                                                                                                                    </select>
                                                                                                                    <input type="date" class="form-control mt-2"
                                                                                                                        name="roles[${index}][team_members][${memberIndex}][assigned_date]"
                                                                                                                        value="${new Date(member.assigned_date).toISOString().split('T')[0]}" required>
                                                                                                                </div>
                                                                                                                <button type="button" class="btn btn-danger btn-sm edit-mode" onclick="removeTeamMember('${member.id || ''}', this)">
                                                                                                                    <i class="bi bi-trash"></i>
                                                                                                                </button>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    `).join('')
                                    : ''
                                }
                            </div>
                            <div class="mt-2">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="addTeamMember(this, ${index})">
                                    <i class="bi bi-plus"></i> Add Team Member
                                </button>
                            </div>
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRole('${role.rolep_id}', this)">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `).join('');
            document.getElementById('rolesList').innerHTML = rolesHtml;
            renderTeamStatistics(project.role_projects);
        }


        function renderTeamStatistics(roleProjects) {
            const tableBody = document.getElementById('teamStatsTableBody');
            let tableContent = '';

            roleProjects.forEach(role => {
                role.team_members.forEach(member => {
                    const stats = member.activity_statistics;
                    tableContent += `
                <tr  onclick="showTaskDetails('${member.user.user_id}', '${member.user.nama}')">
                    <td><span style="cursor: pointer">${member.user.nama} (${member.user.username})</span></td>
                    <td>${role.rolep_name}</td>
                    <td>${stats.total_assigned}</td>
                    <td>${stats.completed}</td>
                    <td>${stats.in_progress}</td>
                    <td>${stats.pending}</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar"
                                style="width: ${stats.completion_percentage}%;"
                                aria-valuenow="${stats.completion_percentage}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                ${stats.completion_percentage}%
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-info" role="progressbar"
                                style="width: ${stats.workload_percentage}%;"
                                aria-valuenow="${stats.workload_percentage}"
                                aria-valuemin="0"
                                aria-valuemax="100">
                                ${stats.workload_percentage}%
                            </div>
                        </div>
                    </td>
                </tr>
            `;
                });
            });

            tableBody.innerHTML = tableContent;
        }

        function showTaskDetails(userId, userName) {
            // Fetch task details for the user
            axios.get(`${apiUrl}/user-tasks/${userId}/${projectId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    }
                })
                .then(response => {
                    if (response.data.success) {
                        const tasks = response.data.data;
                        let taskDetailsHtml = '';

                        tasks.forEach(task => {
                            taskDetailsHtml += `
                    <tr>
                        <td>${task.activity_name}</td>
                        <td>${task.status}</td>
                        <td>${task.start_date}</td>
                        <td>${task.end_date}</td>
                        <td>${task.completion}</td>
                    </tr>
                `;
                        });

                        // Populate the modal body
                        document.getElementById('taskDetailsBody').innerHTML = taskDetailsHtml;

                        // Update the modal title with the user's name
                        document.getElementById('taskDetailsModalLabel').innerText = `Task Details for ${userName}`;

                        // Show the modal
                        const modal = new bootstrap.Modal(document.getElementById('taskDetailsModal'));
                        modal.show();
                    } else {
                        alert('Error: ' + response.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching task details.');
                });
        }

        // Populate edit form
        function populateEditForm(project) {
            document.getElementById('edit_project_name').value = project.project_name;
            document.getElementById('edit_project_desc').value = project.project_desc;
            document.getElementById('edit_start_date').value = project.start_date;
            document.getElementById('edit_end_date').value = project.end_date;
            document.getElementById('edit_status').value = project.status;
        }

        // Toggle edit mode
        function toggleEditMode() {

            if (!canUserEdit(currentProject)) {
                Swal.fire({
                    icon: 'error',
                    text: 'You do not have permission to edit this project.',
                });
                return;
            }
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            const saveButtonContainer = document.getElementById('saveButtonContainer');
            const toggleEditBtn = document.getElementById('toggleEditBtn');
            const viewModeElements = document.querySelectorAll('.view-mode');
            const editModeElements = document.querySelectorAll('.edit-mode');

            if (viewMode.style.display !== 'none') {
                viewMode.style.display = 'none';
                editMode.style.display = 'block';
                saveButtonContainer.style.display = 'block';
                toggleEditBtn.innerHTML = '<i class="bi bi-x"></i> Cancel';
                viewModeElements.forEach(el => el.style.display = 'none');
                editModeElements.forEach(el => el.style.display = 'block');
            } else {
                cancelEdit();
            }
        }

        // Cancel edit
        function cancelEdit() {
            const viewMode = document.getElementById('viewMode');
            const editMode = document.getElementById('editMode');
            const saveButtonContainer = document.getElementById('saveButtonContainer');
            const toggleEditBtn = document.getElementById('toggleEditBtn');
            const viewModeElements = document.querySelectorAll('.view-mode');
            const editModeElements = document.querySelectorAll('.edit-mode');

            viewMode.style.display = 'block';
            editMode.style.display = 'none';
            saveButtonContainer.style.display = 'none';
            toggleEditBtn.innerHTML = '<i class="bi bi-pencil"></i> Edit';
            viewModeElements.forEach(el => el.style.display = 'block');
            editModeElements.forEach(el => el.style.display = 'none');

            // Reset form to original values
            populateEditForm(currentProject);
            deletedPhases = [];
            deletedRoles = [];
            deletedTeamMembers = [];
            fetchProjectDetails();
        }

        function addTeamMember(button, roleIndex) {
            const teamMembersDiv = button.closest('.card-body').querySelector('.team-members');
            const memberCount = teamMembersDiv.querySelectorAll('.team-member').length;

            const memberDiv = document.createElement('div');
            memberDiv.className = 'team-member mb-2';
            memberDiv.innerHTML = `
        <div class="d-flex gap-2">
            <div class="flex-grow-1">
                <select class="form-control" name="roles[${roleIndex}][team_members][${memberCount}][user_id]" required>
                    <option value="">Select Team Member</option>
                    ${users.map(user => `<option value="${user.user_id}">${user.nama} (${user.username})</option>`).join('')}
                </select>
                <input type="date" class="form-control mt-2" name="roles[${roleIndex}][team_members][${memberCount}][assigned_date]" required>
            </div>
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.team-member').remove()">
                    <i class="bi bi-trash"></i>
                 </button>
        </div>
    `;

            teamMembersDiv.appendChild(memberDiv);
        }

        let deletedTeamMembers = [];

        function removeTeamMember(memberId, element) {
            if (memberId && !memberId.startsWith('new_')) {
                deletedTeamMembers.push(memberId);
            }
            element.closest('.team-member').remove();
        }
        // Save changes
        function saveChanges() {
            if (!canUserEdit(currentProject)) {
                Swal.fire({
                    icon: 'error',
                    text: 'You do not have permission to edit this project.',
                });
                return;
            }
            const formData = new FormData(document.getElementById('projectForm'));
            const data = {
                project_name: formData.get('project_name'),
                project_desc: formData.get('project_desc'),
                start_date: formData.get('start_date'),
                end_date: formData.get('end_date'),
                status: formData.get('status'),
                phases: [],
                roles: [],
                deleted_phases: deletedPhases,
                deleted_roles: deletedRoles,
                deleted_team_members: []
            };

            // Collect phases data
            const phaseElements = document.querySelectorAll('#phasesList .card');
            phaseElements.forEach(phase => {
                const phaseId = phase.querySelector('[name$="[phase_id]"]').value;
                const phaseName = phase.querySelector('[name$="[phase_name]"]').value;
                const phaseDesc = phase.querySelector('[name$="[phase_desc]"]').value;
                const phaseStatus = phase.querySelector('[name$="[status]"]').value;
                const startDate = phase.querySelector('[name$="[start_date]"]').value;
                const endDate = phase.querySelector('[name$="[end_date]"]').value;

                data.phases.push({
                    phase_id: phaseId,
                    phase_name: phaseName,
                    phase_desc: phaseDesc,
                    status: phaseStatus,
                    start_date: startDate,
                    end_date: endDate
                });
            });

            // Collect roles data
            const roleElements = document.querySelectorAll('#rolesList .card');
            roleElements.forEach(role => {
                const roleId = role.querySelector('[name$="[rolep_id]"]').value;
                const roleName = role.querySelector('[name$="[rolep_name]"]').value;
                const roleDesc = role.querySelector('[name$="[rolep_desc]"]').value;
                const activityAbilityCheckbox = role.querySelector(
                    '[name$="[add_activity_ability]"][type="checkbox"]');
                const addActivityAbility = activityAbilityCheckbox ? (activityAbilityCheckbox.checked ? 1 : 0) : 0;
                const markDoneActivityCheckbox = role.querySelector(
                    '[name$="[mark_done_activity]"][type="checkbox"]');
                const markDoneActivity = markDoneActivityCheckbox ? (markDoneActivityCheckbox.checked ? 1 : 0) : 0;

                const roleData = {
                    rolep_id: roleId,
                    rolep_name: roleName,
                    rolep_desc: roleDesc,
                    add_activity_ability: addActivityAbility,
                    mark_done_activity: markDoneActivity,
                    team_members: [] // Always include team members array
                };

                // Collect team members for both new and existing roles
                const teamMembers = role.querySelectorAll('.team-member');
                teamMembers.forEach(member => {
                    const userId = member.querySelector('[name$="[user_id]"]').value;
                    const assignedDate = member.querySelector('[name$="[assigned_date]"]').value;
                    const memberId = member.querySelector('[name$="[member_id]"]')?.value ||
                        `new_${Date.now()}`;

                    if (userId && assignedDate) {
                        roleData.team_members.push({
                            member_id: memberId,
                            user_id: parseInt(userId),
                            assigned_date: assignedDate
                        });
                    }
                });

                data.roles.push(roleData);
            });
            console.log(data);

            // Send update request
            axios.put(`${apiUrl}/project/${projectId}`, data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json',
                    }
                })
                .then(response => {
                    if (response.data.success) {
                        Swal.fire({
                            icon: 'success',
                            text: 'Project updated successfully.',
                        }).then(() => {
                            fetchProjectDetails();
                            cancelEdit();
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        text: 'Failed to update project. Please try again.',
                    });
                });
        }

        fetchUsers();
    </script>
@endsection
