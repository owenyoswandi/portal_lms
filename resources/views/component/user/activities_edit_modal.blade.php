<!-- Edit Activity Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editModalLabel">Edit Activity</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editActivitiesForm" novalidate enctype="multipart/form-data">
                    <input type="hidden" id="edit_activity_id">
                    <div class="col-12">
                        {{-- <p>{{ $addActivityAbility }}</p> --}}
                        <label for="edit_activity_name" class="form-label">Activity Name</label>
                        <input type="text" name="activity_name" class="form-control" id="edit_activity_name"
                            @if ($addActivityAbility < 1) readonly @endif required>
                        <div class="invalid-feedback">Please enter the name!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_activity_desc" class="form-label">Description</label>
                        <input type="text" name="activity_desc" class="form-control" id="edit_activity_desc"
                            @if ($addActivityAbility < 1) readonly @endif required>
                        <div class="invalid-feedback">Please enter a valid description!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="edit_start_date"
                            @if ($addActivityAbility < 1) readonly @endif required>
                        <div class="invalid-feedback">Please enter the start date!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" id="edit_end_date"
                            @if ($addActivityAbility < 1) readonly @endif required>
                        <div class="invalid-feedback">Please enter the end date!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_complexity" class="form-label">Complexity</label>
                        <select class="form-select" id="edit_complexity" name="complexity"
                            @if ($addActivityAbility < 1) disabled @endif required>
                            <option value="Very Low">Very Low</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                            <option value="Very Hard">Very Hard</option>
                        </select>
                        <div class="invalid-feedback">Please select a complexity!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_completion" class="form-label">Completion</label>
                        <input type="text" name="completion" class="form-control" id="edit_completion" required>
                        <div class="invalid-feedback">Please enter a valid completion!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_duration" class="form-label">Duration (HH:MM)</label>
                        <input type="time" name="duration" class="form-control" id="edit_duration" step="60"
                            required>
                        <div class="invalid-feedback">Please enter the duration!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_start_date" class="form-label">Actual Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="edit_actual_start_date"
                            required>
                        <div class="invalid-feedback">Please enter the start date!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_end_date" class="form-label">Actual End Date</label>
                        <input type="date" name="end_date" class="form-control" id="edit_actual_end_date" required>
                        <div class="invalid-feedback">Please enter the end date!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="To Do">To Do</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Review">Review</option>
                            <!-- The "Done" option will be added conditionally via JavaScript -->
                        </select>
                        <div class="invalid-feedback">Please select a status!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_user_id" class="form-label">Assign to User</label>
                        <select class="form-select" id="edit_user_id" name="user_id"
                            @if ($addActivityAbility < 1) disabled @endif required>
                            <option selected disabled>Select a user</option>
                            <!-- Users will be dynamically populated here -->
                        </select>
                        <div class="invalid-feedback">Please select a user!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateActivity()">Save Changes</button>
            </div>
        </div>
    </div>
</div>
