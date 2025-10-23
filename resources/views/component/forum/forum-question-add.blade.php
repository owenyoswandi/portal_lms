<div class="modal fade" id="forumAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Subjek dan Pertanyaan</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addPertanyaanForm" novalidate>
                    <div class="col-12">
                        <label for="kuisionerStatus" class="form-label">Subjek Pertanyaan</label>
                        <select name="fr_subject" class="form-select" id="forumPertanyaan" required>
                            <option value="" selected disabled>Pilih subjek pertanyaan</option>
                            @foreach ($subject_dropdown as $subject)
                                <option value="{{ $subject }}">{{ $subject }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">Pilih subjek pertanyaan</div>
                    </div>

                    <div class="col-12">
                        <label for="forumSubjek" class="form-label">Pertanyaan</label>
                        <textarea class="form-control" name="fr_pertanyaan" placeholder="Masukkan pertanyaan" id="kuisionerPertanyaan"
                            style="height: 100px;"></textarea>
                        <div class="invalid-feedback">Masukkan pertanyaan</div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="addSubjectKonsultasi()">Kirim</button>
            </div>
        </div>
    </div>
</div>
