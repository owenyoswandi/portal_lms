<div class="modal fade" id="forumEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Subjek dan Pertanyaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editPertanyaanForm" novalidate>
                    <div class="col-12">
                        <label for="forumSubjekEdit" class="form-label">Subjek Pertanyaan</label>
                        <select name="fr_subject" class="form-select" id="forumSubjekEdit" required>
                            <option value="" selected disabled>Pilih subjek pertanyaan</option>
                            @foreach ($subject_dropdown as $subject)
                                <option value="{{ $subject }}">{{ $subject }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Pilih subjek pertanyaan</div>
                    </div>
                    <div class="col-12">
                        <label for="forumPertanyaanEdit" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" name="fr_pertanyaan" placeholder="Masukkan pertanyaan" id="forumPertanyaanEdit"
                            style="height: 100px;"></textarea>
                        <div class="invalid-feedback">Masukkan pertanyaan</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="editForum()">Simpan</button>
            </div>
        </div>
    </div>
</div>
