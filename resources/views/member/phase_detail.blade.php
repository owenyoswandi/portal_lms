@extends('layouts.user.base')

@section('title', 'Project Detail')

<style>
    .card-body.drag-over {
        background-color: rgba(0, 123, 255, 0.1);
        border: 2px dashed #007bff;
    }

    .card[draggable="true"] {
        cursor: move;
        transition: all 0.2s ease;
    }

    .card[draggable="true"]:hover {
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .card.dragging {
        opacity: 0.5;
    }

    .update-failed {
        animation: shake 0.82s cubic-bezier(.36, .07, .19, .97) both;
        background-color: rgba(255, 0, 0, 0.1);
    }

    .no-drop {
        opacity: 0.5;
        pointer-events: none;
    }

    @keyframes shake {

        10%,
        90% {
            transform: translate3d(-1px, 0, 0);
        }

        20%,
        80% {
            transform: translate3d(2px, 0, 0);
        }

        30%,
        50%,
        70% {
            transform: translate3d(-4px, 0, 0);
        }

        40%,
        60% {
            transform: translate3d(4px, 0, 0);
        }
    }

    .table-view {
        display: none;
    }
</style>
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Activities</h5>
                        <small class="text-danger">Only member with mark-done ability can move the activities to <span
                                class="fw-bold">Done</span> section</small></br>
                        @if ($addActivityAbility > 0)
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">
                                Add Activity
                            </button>
                        @endif
                        <button type="button" class="btn btn-secondary mb-3" id="toggleView">
                            Switch to Table View
                        </button>
                        @include('component.user.activities_add_modal')
                        <div class="row kanban-view">
                            <div class="col-md-3">

                                <div class="card">
                                    <div class="card-header bg-primary text-white">
                                        To Do
                                    </div>
                                    <div class="card-body" id="todo">
                                        <!-- Activities will be loaded here -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-warning text-white">
                                        In Progress
                                    </div>
                                    <div class="card-body" id="in-progress">
                                        <!-- Activities will be loaded here -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-info text-white">
                                        Review
                                    </div>
                                    <div class="card-body" id="review">
                                        <!-- Activities will be loaded here -->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-header bg-success text-white">
                                        Done
                                    </div>
                                    <div class="card-body" id="done">
                                        <!-- Activities will be loaded here -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-view">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Activity Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Complexity</th>
                                        <th>Completion</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="activitiesTableBody">
                                    <!-- Activities will be loaded here -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('component.user.activities_edit_modal')

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Activity</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store group ID -->
                        <input type="hidden" id="activityIdToDelete">
                        <p>Anda yakin akan menghapus Activity <span id="activityNameToDelete"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteActivity()">Hapus</button>
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
        const phaseId = @json($phase_id);
        const add_activity_ability = @json($addActivityAbility);
        const mark_done_activity = @json($markDoneActivity);

        document.addEventListener('DOMContentLoaded', function() {
            fetchUsers();
            fetchActivities();
        });

        function fetchUsers() {
            fetch(`${apiUrl}/users`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then((response => response.json()))
                .then(data => {
                    console.log(data)
                    if (data.success) {
                        populateUserDropdown(data.data);
                    } else {
                        console.error('Failed to fetch users:', data.message);
                    }
                })
                .catch(error => console.error('Error fetching users:', error));
        }

        function populateUserDropdown(users) {
            const addUserDropdown = document.getElementById('user_id');
            const editUserDropdown = document.getElementById('edit_user_id');

            const populateDropdown = (dropdown, users) => {
                if (dropdown) {
                    dropdown.innerHTML = '<option selected disabled>Select a user</option>';
                    users.forEach(user => {
                        const option = document.createElement('option');
                        option.value = user.user_id;
                        option.textContent = `${user.nama} (${user.username})`;
                        dropdown.appendChild(option);
                    });
                }
            };

            populateDropdown(addUserDropdown, users);
            populateDropdown(editUserDropdown, users);
        }

        function fetchActivities() {
            fetch(`${apiUrl}/activities/${phaseId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        renderActivities(data.data);
                        renderTable(data.data);
                    } else {
                        console.error('Failed to fetch activities:', data.message);
                    }
                })
                .catch(error => console.error('Error fetching activities:', error));
        }

        function renderActivities(activities) {
            const todo = document.getElementById('todo');
            const inProgress = document.getElementById('in-progress');
            const review = document.getElementById('review');
            const done = document.getElementById('done');

            todo.innerHTML = '';
            inProgress.innerHTML = '';
            review.innerHTML = '';
            done.innerHTML = '';

            activities.forEach(activity => {
                let badgeClass;
                switch (activity.complexity) {
                    case 'Very Low':
                        badgeClass = 'bg-success';
                    case 'Low':
                        badgeClass = 'bg-success';
                        break;
                    case 'Medium':
                        badgeClass = 'bg-primary';
                        break;
                    case 'Hard':
                        badgeClass = 'bg-warning';
                        break;
                    case 'Very Hard':
                        badgeClass = 'bg-danger';
                        break;
                    default:
                        badgeClass = 'bg-secondary';
                        break;
                }
                const activityElement = document.createElement('div');
                activityElement.className = 'card mb-2';
                activityElement.draggable = true;
                activityElement.id = `activity-${activity.activity_id}`;
                activityElement.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">${activity.activity_name}</h5>
                            <p class="card-text">${activity.activity_desc}</p>
                            <small class="fw-bold">Completion: ${activity.completion}</small></br>
                            <small>Status: ${activity.status}</small>
                            <small>Complexity: <span class="badge ${badgeClass}">${activity.complexity}</span></small>
                            <div class="mt-2">
                                <button class="btn btn-sm btn-warning" onclick="openEditModal(${activity.activity_id})">Edit</button>
                               ${add_activity_ability > 0 ? `<button class="btn btn-sm btn-danger" onclick="deleteActivityConfirmation('${activity.activity_id}', '${activity.activity_name}')">Delete</button>` : ''}
                            </div>
                        </div>
                    `;

                activityElement.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', activity.activity_id);
                });

                switch (activity.status) {
                    case 'To Do':
                        todo.appendChild(activityElement);
                        break;
                    case 'In Progress':
                        inProgress.appendChild(activityElement);
                        break;
                    case 'Review':
                        review.appendChild(activityElement);
                        break;
                    case 'Done':
                        done.appendChild(activityElement);
                        break;
                }
            });

            setupDropZones();
        }

        function renderTable(activities) {
            const tableBody = document.getElementById('activitiesTableBody');
            tableBody.innerHTML = '';

            activities.forEach(activity => {
                let badgeClass;
                switch (activity.complexity) {
                    case 'Very Low':
                        badgeClass = 'bg-success';
                    case 'Low':
                        badgeClass = 'bg-success';
                        break;
                    case 'Medium':
                        badgeClass = 'bg-primary';
                        break;
                    case 'Hard':
                        badgeClass = 'bg-warning';
                        break;
                    case 'Very Hard':
                        badgeClass = 'bg-danger';
                        break;
                    default:
                        badgeClass = 'bg-secondary';
                        break;
                }

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${activity.activity_name}</td>
                    <td>${activity.activity_desc}</td>
                    <td>${activity.status}</td>
                    <td><span class="badge ${badgeClass}">${activity.complexity}</span></td>
                    <td>${activity.completion}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEditModal(${activity.activity_id})">Edit</button>
                        ${add_activity_ability > 0 ? `<button class="btn btn-sm btn-danger" onclick="deleteActivityConfirmation('${activity.activity_id}', '${activity.activity_name}')">Delete</button>` : ''}
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (mark_done_activity === 0) {
                const doneZone = document.querySelector('#done');
                doneZone.classList.add('no-drop');
            }
        });

        function setupDropZones() {
            const dropZones = document.querySelectorAll('.card-body');
            const draggableCards = document.querySelectorAll('[draggable="true"]');

            draggableCards.forEach(card => {
                card.addEventListener('dragstart', (e) => {
                    e.dataTransfer.setData('text/plain', card.id.split('-')[1]);
                    card.classList.add('dragging');
                });

                card.addEventListener('dragend', (e) => {
                    card.classList.remove('dragging');
                });
            });

            dropZones.forEach(zone => {
                zone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    zone.classList.add('drag-over');
                });

                zone.addEventListener('dragleave', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    zone.classList.remove('drag-over');
                });

                zone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    e.stopPropagation();

                    zone.classList.remove('drag-over');
                    const activityId = e.dataTransfer.getData('text/plain');
                    const dropZone = e.currentTarget.closest('.card');
                    const newStatus = dropZone.querySelector('.card-header').textContent.trim();

                    if (newStatus === "Done" && mark_done_activity === 0) {
                        alert("You do not have permission to mark activities as done.");
                        return;
                    }

                    updateActivityStatus(activityId, newStatus);
                });
            });
        }

        function updateActivityStatus(activityId, newStatus) {
            fetch(`${apiUrl}/activity/${activityId}/status`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        status: newStatus
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchActivities();
                    } else {
                        console.error('Failed to update activity:', data.message);
                        const activityElement = document.getElementById(`activity-${activityId}`);
                        activityElement.classList.add('update-failed');
                        setTimeout(() => {
                            activityElement.classList.remove('update-failed');
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error updating activity:', error);
                    fetchActivities();
                });
        }

        function addActivity() {
            const form = document.getElementById('addActivitiesForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const activityData = {
                phase_id: phaseId,
                activity_name: document.getElementById('activity_name').value,
                activity_desc: document.getElementById('activity_desc').value,
                start_date: document.getElementById('start_date').value,
                end_date: document.getElementById('end_date').value,
                complexity: document.getElementById('complexity').value,
                duration: '00:00:00',
                completion: '0%',
                status: 'To Do',
                user_id: document.getElementById('user_id').value
            };

            fetch(`${apiUrl}/activities`, {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(activityData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchActivities();
                        $('#exampleModal').modal('hide');
                        form.reset();
                    } else {
                        console.error('Failed to add activity:', data.message);
                    }
                })
                .catch(error => console.error('Error adding activity:', error));
        }

        function openEditModal(activityId) {
            fetch(`${apiUrl}/activities-detail/${activityId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.data.length > 0) {
                        const activity = data.data[0];
                        document.getElementById('edit_activity_id').value = activity.activity_id;
                        document.getElementById('edit_activity_name').value = activity.activity_name;
                        document.getElementById('edit_activity_desc').value = activity.activity_desc;
                        document.getElementById('edit_start_date').value = activity.start_date;
                        document.getElementById('edit_end_date').value = activity.end_date;
                        document.getElementById('edit_actual_start_date').value = activity.actual_start_date;
                        document.getElementById('edit_actual_end_date').value = activity.actual_end_date;
                        document.getElementById('edit_complexity').value = activity.complexity;
                        document.getElementById('edit_completion').value = activity.completion;
                        document.getElementById('edit_duration').value = activity.duration ? activity.duration.slice(0,
                            5) : '00:00';

                        // Set up the status dropdown
                        const statusDropdown = document.getElementById('edit_status');

                        // Clear existing options first (especially the "Done" option which is conditional)
                        statusDropdown.innerHTML = `
                    <option value="To Do">To Do</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Review">Review</option>
                `;

                        // Add "Done" option if user has permission
                        if (mark_done_activity > 0) {
                            const doneOption = document.createElement('option');
                            doneOption.value = 'Done';
                            doneOption.textContent = 'Done';
                            statusDropdown.appendChild(doneOption);
                        }

                        // Set the current status
                        statusDropdown.value = activity.status;

                        const editUserDropdown = document.getElementById('edit_user_id');
                        if (editUserDropdown) {
                            editUserDropdown.value = activity.user_id;
                        }

                        if (!editUserDropdown.options.length) {
                            fetchUsers();
                        }

                        $('#editModal').modal('show');
                    } else {
                        console.error('Failed to fetch activity details:', data.message);
                    }
                })
                .catch(error => console.error('Error fetching activity details:', error));
        }

        function updateActivity() {
            const form = document.getElementById('editActivitiesForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const durationInput = document.getElementById('edit_duration').value;
            const formattedDuration = durationInput + ':00';

            const activityData = {
                activity_name: document.getElementById('edit_activity_name').value,
                activity_desc: document.getElementById('edit_activity_desc').value,
                start_date: document.getElementById('edit_start_date').value,
                end_date: document.getElementById('edit_end_date').value,
                actual_start_date: document.getElementById('edit_actual_start_date').value,
                actual_end_date: document.getElementById('edit_actual_end_date').value,
                complexity: document.getElementById('edit_complexity').value,
                completion: document.getElementById('edit_completion').value,
                user_id: document.getElementById('edit_user_id').value,
                duration: formattedDuration,
                status: document.getElementById('edit_status').value, // Add the status field
            };

            const activityId = document.getElementById('edit_activity_id').value;

            fetch(`${apiUrl}/activity/${activityId}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(activityData)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchActivities();
                        $('#editModal').modal('hide');
                    } else {
                        console.error('Failed to update activity:', data.message);
                    }
                })
                .catch(error => console.error('Error updating activity:', error));
        }

        function deleteActivityConfirmation(activityId, activityName) {
            document.getElementById('activityIdToDelete').value = activityId;
            document.getElementById('activityNameToDelete').textContent = activityName;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteActivity() {
            const activityId = document.getElementById('activityIdToDelete').value;
            fetch(`${apiUrl}/activity/${activityId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchActivities();
                        var myModalEl = document.getElementById('deleteConfirmationModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Failed to delete activity:', data.message);
                    }
                })
                .catch(error => console.error('Error deleting activity:', error));

        }

        // Toggle between Kanban and Table views
        document.getElementById('toggleView').addEventListener('click', function() {
            const kanbanView = document.querySelector('.kanban-view');
            const tableView = document.querySelector('.table-view');
            const toggleButton = document.getElementById('toggleView');

            if (kanbanView.style.display === 'none') {
                kanbanView.style.display = 'flex';
                tableView.style.display = 'none';
                toggleButton.textContent = 'Switch to Table View';
            } else {
                kanbanView.style.display = 'none';
                tableView.style.display = 'block';
                toggleButton.textContent = 'Switch to Kanban View';
            }
        });
    </script>
@endsection
