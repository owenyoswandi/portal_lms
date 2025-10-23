<div class="modal fade" id="SubtopicViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="SubtopicViewModalLabel"></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="view_t_id" id="view_t_id">
                <!-- Table with stripped rows -->
                <table class="table2" id="subtopicDataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Duedate</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <!-- End Table with stripped rows -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
