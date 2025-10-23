<div class="modal fade" id="forumDetailEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pesan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editPertanyaanForm" novalidate>
                    <div class="col-12">
                        <label for="forumSubjek" class="form-label">Pesan</label>
                        <textarea class="form-control" name="frd_tanggapan" placeholder="Masukkan pesan" id="frd_tanggapan"
                            style="height: 100px;"></textarea>
                        <div class="invalid-feedback">Masukkan pesan</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="editDtlForum()">Kirim</button>
            </div>
        </div>
    </div>
</div>
