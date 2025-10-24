@extends('layouts.user.base')

@section('title', 'Manage Course')

@section('content')
    <div class="pagetitle">
        <h1>Manage Course</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Manage Course</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Course
                    </button>
                </div>
                @include('component.admin.course_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Course</h5>

                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <!-- <th>Image</th> -->
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.course_edit_modal')
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
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store course ID -->
                        <input type="hidden" id="courseIdToDelete">
                        <p>Are you sure to delete <span id="coursenameToDelete"></span> course ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteCourse()">Delete</button>
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
            axios.get(apiUrl + '/product', {
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
            <td>${d.p_deskripsi}</td>
            <td>${d.p_start_date != null ? d.p_start_date : '-' }</td>
            <td>${d.p_end_date != null ? d.p_end_date : '-' }</td>
            <td>IDR ${Number(d.p_harga).toLocaleString()}</td>
            <td style='text-align: left'>${d.p_status == '0' ? '<span class="badge rounded-pill bg-danger">Hide</span>' : '<span class="badge rounded-pill bg-success">Show</span>'}</td>
            <td>

                <button class="btn btn-warning btn-sm" onclick="getCourseById('${d.p_id}')">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteCourseConfirmation('${d.p_id}', '${d.p_judul}')">Hapus</button>
                <a class="btn btn-info btn-sm mt-1" href="{{ url('admin/course/topic') }}/${d.p_id}">Topic</a>
                <a class="btn btn-secondary btn-sm mt-1" href="{{ url('admin/view_course') }}/${d.p_id}">View</a>
            </td>
        `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

        function displayEditGroupModal(courseData) {
            const editCourseModal = new bootstrap.Modal(document.getElementById('editCourseModal'));
            populateEditGroupForm(courseData);
            editCourseModal.show();
        }

        function populateEditGroupForm(courseData) {
            document.getElementById('edit_p_id').value = courseData.p_id;
            document.getElementById('edit_p_judul').value = courseData.p_judul;
            document.getElementById('edit_p_deskripsi').value = courseData.p_deskripsi;
            document.getElementById('edit_p_start_date').value = courseData.p_start_date;
            document.getElementById('edit_p_end_date').value = courseData.p_end_date;
            document.getElementById('edit_p_harga').value = courseData.p_harga;
            document.getElementById('edit_p_status').value = courseData.p_status;

            const logoPreviewImg = document.querySelector('#editLogoPreview img');
            if (courseData.p_img) {
                logoPreviewImg.src = `${url}/${courseData.p_img}`;
                document.querySelector('#editLogoPreview').classList.remove('d-none');
            }
        }

        document.getElementById('p_img').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                if (file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                const preview = document.getElementById('logoPreview');
                const previewImg = preview.querySelector('img');

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('d-none');
                }

                reader.readAsDataURL(file);
            }
        });

        document.getElementById('edit_p_img').addEventListener('change', function(e) {
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

        function getCourseById(id) {
            axios.get(apiUrl + `/product/${id}`, {
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


        function updateCourse() {
            const dateTime = new Date().toISOString().split('T'); // ["YYYY-MM-DD", "HH:mm:ss.sssZ"]
            const formattedDateTime = `${dateTime[0]} ${dateTime[1].split('.')[0]}`; //hapus milidetik

            document.getElementById('edit_p_modified_date').value = formattedDateTime; //dummy

            const form = document.getElementById('editCourseForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            const courseId = document.getElementById('edit_p_id').value; // Get the ID

            axios.post(apiUrl + `/product/${courseId}?_method=PUT`, formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Course updated successfully.');
                        var myModalEl = document.getElementById('editCourseModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Updating course failed:', data.message);
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

        function addCourse() {
            const form = document.getElementById('addCourseForm');

            const dateTime = new Date().toISOString().split('T'); // ["YYYY-MM-DD", "HH:mm:ss.sssZ"]
            const formattedDateTime = `${dateTime[0]} ${dateTime[1].split('.')[0]}`; //hapus milidetik

            document.getElementById('p_jenis').value = 'course';
            document.getElementById('p_id_lms').value = '1'; //dummy
            document.getElementById('p_url_lms').value = 'https://'; //dummy
            document.getElementById('p_created_date').value = formattedDateTime; //dummy


            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);

            axios.post(apiUrl + '/product', formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Course added successfully.');
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


        function deleteCourseConfirmation(courseId, courseName) {
            document.getElementById('courseIdToDelete').value = courseId;
            document.getElementById('coursenameToDelete').textContent = courseName;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteCourse() {
            const courseId = document.getElementById('courseIdToDelete').value;

            axios.delete(apiUrl + `/product/${courseId}`, {
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
