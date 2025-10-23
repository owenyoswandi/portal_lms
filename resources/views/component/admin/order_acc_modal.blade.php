<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Acc Order Course</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="editForm" novalidate>
                    <input type="hidden" name="id" id="id_update">
                    <div class="col-12">
                        <label for="usermember" class="form-label">User Member</label>
                        <input type="text" name="usermember" class="form-control" id="usermember_update" readonly>
                        <!--<div class="invalid-feedback">Please enter the password!</div>-->
                    </div>
                    <div class="col-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title_update" readonly>
                        <!--<div class="invalid-feedback">Please enter the username!</div>-->
                    </div>
                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="edit()">Accept</button>
            </div>
        </div>
    </div>
</div>

