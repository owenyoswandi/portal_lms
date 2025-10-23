@extends('layouts.user.base')

@section('title', 'Manage Group')

@section('content')
    <div class="pagetitle">
        <h1>Manage Group</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Manage Group</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Group
                    </button>
                </div>
                @include('component.admin.group_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Group</h5>


                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <!-- <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Alamat</th>
                                    <th scope="col">No Telepon</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Aksi</th> -->

                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Phone Number</th>
                                    <th scope="col">Logo</th>
                                    <th scope="col">Courses</th>
                                    <th scope="col">Peserta</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.group_edit_modal')
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
                        <input type="hidden" id="groupIdToDelete">
                        <p>Are you sure you want to delete <span id="groupnameToDelete"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteGroup()">Hapus</button>
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
            axios.get(apiUrl + '/group', {
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
                <td>${d.group_name}</td>
                <td>${d.group_email}</td>
                <td>${d.group_alamat}</td>
                <td>${d.group_phone}</td>
                <td><img src="${url}/public/${d.group_logo}" alt="Group Logo" class="img-thumbnail" style="max-height: 50px;"></td>
                <td>${d.accesses_count}</td>
                <td>${d.members_count}</td>
                 <td>
                    <button class="btn btn-warning btn-sm" onclick="getGroupById('${d.group_id}')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteGroupConfirmation('${d.group_id}', '${d.group_name}')">Delete</button>
                    <a class="btn btn-info btn-sm text-white" href="{{ url('admin-group') }}/${d.group_id}">Courses</a>
                    <a class="btn btn-secondary btn-sm text-white" href="{{ url('admin-group/member') }}/${d.group_id}">Peserta</a>
                </td>
                `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

        function displayEditGroupModal(groupData) {
            const editGroupModal = new bootstrap.Modal(document.getElementById('editGroupModal'));
            populateEditGroupForm(groupData);
            editGroupModal.show();
        }


        function populateEditGroupForm(groupData) {
            document.getElementById('edit_group_id').value = groupData.group_id;
            document.getElementById('edit_group_name').value = groupData.group_name;
            document.getElementById('edit_group_email').value = groupData.group_email;
            document.getElementById('edit_group_phone').value = groupData.group_phone;
            document.getElementById('edit_group_alamat').value = groupData.group_alamat;

            const logoPreviewImg = document.querySelector('#editLogoPreview img');
            if (groupData.group_logo) {
                logoPreviewImg.src = `${url}/public/${groupData.group_logo}`;
                document.querySelector('#editLogoPreview').classList.remove('d-none');
            }
        }

        document.getElementById('edit_group_logo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                const previewImg = document.querySelector('#editLogoPreview img');

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                }

                reader.readAsDataURL(file);
            }
        });

        function setSelectOption(selectElement, value) {
            const options = selectElement.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === value) {
                    options[i].selected = true;
                    break;
                }
            }
        }

        function getGroupById(id) {
            axios.get(apiUrl + `/group/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log(data)
                    if (data.success) {
                        displayEditGroupModal(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function updateGroup() {
            const form = document.getElementById('editGroupForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            const groupId = document.getElementById('edit_group_id').value; // Get the ID

            axios.post(apiUrl + `/group/${groupId}?_method=PUT`, formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Group updated successfully.');
                        var myModalEl = document.getElementById('editGroupModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Updating group failed:', data.message);
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

        function addGroup() {
            const form = document.getElementById('addGroupForm');


            document.getElementById('group_creadate').value = new Date().toISOString().split('T')[0];
            document.getElementById('group_creaby').value = 'current_user'; // Replace with actual user ID or name

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);

            axios.post(apiUrl + '/group', formData, {
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
                        document.getElementById('logoPreview').classList.add('d-none');
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


        function deleteGroupConfirmation(groupId, groupName) {
            document.getElementById('groupIdToDelete').value = groupId;
            document.getElementById('groupnameToDelete').textContent = groupName;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteGroup() {
            const groupId = document.getElementById('groupIdToDelete').value;

            axios.delete(apiUrl + `/group/${groupId}`, {
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
