<div class="modal fade" id="editTopicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Topic</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editTopicForm" novalidate enctype="multipart/form-data">
                    <input type="hidden" name="t_id" id="edit_t_id">
                    <input type="hidden" name="t_modidate" id="edit_t_modidate">
                    <div class="col-12">
                        <label for="edit_t_name" class="form-label">Name</label>
                        <input type="text" name="t_name" class="form-control" id="edit_t_name" required>
                        <div class="invalid-feedback">Please enter the Name!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateTopic()">Save changes</button>
            </div>
        </div>
    </div>
</div>

