<div class="modal fade" id="editKuisionerModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pertanyaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editKuisionerForm" novalidate>

                    <div class="col-12">
                        <label for="kuisionerPertanyaan" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" name="pertanyaan_" placeholder="Masukkan pertanyaan" id="editKuisionerPertanyaan"
                            style="height: 100px;"></textarea>
                        <div class="invalid-feedback">Masukkan pertanyaan</div>
                    </div>


                    <div class="col-12">
                        <label for="kuisionerStatus" class="form-label">Status</label>
                        <input type="number" name="status" class="form-control" id="editKuisionerStatus" required>
                        <div class="invalid-feedback">Masukkan status!</div>
                    </div>

                    <div class="col-12">
                        <label for="kuisionerNoUrut" class="form-label">No Urut</label>
                        <input type="number" name="no_urut" class="form-control" id="editKuisionerNoUrut" required>
                        <div class="invalid-feedback">Masukkan no urut!</div>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="form-group flex-grow-1">
                            <label for="choiceEdit">Pilihan Jawaban</label>
                            <input type="text" id="choiceEdit" name="pilihan_jawaban" class="form-control">
                        </div>
                        <div class="btn-wrapper align-self-end">
                            <button type="button" id="addChoiceEdit" class="btn btn-primary btn-sm">Tambah Jawaban</button>
                        </div>
                    </div>

                    <div class="col-12" >
                        <div id="editChoiceList"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="editKuisioner()">Simpan</button>
            </div>
        </div>
    </div>
</div>
