@extends('layouts.user.base')

@section('title', 'Manage Course')

<style>
    #userDataTable2 {
        width: 100% !important; /* Sets the table width to 100% */
        table-layout: auto !important; /* Automatically adjusts the table layout */
    }
</style>

@section('content')
    <div class="pagetitle">
        <h1 id="subtopic_title1"></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.course') }}">Manage Course</a></li>
                <li class="breadcrumb-item"><a id="link_course"></a></li>
                <li class="breadcrumb-item"><a id="topic_title"></a></li>
                <li class="breadcrumb-item active" id="subtopic_title"></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Detail</h5>
                        <div id="subtopic_container" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title" id="subtopic_title2"></h5>
                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Type</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Questions Bank</h5>
                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable2">
                            <thead>
                                <tr>
                                    <th scope="col">Category</th>
                                    <th scope="col">Question</th>
                                    <th scope="col">Type</th>
                                    <th><input type="checkbox" id="select-all"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <button id="download-selected" class="btn btn-primary" onclick="addQuestion()" disabled>Add Selected Questions</button> <!-- Tombol Download -->

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
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Question</h5>
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
@endsection

<script>
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
    const url    = "{{ rtrim(url('/'), '/') }}";
    const accessToken = '{{ session('token') }}';

    const courseId = @json($p_id);
    const topicId = @json($t_id);
    const subtopicId = @json($st_id);

    let dataTable;
    let selectedQuestions = [];

    document.addEventListener("DOMContentLoaded", () => {
        getCourseById(courseId);
        getTopicById(topicId);
        getSubtopicById(subtopicId);
        getData(subtopicId);
        getQuestionBank(subtopicId, courseId);

        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked');
            if (isChecked) {
                // Select all rows on all pages
                dataTable.rows().every(function() {
                    var row = this.node();
                    var checkbox = $(row).find('.select-participant');
                    checkbox.prop('checked', true);
                    $(row).addClass('selected-row');
                });
            } else {
                // Deselect all rows on all pages
                dataTable.rows().every(function() {
                    var row = this.node();
                    var checkbox = $(row).find('.select-participant');
                    checkbox.prop('checked', false);
                    $(row).removeClass('selected-row');
                });
            }
            updateSelectedQuestions();
        });

        $('#userDataTable2 tbody').on('change', '.select-participant', function() {
            updateSelectedQuestions();

            var allChecked = $('.select-participant:checked').length === $('.select-participant').length;
            $('#select-all').prop('checked', allChecked);
        });
    });

    function initializeDataTable() {
        if (!dataTable) {
            dataTable = $('#userDataTable2').DataTable({
                "pagingType": "simple_numbers",
                "responsive": true,
                columns: [
                    { orderable: true },
                    { orderable: true },
                    { orderable: true },
                    { orderable: false }
                ]
            });
        }
    }

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
        document.getElementById('topic_title').textContent= topicData.t_name;
        document.getElementById('topic_title').href= "{{ url('admin/course/topic') }}/" + courseId + "/" + topicData.t_id;
    }

    function getSubtopicById(id) {
        axios.get(apiUrl + `/subtopic/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    displaySubtopic(data.data);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function displaySubtopic(subtopic) {
        document.getElementById('subtopic_title').innerHTML = subtopic.st_name;
        document.getElementById('subtopic_title1').innerHTML = subtopic.st_name + " Questions";
        document.getElementById('subtopic_title2').innerHTML = subtopic.st_name + " Questions";
        const container = document.getElementById('subtopic_container');
        const body = document.createElement('div');

        body.innerHTML += `<div style="width: 100%;">
            <div class="col-lg-12">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Attempts Allowed</td>
                        <td>${subtopic.st_attemp_allowed}</td>
                    </tr>
                    <tr>
                        <td>Closed On</td>
                        <td>${subtopic.st_due_date}</td>
                    </tr>
                    <tr>
                        <td>Time Limit</td>
                        <td>${subtopic.st_duration} mins</td>
                    </tr>
                    <tr>
                        <td>Grading Method</td>
                        <td>Highest grade</td>
                    </tr>
                </tbody>
        </table></div>`;

        container.appendChild(body);
    }

    function getData(id) {
        axios.get(apiUrl + '/subtopic_test-byid/' + id, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
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
        const questiontableBody = document.querySelector('#userDataTable tbody');
        questiontableBody.innerHTML = '';

        Data.forEach((d, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${index + 1}</td>
            <td>${d.kategori}</td>
            <td>${d.teks_pertanyaan}</td>
            <td>${d.tipe_pertanyaan}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="deleteQuestionConfirmation('${d.pertanyaan_id}', '${d.teks_pertanyaan}')">Delete</button>
            </td>`;
            questiontableBody.appendChild(row);
        });
        const table = new simpleDatatables.DataTable('#userDataTable');
    }

    function getQuestionBank(stId, course_id) {
        axios.get(apiUrl + `/subtopic_test_question-byid/${stId}/${course_id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    updateTableQuestionBank(data.data);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateTableQuestionBank(Data) {
        const tableBody = document.querySelector('#userDataTable2 tbody');
        tableBody.innerHTML = '';

        Data.forEach((d, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${d.kategori}</td>
            <td>${d.teks_pertanyaan}</td>
            <td>${d.tipe_pertanyaan}</td>
            <td><input type="checkbox" class="select-participant" data-pertanyaan-id="${d.pertanyaan_id}"></td>
        `;
            tableBody.appendChild(row);
        });

        if (!dataTable) {
        initializeDataTable();  // Initialize only if DataTable is not already initialized
        } else {
            dataTable.clear().rows.add($(tableBody).find('tr')).draw(); // Add the rows and redraw the table
        }
        updateDownloadButtonState();
    }

    function updateDownloadButtonState() {
        const downloadButton = $('#download-selected');
        downloadButton.prop('disabled', selectedQuestions.length === 0);
    }

    // Function to update the selectedQuestions array
    function updateSelectedQuestions() {
        selectedQuestions = [];

        dataTable.rows().every(function() {
            var row = this.node();
            var checkbox = $(row).find('.select-participant');
            var pertanyaanId = checkbox.data('pertanyaan-id'); // Get the pertanyaan-id data attribute

            // Only include rows with a valid pertanyaan-id and if they are checked
            if (checkbox.prop('checked') && pertanyaanId != null && pertanyaanId !== undefined) {
                selectedQuestions.push(pertanyaanId);
            }
        });
        updateDownloadButtonState();
    }

    function addQuestion() {
        if (selectedQuestions.length > 0) {
            const formData = new FormData();
            formData.append("pertanyaanIds", JSON.stringify(selectedQuestions));  // Ensure to stringify array
            formData.append("test_st_id", subtopicId);  // Ensure to stringify array

            axios.post(apiUrl + '/subtopic_test/create', formData, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    selectedQuestions = [];
                    getData(subtopicId);
                    getQuestionBank(subtopicId, courseId);
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
        } else {
            alert('No questions selected.');
        }
    }

    function deleteQuestionConfirmation(Id, Name) {
        document.getElementById('questionIdToDelete').value = Id;
        document.getElementById('questionnameToDelete').textContent = Name;
        const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteConfirmationModal.show();
    }

    function deleteQuestion() {
        const Id = document.getElementById('questionIdToDelete').value;

        axios.delete(apiUrl + '/subtopic_test/delete', {
            data: {
                test_st_id: subtopicId,
                test_pertanyaan_id: Id,
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
                getData(subtopicId);
                getQuestionBank(subtopicId, courseId);
            } else {
                console.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>
