<!-- Add Activity Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Activity</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addActivitiesForm" novalidate enctype="multipart/form-data">
                    <div class="col-12">
                        <label for="activity_name" class="form-label">Activity Name</label>
                        <input type="text" name="activity_name" class="form-control" id="activity_name" required>
                        <div class="invalid-feedback">Please enter the name!</div>
                    </div>
                    <div class="col-12">
                        <label for="activity_desc" class="form-label">Description</label>
                        <input type="text" name="activity_desc" class="form-control" id="activity_desc" required>
                        <div class="invalid-feedback">Please enter a valid description!</div>
                    </div>
                    <div class="col-12">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" id="start_date" required>
                        <div class="invalid-feedback">Please enter the start date!</div>
                    </div>
                    <div class="col-12">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" id="end_date" required>
                        <div class="invalid-feedback">Please enter the end date!</div>
                    </div>
                    <div class="col-12">
                        <label for="complexity" class="form-label">Complexity</label>
                        <select class="form-select" id="complexity" name="complexity" required>
                            <option selected disabled>Choose the complexity</option>
                            <option value="Very Low">Very Low</option>
                            <option value="Low">Low</option>
                            <option value="Medium">Medium</option>
                            <option value="Hard">Hard</option>
                            <option value="Very Hard">Very Hard</option>
                        </select>
                        <div class="invalid-feedback">Please select a complexity!</div>
                    </div>
                    <div class="col-12">
                        <label for="user_id" class="form-label">Assign to User</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option selected disabled>Select a user</option>
                            <!-- Users will be dynamically populated here -->
                        </select>
                        <div class="invalid-feedback">Please select a user!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addActivity()">Save</button>
            </div>
        </div>
    </div>
</div>