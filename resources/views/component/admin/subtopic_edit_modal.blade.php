<div class="modal fade" id="editSubtopicModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Subtopic</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editSubtopicForm" novalidate enctype="multipart/form-data">
                    <input type="hidden" name="st_id" id="edit_st_id">
                    <input type="hidden" name="st_modidate" id="edit_st_modidate">
                    <div class="col-12">
                        <label for="edit_st_name" class="form-label">Name</label>
                        <input type="text" name="st_name" class="form-control" id="edit_st_name" required>
                        <div class="invalid-feedback">Please enter the title!</div>
                    </div>
                    <div class="col-12">
                        <label for="edit_st_jenis" class="form-label">Type</label>
                        <select name="st_jenis" id="edit_st_jenis" class="form-control">
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
                    <div class="col-12" id="edit_inputfile">
                        <label for="edit_st_file" class="form-label">File</label>
                        <input type="file" name="st_file" class="form-control" id="edit_st_file"
                            accept="*/*">
                        <div class="invalid-feedback">Please select a file</div>
                        <iframe id="edit_pdfPreview" style="display:none;"></iframe>
                    </div>
                    <div class="col-12" id="edit_inputlink">
                        <label for="edit_st_file_else" class="form-label">Link</label>
                        <input type="text" name="st_file_else" class="form-control" id="edit_st_file_else">
                        <!-- <div class="invalid-feedback">Please select a file</div> -->
                    </div>
                    <div class="col-12" id="edit_inputduedate"> 
                        <label for="edit_st_due_date" class="form-label">Due Date</label>
                        <input type="datetime-local" name="st_due_date" class="form-control" id="edit_st_due_date">
                        <div class="invalid-feedback">Please enter the due date!</div>
                    </div>
                    <div id="edit_inputstartdate">
                        <div class="col-12"> 
                            <label for="edit_st_start_date" class="form-label">Start Date</label>
                            <input type="datetime-local" name="st_start_date" class="form-control" id="edit_st_start_date">
                            <!-- <div class="invalid-feedback">Please enter the due date!</div> -->
                        </div>
                        
                        <div class="col-12">
                            <label for="st_duration" class="form-label mt-3">Duration</label>
                            <input type="number" name="st_duration" class="form-control" id="edit_st_duration">
                        </div>

                        <div class="col-12">
                            <label for="st_attemp_allowed" class="form-label mt-3">Attempt Allowed</label>
                            <input type="number" name="st_attemp_allowed" class="form-control" id="edit_st_attemp_allowed">
                        </div>
                        
                        <div class="col-12">
                            <label for="st_is_shuffle" class="form-label mt-3">Shuffle questions</label>
                            <select name="st_is_shuffle" id="edit_st_is_shuffle" class="form-control">
                                <option value="">Select an Option</option>
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label for="st_jumlah_shuffle" class="form-label mt-3">Number of Questions to shuffle</label>
                            <input type="number" name="st_jumlah_shuffle" class="form-control" id="edit_st_jumlah_shuffle">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="updateSubtopic()">Save changes</button>
            </div>
        </div>
    </div>
</div>

