<!-- group_edit_modal.blade.php -->
<div class="modal fade" id="editGroupModal" tabindex="-1" aria-labelledby="editGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editGroupModalLabel">Edit Group</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editGroupForm" novalidate enctype="multipart/form-data">
                    <input type="hidden" name="group_id" id="edit_group_id">
                    <div class="col-12">
                        <label for="edit_group_name" class="form-label">Nama</label>
                        <input type="text" name="group_name" class="form-control" id="edit_group_name" required>
                        <div class="invalid-feedback">Please enter the name!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_group_email" class="form-label">Email</label>
                        <input type="email" name="group_email" class="form-control" id="edit_group_email" required>
                        <div class="invalid-feedback">Please enter a valid email!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_group_phone" class="form-label">No Telepon</label>
                        <input type="text" name="group_phone" class="form-control" id="edit_group_phone" required>
                        <div class="invalid-feedback">Please enter the phone number!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_group_logo" class="form-label">Logo</label>
                        <input type="file" name="group_logo" class="form-control" id="edit_group_logo" accept="image/jpeg,image/png,image/jpg">
                        <div class="invalid-feedback">Please select a logo image (JPG, PNG only, max 2MB)</div>
                    </div>
                    <div class="col-12">
                        <div id="editLogoPreview" class="mt-2">
                            <img src="" alt="Current Logo" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="group_alamat" id="edit_group_alamat" style="height: 100px;" required></textarea>
                        <label for="edit_group_alamat">Alamat</label>
                        <div class="invalid-feedback">Please enter the address!</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="updateGroup()">Simpan</button>
            </div>
        </div>
    </div>
</div>