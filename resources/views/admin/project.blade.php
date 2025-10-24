@extends('layouts.user.base')

@section('title', 'Kelola Project')

@section('content')
    <div class="pagetitle">
        <h1>Kelola Project</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Kelola Project</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end my-3">
                    <a href="{{ url('/member/project/add') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Add Project
                    </a>
                </div>

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Project</h5>


                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Nama Project</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Completion</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
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
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Project</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store group ID -->
                        <input type="hidden" id="projectIdToDelete">
                        <p>Anda yakin akan menghapus project <span id="projectnameToDelete"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteProject()">Hapus</button>
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
            axios.get(apiUrl + '/project', {
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

        function formatDate(dateString) {
            return new Date(dateString).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        function updateTable(Data) {
            const tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = '';

            Data.forEach((d, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
					<td>${index + 1}</td>
					<td>${d.project_name}</td>
					<td>${d.project_desc}</td>
					<td>${formatDate(d.start_date)}</td>  <!-- Mengubah format start_date -->
					<td>${formatDate(d.end_date)}</td>    <!-- Mengubah format end_date -->
					<td>${d.completion}%</td>
					<td>${d.status}</td>
					<td>
						<div class="d-flex gap-2 flex-column">
							<a href='${url}/member/project/${d.project_id}' class="btn btn-warning btn-sm">View</a>
							<button class="btn btn-danger btn-sm" onclick="deleteProjectConfirmation('${d.project_id}', '${d.project_name}')">Hapus</button>
						</div>
					</td>
				`;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

		// Fungsi untuk memformat tanggal menjadi dd-MM-yyyy
		function formatDate(dateString) {
			const date = new Date(dateString);
			const day = date.getDate().toString().padStart(2, '0');  // Menambahkan 0 di depan jika hari < 10
			const month = (date.getMonth() + 1).toString().padStart(2, '0');  // Bulan dimulai dari 0, jadi perlu ditambah 1
			const year = date.getFullYear();

			return `${day}-${month}-${year}`;
		}


        function deleteProjectConfirmation(projectId, projectName) {
            document.getElementById('projectIdToDelete').value = projectId;
            document.getElementById('projectnameToDelete').textContent = projectName;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteProject() {
            const projectId = document.getElementById('projectIdToDelete').value;
            axios.put(apiUrl + `/project-delete/${projectId}`, {}, {
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
