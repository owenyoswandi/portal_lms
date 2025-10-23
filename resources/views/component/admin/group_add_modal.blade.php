<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Group</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addGroupForm" novalidate enctype="multipart/form-data">
                    <div class="col-12">
                        <label for="group_name" class="form-label">Nama</label>
                        <input type="text" name="group_name" class="form-control" id="group_name" required>
                        <div class="invalid-feedback">Please enter the name!</div>
                    </div>
                    <div class="col-12">
                        <label for="group_email" class="form-label">Email</label>
                        <input type="email" name="group_email" class="form-control" id="group_email" required>
                        <div class="invalid-feedback">Please enter a valid email!</div>
                    </div>
                    <div class="col-12">
                        <label for="group_phone" class="form-label">No Telepon</label>
                        <input type="text" name="group_phone" class="form-control" id="group_phone" required>
                        <div class="invalid-feedback">Please enter the phone number!</div>
                    </div>
                    <div class="col-12">
                        <label for="group_logo" class="form-label">Logo</label>
                        <input type="file" name="group_logo" class="form-control" id="group_logo"
                            accept="image/jpeg,image/png,image/jpg" required>
                        <div class="invalid-feedback">Please select a logo image (JPG, PNG only, max 2MB)</div>
                    </div>
                    <div class="col-12">
                        <div id="logoPreview" class="mt-2 d-none">
                            <img src="" alt="Logo Preview" class="img-thumbnail" style="max-height: 100px;">
                        </div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" name="group_alamat" id="group_alamat" style="height: 100px;" required></textarea>
                        <label for="group_alamat">Alamat</label>
                        <div class="invalid-feedback">Please enter the address!</div>
                    </div>
                    <!-- Hidden fields -->
                    <input type="hidden" name="group_creaby" id="group_creaby" value="">
                    <input type="hidden" name="group_creadate" id="group_creadate">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="addGroup()">Simpan</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('group_logo').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            const preview = document.getElementById('logoPreview');
            const previewImg = preview.querySelector('img');

            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.classList.remove('d-none');
            }

            reader.readAsDataURL(file);
        }
    });
</script>
