@extends('layouts.user.base')

@section('title', 'Manage Course')

@section('content')
    <div class="pagetitle">
        <h1 id="course_title1">Manage Course</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.course') }}">Manage Course</a></li>
                <li class="breadcrumb-item active" id="course_title"></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Detail Course</h5>
                    </div>
                </div> -->
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Topic
                    </button>
                </div>
                @include('component.admin.topic_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Topic</h5>

                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Title</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.topic_edit_modal')
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
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Topic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store topic ID -->
                        <input type="hidden" id="topicIdToDelete">
                        <p>Are you sure delete <span id="topicNameToDelete"></span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteTopic()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const courseId = @json($id); // This safely converts the PHP variable to a JavaScript value

        document.addEventListener("DOMContentLoaded", () => {
            getCourseById(courseId);
            getData(courseId);
        });

        const apiUrl = '{{ config('app.api_url') }}';
        const url = '{{ config('app.app_url') }}'
        const accessToken = '{{ session('token') }}';
        
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
                        displayCourse(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayCourse(courseData) {
            document.getElementById('course_title1').innerHTML= courseData.p_judul;
            document.getElementById('course_title').innerHTML= courseData.p_judul;
        }

        function getData(id) {
            axios.get(apiUrl + `/topic-byproductid/${id}`, {
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
                <td>${d.t_name}</td>
                <td>
                    <a class="btn btn-info btn-sm" href="{{ url('admin/course/topic') }}/${d.t_p_id}/${d.t_id}">Subtopic</a>
                    <button class="btn btn-warning btn-sm" onclick="getTopicById('${d.t_id}')">Edit</button>
                    <button class="btn btn-danger btn-sm" onclick="deleteTopicConfirmation('${d.t_id}', '${d.t_name}')">Hapus</button>
                </td>
            `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

        function addTopic() {
            const form = document.getElementById('addTopicForm');

            const dateTime = new Date().toISOString().split('T'); // ["YYYY-MM-DD", "HH:mm:ss.sssZ"]
            const formattedDateTime = `${dateTime[0]} ${dateTime[1].split('.')[0]}`; //hapus milidetik

            document.getElementById('t_p_id').value = courseId;
            document.getElementById('t_creadate').value = formattedDateTime;

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);

            axios.post(apiUrl + '/topic', formData, {
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
                        var myModalEl = document.getElementById('exampleModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData(courseId);
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

        function getTopicById(id) {
            axios.get(apiUrl + `/topic/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log(data)
                    if (data.success) {
                        displayEditTopicModal(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayEditTopicModal(topicData) {
            const editTopicModal = new bootstrap.Modal(document.getElementById('editTopicModal'));
            populateEditTopicForm(topicData);
            editTopicModal.show();
        }

        function populateEditTopicForm(topicData) {
            document.getElementById('edit_t_id').value = topicData.t_id;
            document.getElementById('edit_t_name').value = topicData.t_name;
        }

        function updateTopic() {
            const dateTime = new Date().toISOString().split('T'); // ["YYYY-MM-DD", "HH:mm:ss.sssZ"]
            const formattedDateTime = `${dateTime[0]} ${dateTime[1].split('.')[0]}`; //hapus milidetik
            document.getElementById('edit_t_modidate').value = formattedDateTime; //dummy

            const form = document.getElementById('editTopicForm');
            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }

            const formData = new FormData(form);
            const topicId = document.getElementById('edit_t_id').value; // Get the ID

            axios.post(apiUrl + `/topic/${topicId}?_method=PUT`, formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Topic updated successfully.');
                        var myModalEl = document.getElementById('editTopicModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData(courseId);
                    } else {
                        console.error('Updating topic failed:', data.message);
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

        function deleteTopicConfirmation(topicId, topicName) {
            document.getElementById('topicIdToDelete').value = topicId;
            document.getElementById('topicNameToDelete').textContent = topicName;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteTopic() {
            const topicId = document.getElementById('topicIdToDelete').value;
            
            // delete all subtopic too
            getSubtopic(topicId);

            axios.delete(apiUrl + `/topic/${topicId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getSubtopic(id) {
            axios.get(apiUrl + `/subtopic-bytopicid/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data);
                        deleteSubtopic(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function deleteSubtopic(subtopic) {
            subtopic.forEach((d, index) => {
                axios.delete(apiUrl + `/subtopic/${d.st_id}`, {
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
                        getData(courseId);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        }

        //subtopic
        // <button class="btn btn-info btn-sm" onclick="getSubTopicById('${d.t_id}', '${d.t_name}')">Sub-Topic</button>
        // function getSubTopicById(id, name) {
        //     axios.get(apiUrl + `/subtopic-bytopicid/${id}`, {
        //             headers: {
        //                 'Authorization': `Bearer ${accessToken}`
        //             }
        //         })
        //         .then(response => {
        //             const data = response.data;
        //             console.log(data)
        //             if (data.success) {
        //                 displaySubtopicModal(data.data, id, name);
        //             } else {
        //                 console.error(data.message);
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //         });
        // }

        // function displaySubtopicModal(subtopicData, $t_id, name) {
        //     const SubtopicViewModal = new bootstrap.Modal(document.getElementById('SubtopicViewModal'));
        //     document.getElementById('view_t_id').value = $t_id;
        //     document.getElementById('SubtopicViewModalLabel').innerHTML = 'Subtopic '+name;
        //     updateTableSubtopic(subtopicData);
        //     SubtopicViewModal.show();
        // }

        // function updateTableSubtopic(subtopicData) {
        //     const tableBody2 = document.querySelector('.table2 tbody');
        //     tableBody2.innerHTML = '';

        //     subtopicData.forEach((d, index) => {
        //         const row = document.createElement('tr');
        //         row.innerHTML = `
        //             <td>${index + 1}</td>
        //             <td>${d.st_name}</td>
        //             <td>
        //                 <button class="btn btn-warning btn-sm" onclick="getTopicById('${d.st_id}')">Edit</button>
        //                 <button class="btn btn-danger btn-sm" onclick="deleteTopicConfirmation('${d.st_id}', '${d.st_name}')">Hapus</button>
        //             </td>
        //         `;
        //         tableBody2.appendChild(row);
        //     });
        //     const dataTable2 = new simpleDatatables.DataTable('#subtopicDataTable');
        // }
    </script>

@endsection
