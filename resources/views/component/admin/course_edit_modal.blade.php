<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editCourseForm" novalidate enctype="multipart/form-data">
                    <input type="hidden" name="p_id" id="edit_p_id">
                    <input type="hidden" name="p_modified_date" id="edit_p_modified_date">
                    <div class="col-12">
                        <label for="edit_p_judul" class="form-label">Title</label>
                        <input type="text" name="p_judul" class="form-control" id="edit_p_judul" required>
                        <div class="invalid-feedback">Please enter the title!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_p_deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" name="p_deskripsi" id="edit_p_deskripsi" style="height: 100px;" required></textarea>
                        <div class="invalid-feedback">Please enter the description!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_p_status" class="form-label">Visibility</label>
                        <select name="p_status" id="edit_p_status" class="form-control">
                            <option value="1">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="edit_p_img" class="form-label">Image</label>
                        <input type="file" name="p_img" class="form-control" id="edit_p_img" accept="image/jpeg,image/png,image/jpg">
                        <div class="invalid-feedback">Please select a logo image (JPG, PNG only, max 2MB)</div>
                    </div>
                    <div class="col-12">
                        <div id="editLogoPreview" class="mt-2">
                            <img src="" alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="edit_p_start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" name="p_start_date" class="form-control" id="edit_p_start_date" required>
                        <div class="invalid-feedback">Please enter the start date!</div>
                    </div>
                    <div class="col-12">
                        <label for="p_end_date" class="form-label">End Date</label>
                        <input type="datetime-local" name="p_end_date" class="form-control" id="edit_p_end_date" required>
                        <div class="invalid-feedback">Please enter the end date!</div>
                    </div>
                    <div class="col-12">
                        <label for="p_harga" class="form-label">Price</label>
                        <input type="text" name="p_harga" class="form-control" id="edit_p_harga" required>
                        <div class="invalid-feedback">Please enter the price!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateCourse()">Save changes</button>
            </div>
        </div>
    </div>
</div>

