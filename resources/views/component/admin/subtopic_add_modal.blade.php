<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Subtopic</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addSubtopicForm" novalidate enctype="multipart/form-data"> 
                    <div class="col-12">
                        <label for="st_name" class="form-label">Name</label>
                        <input type="text" name="st_name" class="form-control" id="st_name" required>
                        <div class="invalid-feedback">Please enter the Name!</div>
                    </div>
                    <div class="col-12">
                        <label for="st_jenis" class="form-label">Type</label>
                        <select name="st_jenis" id="st_jenis" class="form-control">
                            <option value="">Select a Type</option>
                            <option value="Modul">Modul</option>
                            <option value="Link">Link</option>
                            <option value="Task">Task</option>
                            <option value="Test">Test</option>
                            <option value="Task Collection">Task Collection</option>
                            <option value="Feedback">Feedback</option>
							<option value="Certificate">Certificate</option>
                        </select>
                        <div class="invalid-feedback">Please select the Type!</div>
                    </div>
                    <div class="col-12" id="inputfile">
                        <label for="st_file" class="form-label">File</label>
                        <input type="file" name="st_file" class="form-control" id="st_file"
                            accept="application/pdf">
                        <iframe id="pdfPreview" style="display:none;"></iframe>
                        <!-- <div class="invalid-feedback">Please select a file</div> -->
                    </div>
                    <div class="col-12" id="inputlink">
                        <label for="st_file_else" class="form-label">Link</label>
                        <input type="text" name="st_file_else" class="form-control" id="st_file_else">
                        <!-- <div class="invalid-feedback">Please select a file</div> -->
                    </div>
                    <div id="inputduedate">
                        <div class="col-12"> 
                            <label for="st_due_date" class="form-label">Due Date</label>
                            <input type="datetime-local" name="st_due_date" class="form-control" id="st_due_date">
                            <!-- <div class="invalid-feedback">Please enter the due date!</div> -->
                        </div>
                    </div>
                    <div id="inputstartdate">
                        <div class="col-12"> 
                            <label for="st_start_date" class="form-label">Start Date</label>
                            <input type="datetime-local" name="st_start_date" class="form-control" id="st_start_date">
                            <!-- <div class="invalid-feedback">Please enter the due date!</div> -->
                        </div>
                        
                        <div class="col-12">
                            <label for="st_duration" class="form-label mt-3">Duration</label>
                            <input type="number" name="st_duration" class="form-control" id="st_duration">
                        </div>

                        <div class="col-12">
                            <label for="st_attemp_allowed" class="form-label mt-3">Attempt Allowed</label>
                            <input type="number" name="st_attemp_allowed" class="form-control" id="st_attemp_allowed">
                        </div>

                        <div class="col-12">
                            <label for="st_is_shuffle" class="form-label">Shuffle questions</label>
                            <select name="st_is_shuffle" id="st_is_shuffle" class="form-control">
                                <option value="">Select an Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="st_jumlah_shuffle" class="form-label mt-3">Number of Questions to shuffle</label>
                            <input type="number" name="st_jumlah_shuffle" class="form-control" id="st_jumlah_shuffle">
                        </div>
                    </div>
                    
                    <!-- Hidden fields -->
                    <input type="hidden" name="st_t_id" id="st_t_id">
                    <input type="hidden" name="st_creadate" id="st_creadate">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addSubtopic()">Save changes</button>
            </div>
        </div>
    </div>
</div>
