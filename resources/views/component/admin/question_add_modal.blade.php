<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Question</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addQuestionForm" novalidate enctype="multipart/form-data"> 
                    <div class="form-floating form-floating-outline mb-4 flex-fill">
                        <select class="form-select" id="course_id" name="course_id"
                            aria-label="Default select example">
                            <option selected disabled>-- Select Course --</option>
                            <?php
								foreach ($data_course as $row) {
							?>
							<option value="<?= $row->p_id ?>"><?= $row->p_judul ?></option>		
							<?php
								}
							?>
                        </select>
                    </div>
					<div class="form-floating form-floating-outline mb-4 flex-fill">
                        <select class="form-select" id="kategori" name="kategori"
                            aria-label="Default select example">
                            <option selected disabled>-- Select Category --</option>
                            <option value="Pretest">Pretest</option>
                            <option value="Posttest">Posttest</option>
                        </select>
                    </div>
					<div class="col-12">
                        <label for="teks_pertanyaan" class="form-label">Question</label>
                        <textarea class="form-control" name="teks_pertanyaan" id="teks_pertanyaan" style="height: 100px;" required></textarea>
                    </div>
					<div class="form-floating form-floating-outline mb-4 flex-fill">
                        <select class="form-select" id="tipe_pertanyaan" name="tipe_pertanyaan"
                            aria-label="Default select example">
                            <option selected disabled>-- Select Type --</option>
                            <option value="pilihan_ganda">Multiple Choice</option>
                            <option value="isian">Essay</option>
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
                <button type="button" class="btn btn-primary" onclick="addQuestion()">Save</button>
            </div>
        </div>
    </div>
</div>
