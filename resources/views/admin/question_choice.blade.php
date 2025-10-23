@extends('layouts.user.base')

@section('title', 'Manage of Question Choice')

@section('content')
    <div class="pagetitle">
        <h1>Question Bank</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Question Bank</li>
				<li class="breadcrumb-item active">Question</li>
				<li class="breadcrumb-item active">Answer Options</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Answer Options
                    </button>
                </div>
                @include('component.admin.options_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Answer Options: "<?= $data_pertanyaan['teks_pertanyaan'] ?>"</h5>


                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Options</th>
                                    <th scope="col">Is TRUE</th>
									<th scope="col">Max. Score</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.options_edit_modal')
                    </div>
                </div>

            </div>
			
			<div class="d-flex justify-content-start my-3">
				<a href="{{ url('/admin/question') }}" class="btn btn-primary">Back</a>
			</div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Group</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store group ID -->
                        <input type="hidden" id="optionIdToDelete">
                        <p>Are you sure to delete this data "<span id="optionnameToDelete"></span>"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteOption()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getData();
        });
        const apiUrl = '{{ config('app.api_url') }}';
        const url = '{{ config('app.app_url') }}'
        const accessToken = '{{ session('token') }}';

        function getData() {
            axios.get(apiUrl + '/pertanyaan-jawaban/'+<?= $data_pertanyaan['pertanyaan_id'] ?>, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data)
                        updateTable(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateTable(Data) {
            const tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = '';

            Data.forEach((d, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${index + 1}</td>
            <td>${d.teks_pilihan}</td>
            <td>${d.is_jawaban_benar == 1 ? 'TRUE' : 'FALSE'}</td>
			<td>${d.maks_nilai}</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="getOptionById('${d.pilihan_id}')">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteOptionConfirmation('${d.pilihan_id}', '${d.teks_pilihan}')">Delete</button>
            </td>
        `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

        function displayEditOptionModal(formData) {
            const editModal = new bootstrap.Modal(document.getElementById('editOptionModal'));
            populateEditForm(formData);
            editModal.show();
        }
		
		function populateEditForm(formData) {
			document.getElementById('pilihan_id').value = formData[0].pilihan_id;
			document.getElementById('edit_pertanyaan_id').value = formData[0].pertanyaan_id;
            document.getElementById('edit_teks_pilihan').value = formData[0].teks_pilihan;
            document.getElementById('edit_is_jawaban_benar').value = formData[0].is_jawaban_benar;
			document.getElementById('edit_maks_nilai').value = formData[0].maks_nilai;
        }

        function getOptionById(id) {
            axios.get(apiUrl + `/jawaban/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log(data)
                    if (data.success) {
                        displayEditOptionModal(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function updateOption() {
            const form = document.getElementById('editOptionForm');
            const formData = new FormData(form);
            const userData = {};
            formData.forEach((value, key) => {
				let key_temp = key.replace("edit_", "");
                userData[key_temp] = value;
            });
            console.log(userData)

            axios.put(apiUrl + `/jawaban/update`, userData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('updated successfully.');
                        var myModalEl = document.getElementById('editOptionModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Updating failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function addOption() {
			
            const form = document.getElementById('addOptionForm');

            const formData = new FormData(form);

            axios.post(apiUrl + '/jawaban/create', formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Group added successfully.');
                        form.reset();
                        var myModalEl = document.getElementById('exampleModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Adding group failed:', data.message);
                    }
                })
                .catch(error => {
                    if (error.response && error.response.data) {
                        const errors = error.response.data;
                        console.error('Validation errors:', errors);
                    } else {
                        console.error('Error:', error);
                    }
                });
        }


        function deleteOptionConfirmation(Id, Name) {
            document.getElementById('optionIdToDelete').value = Id;
            document.getElementById('optionnameToDelete').textContent = Name;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteOption() {
            const Id = document.getElementById('optionIdToDelete').value;

            axios.delete(apiUrl + '/jawaban/delete', {
                    data: {
                        pilihan_id: Id
                    },
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        var myModalEl = document.getElementById('deleteConfirmationModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>

@endsection
