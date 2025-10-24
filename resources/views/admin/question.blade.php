@extends('layouts.user.base')

@section('title', 'Manage of Question')

@section('content')
    <div class="pagetitle">
        <h1>Question Bank</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Question Bank</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        + Question
                    </button>
                </div>
                @include('component.admin.question_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Question</h5>


                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Type</th>
									<th scope="col">Max. Score</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.question_edit_modal')
                    </div>
                </div>

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
                        <input type="hidden" id="questionIdToDelete">
                        <p>Are you sure to delete this data "<span id="questionnameToDelete"></span>"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteQuestion()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getData();
        });
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const url    = "{{ rtrim(url('/'), '/') }}";
        const accessToken = '{{ session('token') }}';

        function getData() {
            axios.get(apiUrl + '/pertanyaan', {
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
            <td>${d.p_judul}</td>
            <td>${d.kategori}</td>
            <td>${d.teks_pertanyaan}</td>
            <td>${d.tipe_pertanyaan}</td>
			<td>${d.maks_nilai}</td>
            <td>
				<a class="btn btn-success btn-sm" href="{{ url('/admin/question-choice/${d.pertanyaan_id}') }}">Detail</a>
                <button class="btn btn-warning btn-sm" onclick="getQuestionById('${d.pertanyaan_id}')">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteQuestionConfirmation('${d.pertanyaan_id}', '${d.teks_pertanyaan}')">Delete</button>
            </td>
        `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

        function displayEditQuestionModal(formData) {
            const editModal = new bootstrap.Modal(document.getElementById('editQuestionModal'));
            populateEditForm(formData);
            editModal.show();
        }

		function populateEditForm(formData) {
			document.getElementById('edit_pertanyaan_id').value = formData[0].pertanyaan_id;
            document.getElementById('edit_course_id').value = formData[0].course_id;
            document.getElementById('edit_kategori').value = formData[0].kategori;
            document.getElementById('edit_teks_pertanyaan').value = formData[0].teks_pertanyaan;
            document.getElementById('edit_tipe_pertanyaan').value = formData[0].tipe_pertanyaan;
			document.getElementById('edit_maks_nilai').value = formData[0].maks_nilai;
        }

        function getQuestionById(id) {
            axios.get(apiUrl + `/pertanyaan/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log(data)
                    if (data.success) {
                        displayEditQuestionModal(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function updateQuestion() {
            const form = document.getElementById('editQuestionForm');
            const formData = new FormData(form);
            const userData = {};
            formData.forEach((value, key) => {
				let key_temp = key.replace("edit_", "");
                userData[key_temp] = value;
            });
            console.log(userData)

            axios.put(apiUrl + `/pertanyaan/update`, userData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('updated successfully.');
                        var myModalEl = document.getElementById('editQuestionModal');
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

        function addQuestion() {

            const form = document.getElementById('addQuestionForm');

            const formData = new FormData(form);

            axios.post(apiUrl + '/pertanyaan/create', formData, {
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


        function deleteQuestionConfirmation(Id, Name) {
            document.getElementById('questionIdToDelete').value = Id;
            document.getElementById('questionnameToDelete').textContent = Name;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteQuestion() {
            const Id = document.getElementById('questionIdToDelete').value;

            axios.delete(apiUrl + '/pertanyaan/delete', {
                    data: {
                        pertanyaan_id: Id
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
