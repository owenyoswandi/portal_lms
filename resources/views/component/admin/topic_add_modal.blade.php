<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Topic</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addTopicForm" novalidate enctype="multipart/form-data"> 
                    <div class="col-12">
                        <label for="t_name" class="form-label">Name</label>
                        <input type="text" name="t_name" class="form-control" id="t_name" required>
                        <div class="invalid-feedback">Please enter the title!</div>
                    </div>
                    <!-- Hidden fields -->
                    <input type="hidden" name="t_p_id" id="t_p_id">
                    <input type="hidden" name="t_creadate" id="t_creadate">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addTopic()">Save</button>
            </div>
        </div>
    </div>
</div>
