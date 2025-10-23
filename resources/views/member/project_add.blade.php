@extends('layouts.user.base')

@section('title', 'Add Project')

@section('content')
    <div class="pagetitle">
        <h1>Add Project</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/member/project') }}">My Projects</a></li>
                <li class="breadcrumb-item active">Add Project</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Project Details</h4>

                        <!-- Add Project Form -->
                        <form id="addProjectForm">
                            @csrf
                            <div class="mb-3">
                                <label for="project_name" class="form-label">Project Name</label>
                                <input type="text" class="form-control" id="project_name" name="project_name" required>
                            </div>

                            <div class="mb-3">
                                <label for="project_desc" class="form-label">Project Description</label>
                                <textarea class="form-control" id="project_desc" name="project_desc" rows="3"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                            </div>

                            <div class="mb-3">
                                <label for="end_date" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="completed">Completed</option>
                                </select>
                            </div>

                            <!-- Phases Section -->
                            <div class="mb-3">
                                <h5 class="fw-bold">Phases</h5>
                                <div id="phases">
                                    <div class="phase mb-3 card p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="phase-number mb-0">Phase 1</h6>
                                            <button type="button" class="btn btn-danger btn-sm remove-phase"
                                                onclick="removePhase(this)" style="display: none;">Remove</button>
                                        </div>
                                        <input type="text" class="form-control mb-2" name="phases[0][phase_name]"
                                            placeholder="Phase Name" required>
                                        <textarea class="form-control mb-2" name="phases[0][phase_desc]" placeholder="Phase Description" rows="2"></textarea>
                                        <input type="date" class="form-control mb-2" name="phases[0][start_date]"
                                            placeholder="Start Date" required>
                                        <input type="date" class="form-control mb-2" name="phases[0][end_date]"
                                            placeholder="End Date" required>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-dark" onclick="addPhase()">Add Phase</button>
                            </div>

                            <!-- Roles and Team Members Section -->
                            <div class="mb-3">
                                <h5 class="fw-bold">Roles and Team Members</h5>
                                <div id="roles">
                                    <div class="role mb-3 card p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="role-number mb-0">Role 1</h6>
                                            <button type="button" class="btn btn-danger btn-sm remove-role"
                                                onclick="removeRole(this)" style="display: none;">Remove</button>
                                        </div>
                                        <input type="text" class="form-control mb-2" name="roles[0][rolep_name]"
                                            placeholder="Role Name" required>
                                        <textarea class="form-control mb-2" name="roles[0][rolep_desc]" placeholder="Role Description" rows="2"></textarea>

                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <!-- Hidden input to ensure a value is always sent -->
                                                <input type="hidden" name="roles[0][add_activity_ability]" value="0">
                                                <!-- Checkbox input -->
                                                <input class="form-check-input" type="checkbox"
                                                    name="roles[0][add_activity_ability]" id="activityAbility0"
                                                    value="1">
                                                <label class="form-check-label" for="activityAbility0">Activity
                                                    Ability</label>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check form-switch">
                                                <!-- Hidden input to ensure a value is always sent -->
                                                <input type="hidden" name="roles[0][mark_done_activity]" value="0">
                                                <!-- Checkbox input -->
                                                <input class="form-check-input" type="checkbox"
                                                    name="roles[0][mark_done_activity]" id="markDoneActivity0"
                                                    value="1">
                                                <label class="form-check-label" for="markDoneActivity0">Mark Done Activity
                                                    Ability</label>
                                            </div>
                                        </div>

                                        <!-- Team Members for this Role -->
                                        <div class="team-members mt-3">
                                            <h6>Team Members</h6>
                                            <div class="team-member mb-3">
                                                <select class="form-control mb-2"
                                                    name="roles[0][team_members][0][user_id]" required>
                                                    <option value="">Select User</option>
                                                    <!-- Users will be populated dynamically -->
                                                </select>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            onclick="addTeamMember(this)">Add Team Member</button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-dark" onclick="addRole()">Add Role</button>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('java_script')
    <script>
        const apiUrl = '{{ config('app.api_url') }}';
        const accessToken = '{{ session('token') }}';
        const userId = '{{ session('userid') }}';
        let users = []; // To store the list of users

        // Fetch Users from API
        async function fetchUsers() {
            try {
                const response = await axios.get(apiUrl + '/users', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                    },
                });
                if (response.data.success) {
                    users = response.data.data; // Store users
                    populateUserDropdowns(); // Populate dropdowns
                }
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        }

        // Populate User Dropdowns
        function populateUserDropdowns() {
            const userDropdowns = document.querySelectorAll('select[name*="[user_id]"]');
            userDropdowns.forEach(dropdown => {
                dropdown.innerHTML = '<option value="">Select User</option>';
                users.forEach(user => {
                    const option = document.createElement('option');
                    option.value = user.user_id;
                    option.textContent = `${user.nama} (${user.username})`;
                    dropdown.appendChild(option);
                });
            });
        }

        // Add Phase
        let phaseCount = 1;

        function updatePhaseNumbers() {
            document.querySelectorAll('.phase').forEach((phase, index) => {
                phase.querySelector('.phase-number').textContent = `Phase ${index + 1}`;

                // Update input names
                phase.querySelector('input[name*="[phase_name]"]').name = `phases[${index}][phase_name]`;
                phase.querySelector('textarea[name*="[phase_desc]"]').name = `phases[${index}][phase_desc]`;
                phase.querySelector('input[name*="[start_date]"]').name = `phases[${index}][start_date]`;
                phase.querySelector('input[name*="[end_date]"]').name = `phases[${index}][end_date]`;
            });
        }

        function updateFormIndices() {
            updatePhaseNumbers();
            updateRoleNumbers();
        }

        // Update remove buttons visibility
        function updateRemoveButtons() {
            // For phases
            const phases = document.querySelectorAll('.phase');
            phases.forEach(phase => {
                const removeBtn = phase.querySelector('.remove-phase');
                removeBtn.style.display = phases.length > 1 ? 'block' : 'none';
            });

            // For roles
            const roles = document.querySelectorAll('.role');
            roles.forEach(role => {
                const removeBtn = role.querySelector('.remove-role');
                removeBtn.style.display = roles.length > 1 ? 'block' : 'none';
            });
        }

        function addPhase() {
            const phasesDiv = document.getElementById('phases');
            const newPhase = document.createElement('div');
            newPhase.classList.add('phase', 'mb-3', 'card', 'p-3');
            newPhase.innerHTML = `
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="phase-number mb-0">Phase ${phaseCount + 1}</h6>
            <button type="button" class="btn btn-danger btn-sm remove-phase" onclick="removePhase(this)">Remove</button>
        </div>
        <input type="text" class="form-control mb-2" name="phases[${phaseCount}][phase_name]" placeholder="Phase Name" required>
        <textarea class="form-control mb-2" name="phases[${phaseCount}][phase_desc]" placeholder="Phase Description" rows="2"></textarea>
        <input type="date" class="form-control mb-2" name="phases[${phaseCount}][start_date]" placeholder="Start Date" required>
        <input type="date" class="form-control mb-2" name="phases[${phaseCount}][end_date]" placeholder="End Date" required>
    `;
            phasesDiv.appendChild(newPhase);
            phaseCount++;
            updateFormIndices();
            updateRemoveButtons();
        }

        // Remove Phase
        function removePhase(button) {
            button.closest('.phase').remove();
            phaseCount--;
            updatePhaseNumbers();
            updateRemoveButtons();
        }


        // Add Role
        let roleCount = 1;

        function updateRoleNumbers() {
            document.querySelectorAll('.role').forEach((role, roleIndex) => {
                role.querySelector('.role-number').textContent = `Role ${roleIndex + 1}`;

                // Update role input names
                role.querySelector('input[name*="[rolep_name]"]').name = `roles[${roleIndex}][rolep_name]`;
                role.querySelector('textarea[name*="[rolep_desc]"]').name = `roles[${roleIndex}][rolep_desc]`;

                // Update team member names
                role.querySelectorAll('.team-member').forEach((member, memberIndex) => {
                    member.querySelector('select').name =
                        `roles[${roleIndex}][team_members][${memberIndex}][user_id]`;
                });
            });
        }

        function addRole() {
            const rolesDiv = document.getElementById('roles');
            const newRole = document.createElement('div');
            newRole.classList.add('role', 'mb-3', 'card', 'p-3');
            newRole.innerHTML = `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="role-number mb-0">Role ${roleCount + 1}</h6>
                    <button type="button" class="btn btn-danger btn-sm remove-role" onclick="removeRole(this)">Remove</button>
                </div>
                <input type="text" class="form-control mb-2" name="roles[${roleCount}][rolep_name]" placeholder="Role Name" required>
                <textarea class="form-control mb-2" name="roles[${roleCount}][rolep_desc]" placeholder="Role Description" rows="2"></textarea>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input type="hidden" name="roles[${roleCount}][add_activity_ability]" value="0">
                        <input class="form-check-input" 
                            type="checkbox"
                            name="roles[${roleCount}][add_activity_ability]"
                            id="activityAbility${roleCount}"
                            value="1">
                        <label class="form-check-label" for="activityAbility${roleCount}">Activity Ability</label>
                    </div>
                    
                </div>
                <div class="mb-3">
                <div class="form-check form-switch">
                        <input type="hidden" name="roles[${roleCount}][mark_done_activity]" value="0">
                        <input class="form-check-input" 
                            type="checkbox"
                            name="roles[${roleCount}][mark_done_activity]"
                            id="markDoneActivity${roleCount}"
                            value="1">
                        <label class="form-check-label" for="markDoneActivity${roleCount}">Mark Done Activity Ability</label>
                    </div>
                </div>
                <div class="team-members mt-3">
                    <h6>Team Members</h6>
                    <div class="team-member mb-3">
                        <select class="form-control mb-2" name="roles[${roleCount}][team_members][0][user_id]" required>
                            <option value="">Select User</option>
                        </select>
                        <input type="date" class="form-control mb-2" name="roles[${roleCount}][team_members][0][assigned_date]" placeholder="Assigned Date" required>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-secondary" onclick="addTeamMember(this)">Add Team Member</button>
            `;
            rolesDiv.appendChild(newRole);
            roleCount++;
            populateUserDropdowns(); // Populate user dropdown for the new role
            updateRoleNumbers();
            updateRemoveButtons();
        }

        // Remove Role
        function removeRole(button) {
            button.closest('.role').remove();
            roleCount--;
            updateRoleNumbers();
            updateRemoveButtons();
        }

        // Add Team Member to a Role
        function addTeamMember(button) {
            const roleDiv = button.closest('.role');
            const roleIndex = Array.from(roleDiv.parentElement.children).indexOf(roleDiv);
            const teamMembersDiv = roleDiv.querySelector('.team-members');
            const teamMemberCount = teamMembersDiv.querySelectorAll('.team-member').length;

            const newTeamMember = document.createElement('div');
            newTeamMember.classList.add('team-member', 'mb-3', 'd-flex', 'gap-2', 'align-items-start');
            newTeamMember.innerHTML = `
        <div class="flex-grow-1">
            <select class="form-control mb-2" name="roles[${roleIndex}][team_members][${teamMemberCount}][user_id]" required>
                <option value="">Select User</option>
                ${users.map(user => `<option value="${user.user_id}">${user.nama} (${user.username})</option>`).join('')}
            </select>
        </div>
        <button type="button" class="btn btn-danger btn-sm" onclick="removeTeamMember(this)">×</button>
    `;
            teamMembersDiv.appendChild(newTeamMember);
        }

        // Add this new function for removing team members
        function removeTeamMember(button) {
            const teamMember = button.closest('.team-member');
            teamMember.remove();
            updateFormIndices();
        }

        // Submit Form
        document.getElementById('addProjectForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const data = {
                project_name: formData.get('project_name'),
                project_desc: formData.get('project_desc'),
                start_date: formData.get('start_date'),
                end_date: formData.get('end_date'),
                status: formData.get('status'),
                user_id: userId,
                phases: [],
                roles: []
            };

            // Collect phases
            document.querySelectorAll('.phase').forEach((phase, index) => {
                data.phases.push({
                    phase_name: formData.get(`phases[${index}][phase_name]`),
                    phase_desc: formData.get(`phases[${index}][phase_desc]`),
                    start_date: formData.get(`phases[${index}][start_date]`),
                    end_date: formData.get(`phases[${index}][end_date]`),
                });
            });

            // Collect roles and team members
            document.querySelectorAll('.role').forEach((role, roleIndex) => {
                const teamMembers = [];
                role.querySelectorAll('.team-member').forEach((member, memberIndex) => {
                    const userId = formData.get(
                        `roles[${roleIndex}][team_members][${memberIndex}][user_id]`);
                    if (userId) {
                        teamMembers.push({
                            user_id: userId
                        });
                    }
                });

                const activityAbilityCheckbox = role.querySelector(
                    `input[type="checkbox"][name="roles[${roleIndex}][add_activity_ability]"]`);
                const markDoneActivityCheckbox = role.querySelector(
                    `input[type="checkbox"][name="roles[${roleIndex}][mark_done_activity]"]`)

                data.roles.push({
                    rolep_name: formData.get(`roles[${roleIndex}][rolep_name]`),
                    rolep_desc: formData.get(`roles[${roleIndex}][rolep_desc]`),
                    add_activity_ability: activityAbilityCheckbox ? (activityAbilityCheckbox
                        .checked ? 1 : 0) : 0,
                    mark_done_activity: markDoneActivityCheckbox ? (markDoneActivityCheckbox
                        .checked ? 1 : 0) : 0,
                    team_members: teamMembers
                });
            });

            // Send API request
            try {
                console.log(data);
                const response = await axios.post(apiUrl + '/project', data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json',
                    },
                });
                if (response.data.success) {
                    Swal.fire({
                        icon: 'success',
                        text: 'Project berhasil tersimpan.',
                    }).then(() => {
                        window.location.href = '{{ url('/member/project') }}';
                    });
                } else {
                    alert('Error: ' + response.data.message);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            }
        });

        // Fetch users on page load
        fetchUsers();
    </script>
@endsection
