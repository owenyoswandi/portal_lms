<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addCourseForm" novalidate enctype="multipart/form-data"> 
                    <div class="col-12">
                        <label for="p_judul" class="form-label">Title</label>
                        <input type="text" name="p_judul" class="form-control" id="p_judul" required>
                        <div class="invalid-feedback">Please enter the title!</div>
                    </div>
                    <div class="col-12">
                        <label for="p_deskripsi" class="form-label">Description</label>
                        <textarea class="form-control" name="p_deskripsi" id="p_deskripsi" style="height: 100px;" required></textarea>
                        <div class="invalid-feedback">Please enter the description!</div>
                    </div>
                    <div class="col-12">
                        <label for="p_status" class="form-label">Visibility</label>
                        <select name="p_status" id="p_status" class="form-control">
                            <option value="1">Show</option>
                            <option value="0">Hide</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label for="p_img" class="form-label">Image</label>
                        <input type="file" name="p_img" class="form-control" id="p_img"
                            accept="image/jpeg,image/png,image/jpg" required>
                        <div class="invalid-feedback">Please select a logo image (JPG, PNG only, max 2MB)</div>
                    </div>
                    <div class="col-12">
                        <div id="logoPreview" class="mt-2 d-none">
                            <img src="" alt="Logo Preview" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="p_start_date" class="form-label">Start Date</label>
                        <input type="datetime-local" name="p_start_date" class="form-control" id="p_start_date" required>
                        <div class="invalid-feedback">Please enter the start date!</div>
                    </div>
                    <div class="col-12">
                        <label for="p_end_date" class="form-label">End Date</label>
                        <input type="datetime-local" name="p_end_date" class="form-control" id="p_end_date" required>
                        <div class="invalid-feedback">Please enter the end date!</div>
                    </div>
                    <div class="col-12">
                        <label for="p_harga" class="form-label">Price</label>
                        <input type="text" name="p_harga" class="form-control" id="p_harga" required>
                        <div class="invalid-feedback">Please enter the price!</div>
                    </div>
                    <!-- Hidden fields -->
                    <input type="hidden" name="p_jenis" id="p_jenis">
                    <input type="hidden" name="p_id_lms" id="p_id_lms">
                    <input type="hidden" name="p_url_lms" id="p_url_lms">
                    <input type="hidden" name="p_created_date" id="p_created_date">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addCourse()">Save changes</button>
            </div>
        </div>
    </div>
</div>
