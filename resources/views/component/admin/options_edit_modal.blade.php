<div class="modal fade" id="editOptionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Answer Option</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editOptionForm" novalidate enctype="multipart/form-data"> 
                    <div class="col-12">
						<input type="hidden" name="pilihan_id" id="pilihan_id">
						<input type="hidden" name="edit_pertanyaan_id" id="edit_pertanyaan_id" value="<?= $data_pertanyaan['pertanyaan_id'] ?>">
                        <label for="edit_teks_pilihan" class="form-label">Option</label>
                        <textarea class="form-control" name="edit_teks_pilihan" id="edit_teks_pilihan" style="height: 100px;" required></textarea>
                    </div>
					<div class="form-floating form-floating-outline mb-4 flex-fill">
                        <select class="form-select" id="edit_is_jawaban_benar" name="edit_is_jawaban_benar"
                            aria-label="Default select example">
                            <option selected disabled>-- Select IS TRUE --</option>
                            <option value="1">TRUE</option>
                            <option value="0">FALSE</option>
                        </select>
                    </div>
					<div class="col-12">
                        <label for="edit_maks_nilai" class="form-label">Max. Score</label>
                        <input type="number" class="form-control" name="edit_maks_nilai" id="edit_maks_nilai" required />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateOption()">Save</button>
            </div>
        </div>
    </div>
</div>
