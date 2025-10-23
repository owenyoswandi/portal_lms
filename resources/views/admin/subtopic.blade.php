@extends('layouts.user.base')

@section('title', 'Manage Course')

@section('content')
    <div class="pagetitle">
        <h1 id="topic_title1">Manage Course</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.course') }}">Manage Course</a></li>
                <li class="breadcrumb-item"><a id="link_course"></a></li>
                <li class="breadcrumb-item active" id="topic_title"></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <!-- <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Detail Topic</h5>
                    </div>
                </div> -->
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add Subtopic
                    </button>
                </div>
                @include('component.admin.subtopic_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Subtopic</h5>

                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Start date</th>
                                    <th>Duedate</th>
                                    <th>Duration</th>
                                    <th>Attempt Allowed</th>
                                    <th>Shuffle Questions</th>
                                    <th>Questions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.subtopic_edit_modal')
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
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Subtopic</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store topic ID -->
                        <input type="hidden" id="subtopicIdToDelete">
                        <p>Are you sure delete <span id="subtopicNameToDelete"></span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteSubtopic()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const courseId = @json($p_id); // This safely converts the PHP variable to a JavaScript value
        const topicId = @json($t_id);

        document.addEventListener("DOMContentLoaded", () => {
            getCourseById(courseId);
            getTopicById(topicId);
            getData(topicId);
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
            document.getElementById('link_course').textContent= courseData.p_judul;
            document.getElementById('link_course').href= "{{ url('admin/course/topic') }}/" + courseData.p_id;
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
                        displayTopic(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayTopic(topicData) {
            document.getElementById('topic_title1').innerHTML= topicData.t_name;
            document.getElementById('topic_title').innerHTML= topicData.t_name;
        }

        function getData(id) {
            axios.get(apiUrl + `/subtopic-bytopicid/${id}`, {
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
            <td>${d.st_name}</td>
            <td>${d.st_jenis}</td>
            <td>${d.st_start_date != null ? d.st_start_date : '-' }</td>
            <td>${d.st_due_date != null ? d.st_due_date : '-' }</td>
            <td>${d.st_duration != null ? d.st_duration : '-' }</td>
            <td>${d.st_attemp_allowed != null ? d.st_attemp_allowed : '-' }</td>
            <td>${d.st_is_shuffle === 1 ? 'Yes' : (d.st_is_shuffle === 0 ? 'No' : '-') }</td>
            <td>${d.st_is_shuffle === 1 ? d.st_jumlah_shuffle : '-' }</td>
            <td>
                <button class="btn btn-warning btn-sm" onclick="getSubtopicById('${d.st_id}')">Edit</button>
                <button class="btn btn-danger btn-sm" onclick="deleteSubtopicConfirmation('${d.st_id}', '${d.st_name}')">Hapus</button>
                ${d.st_jenis === 'Test' ? `<a class="btn btn-info btn-sm" href="{{ url('admin/course/topic') }}/${courseId}/${d.st_t_id}/${d.st_id}">Questions</a>` : ``}
            </td>
        `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

        document.getElementById('st_jenis').addEventListener('change', function(e) {
            // Get the selected value
            const selectedValue = document.getElementById('st_jenis').value;

            const config = {
                'Modul': { inputfile: 'block', inputstartdate: 'none', inputduedate: 'none', inputlink: 'none' },
                'Task': { inputfile: 'block', inputstartdate: 'none', inputduedate: 'block', inputlink: 'none' },
                'Test': { inputfile: 'none', inputstartdate: 'block', inputduedate: 'block', inputlink: 'none' },
                'Task Collection': { inputfile: 'none', inputstartdate: 'none', inputduedate: 'block', inputlink: 'none' },
                'Link': { inputfile: 'none', inputstartdate: 'none', inputduedate: 'none', inputlink: 'block' },
                
            };

            const defaultConfig = { inputfile: 'none', inputstartdate: 'none', inputduedate: 'none', inputlink: 'none' };

            // Get the configuration based on selectedValue or fallback to defaultConfig
            const currentConfig = config[selectedValue] || defaultConfig;

            // Apply the styles to the elements
            document.getElementById('inputfile').style.display = currentConfig.inputfile;
            document.getElementById('inputstartdate').style.display = currentConfig.inputstartdate;
            document.getElementById('inputduedate').style.display = currentConfig.inputduedate;
            document.getElementById('inputlink').style.display = currentConfig.inputlink;

            
        });
        document.getElementById('edit_st_jenis').addEventListener('change', function(e) {
            // Get the selected value
            const selectedValue = document.getElementById('edit_st_jenis').value;
            editHide(selectedValue);
        });

        function editHide(selectedValue){
            const config = {
                'Modul': { edit_inputfile: 'block', edit_inputstartdate: 'none', edit_inputduedate: 'none', edit_inputlink: 'none' },
                'Task': { edit_inputfile: 'block', edit_inputstartdate: 'none', edit_inputduedate: 'block', edit_inputlink: 'none' },
                'Test': { edit_inputfile: 'none', edit_inputstartdate: 'block', edit_inputduedate: 'block', edit_inputlink: 'none' },
                'Task Collection': { edit_inputfile: 'none', edit_inputstartdate: 'none', edit_inputduedate: 'block', edit_inputlink: 'none' },
                'Link': { edit_inputfile: 'none', edit_inputstartdate: 'none', edit_inputduedate: 'none', edit_inputlink: 'block' },
            };

            const defaultConfig = { edit_inputfile: 'none', edit_inputstartdate: 'none', edit_inputduedate: 'none', edit_inputlink: 'none' };

            // Get the configuration based on selectedValue or fallback to defaultConfig
            const currentConfig = config[selectedValue] || defaultConfig;

            // Apply the styles to the elements
            document.getElementById('edit_inputfile').style.display = currentConfig.edit_inputfile;
            document.getElementById('edit_inputstartdate').style.display = currentConfig.edit_inputstartdate;
            document.getElementById('edit_inputduedate').style.display = currentConfig.edit_inputduedate;
            document.getElementById('edit_inputlink').style.display = currentConfig.edit_inputlink;

        }

        const pdfPreview = document.getElementById('pdfPreview');
        document.getElementById('st_file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                pdfPreview.src = e.target.result;
                pdfPreview.style.display = 'block';
                };
                
                reader.readAsDataURL(file);
            } else {
                pdfPreview.src = '';
                alert("Please select a valid PDF file.");
            }
        });

        function addSubtopic() {
            const form = document.getElementById('addSubtopicForm');

            const dateTime = new Date().toISOString().split('T'); // ["YYYY-MM-DD", "HH:mm:ss.sssZ"]
            const formattedDateTime = `${dateTime[0]} ${dateTime[1].split('.')[0]}`; //hapus milidetik

            document.getElementById('st_creadate').value = formattedDateTime;
            document.getElementById('st_t_id').value = topicId;

            // if (!form.checkValidity()) {
            //     form.classList.add('was-validated');
            //     return;
            // }

            const formData = new FormData(form);

            axios.post(apiUrl + '/subtopic', formData, {
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
                        document.getElementById('pdfPreview').classList.add('d-none');
                        var myModalEl = document.getElementById('exampleModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData(topicId);
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

        function getSubtopicById(id) {
            axios.get(apiUrl + `/subtopic/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    console.log(data)
                    if (data.success) {
                        displayEditSubtopicModal(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayEditSubtopicModal(subtopicData) {
            const editSubtopicModal = new bootstrap.Modal(document.getElementById('editSubtopicModal'));
            populateEditTubtopicForm(subtopicData);
            editSubtopicModal.show();
        }

        const editpdfPreview = document.getElementById('edit_pdfPreview');
        document.getElementById('edit_st_file').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type === 'application/pdf') {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                editpdfPreview.src = e.target.result;
                editpdfPreview.style.display = 'block';
                };
                
                reader.readAsDataURL(file);
            } else {
                editpdfPreview.src = '';
                alert("Please select a valid PDF file.");
            }
        });

        function populateEditTubtopicForm(subtopicData) {
            document.getElementById('edit_st_id').value = subtopicData.st_id;
            document.getElementById('edit_st_name').value = subtopicData.st_name;
            document.getElementById('edit_st_jenis').value = subtopicData.st_jenis;
            document.getElementById('edit_st_due_date').value = subtopicData.st_due_date;
            document.getElementById('edit_st_start_date').value = subtopicData.st_start_date;
            document.getElementById('edit_st_duration').value = subtopicData.st_duration;
            document.getElementById('edit_st_attemp_allowed').value = subtopicData.st_attemp_allowed;
            document.getElementById('edit_st_is_shuffle').value = subtopicData.st_is_shuffle || '';
            document.getElementById('edit_st_jumlah_shuffle').value = subtopicData.st_jumlah_shuffle || '';
            if(subtopicData.st_jenis=='Modul' || subtopicData.st_jenis=='task'){
                editpdfPreview.src = `${url}/public/${subtopicData.st_file}`;
                editpdfPreview.style.display = 'block';
            } else if(subtopicData.st_jenis=='Link') {
                document.getElementById('edit_st_file_else').value = subtopicData.st_file;
            }

            editHide(subtopicData.st_jenis);
        }

        function updateSubtopic() {
            const form = document.getElementById('editSubtopicForm');
            // if (!form.checkValidity()) {
            //     form.classList.add('was-validated');
            //     return;
            // }

            const formData = new FormData(form);
            const subtopicId = document.getElementById('edit_st_id').value; // Get the ID

            const dateTime = new Date().toISOString().split('T'); // ["YYYY-MM-DD", "HH:mm:ss.sssZ"]
            const formattedDateTime = `${dateTime[0]} ${dateTime[1].split('.')[0]}`; //hapus milidetik

            document.getElementById('edit_st_modidate').value = formattedDateTime;

            console.log(formData);

            axios.post(apiUrl + `/subtopic/${subtopicId}?_method=PUT`, formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Subtopic updated successfully.');
                        var myModalEl = document.getElementById('editSubtopicModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl);
                        modal.hide();
                        getData(topicId);
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

        function deleteSubtopicConfirmation(subtopicId, subtopicName) {
            document.getElementById('subtopicIdToDelete').value = subtopicId;
            document.getElementById('subtopicNameToDelete').textContent = subtopicName;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteSubtopic() {
            const subtopicId = document.getElementById('subtopicIdToDelete').value;

            axios.delete(apiUrl + `/subtopic/${subtopicId}`, {
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
                        getData(topicId);
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
