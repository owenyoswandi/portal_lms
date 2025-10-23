<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pencatatan Profile Pasien</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" id="addPasienDetailForm">
                    <div id="pasienName" class="flex">
                        <div class="mb-4 flex-fill">
                            <label for="pasien-select">Nama Pasien</label>
                            <select class="form-select" id="pasien-select" name="jwb_userid">
                            </select>
                            
                        </div>
                    </div>
                    <div class="flex">
                        <div class="form-floating form-floating-outline mb-4 flex-fill">
                            <input type="date" name="jwb_date" class="form-control" id="jwb_date">
                            <label for="obat_dosis" class="form-label">Tanggal</label>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="addPasien()">Simpan</button>
            </div>
        </div>
    </div>
</div>
