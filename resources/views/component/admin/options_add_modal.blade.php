<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Answer Option</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addOptionForm" novalidate enctype="multipart/form-data"> 
                    <div class="col-12">
						<input type="hidden" name="pertanyaan_id" id="pertanyaan_id" value="<?= $data_pertanyaan['pertanyaan_id'] ?>">
                        <label for="teks_pilihan" class="form-label">Option</label>
                        <textarea class="form-control" name="teks_pilihan" id="teks_pilihan" style="height: 100px;" required></textarea>
                    </div>
					<div class="form-floating form-floating-outline mb-4 flex-fill">
                        <select class="form-select" id="is_jawaban_benar" name="is_jawaban_benar"
                            aria-label="Default select example">
                            <option selected disabled>-- Select IS TRUE --</option>
                            <option value="1">TRUE</option>
                            <option value="0">FALSE</option>
                        </select>
                    </div>
					<div class="col-12">
                        <label for="maks_nilai" class="form-label">Max. Score</label>
                        <input type="number" class="form-control" name="maks_nilai" id="maks_nilai" required />
                    </div>
					
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addOption()">Save</button>
            </div>
        </div>
    </div>
</div>
