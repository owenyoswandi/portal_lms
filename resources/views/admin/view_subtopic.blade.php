@extends('layouts.user.base')

@section('title', 'Topic')
<style>
    .card-body {
        margin: 20px;
    }

    .selected-row {
        background-color: #f2f2f2;
    }

    #select-all {
        margin-top: 10px;
    }
</style>

@section('content')
    <div class="pagetitle">
        <h1 id="course_title"></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.course') }}">Manage Course</a></li>
                <li class="breadcrumb-item"><a id="link_course"></a></li>
                <li class="breadcrumb-item"><a id="link_course2"></a></li>
                <li class="breadcrumb-item active" id="subtopic_title"></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 id="subtopic_title2"></h5>
                        <div style="width: 100%;">
                            <div id="subtopic_container" style="width: 100%;"></div>
                            <!-- Feedback Display -->
                            <div id="feedbacks-container" class="mt-4"></div>
                            <!-- DataTable -->
                            <div id="submission_container" style="width: 100%; display: none;">
                                <table class="table" id="userDataTable">
                                    <thead>
                                        <tr>
                                            <th><input type="checkbox" id="select-all"></th>
                                            <th>Name</th>
                                            <th>Status</th>
                                            <th>Last Modified</th>
                                            <th>Grade</th>
                                            <th>Feedback Comment</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Data rows will be inserted dynamically -->
                                    </tbody>
                                </table>
                                <button id="download-selected" class="btn btn-primary" onclick="downloadSubmission()"
                                    disabled>Download Selected</button> <!-- Tombol Download -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

<script>
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
    const url    = "{{ rtrim(url('/'), '/') }}"; ;
    const accessToken = '{{ session('token') }}';
    const userId = '{{ session('userid') }}';

    const courseId = @json($p_id);
    const stId = @json($st_id);

    let subtopicName;

    let dataTable;
    let selectedSubmissions = [];

    document.addEventListener("DOMContentLoaded", () => {
        getCourseById(courseId);
        getData(stId);

        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked'); // Get if "Select All" checkbox is checked or not

            // Select/deselect all checkboxes on all pages
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

            // Update the selectedSubmissions array
            updateSelectedSubmissions();
        });

        // Event listener for individual checkbox changes
        $('#userDataTable tbody').on('change', '.select-participant', function() {
            var row = $(this).closest('tr'); // Get the row related to the checkbox

            if ($(this).prop('checked')) {
                row.addClass('selected-row'); // Add class "selected-row" when checked
            } else {
                row.removeClass('selected-row'); // Remove class "selected-row" when unchecked
            }

            // Update the selectedSubmissions array
            updateSelectedSubmissions();

            // Update the "select-all" checkbox based on the status of individual checkboxes
            var allChecked = $('.select-participant:checked').length === $('.select-participant')
            .length;
            $('#select-all').prop('checked',
            allChecked); // Check "select-all" if all individual checkboxes are checked
        });
    });

    function getCourseById(id) {
        axios.get(apiUrl + `/product/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
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
        document.getElementById('course_title').innerHTML = courseData.p_judul;
        document.getElementById('link_course').textContent = courseData.p_judul;
        document.getElementById('link_course').href = "{{ url('admin/view_course') }}/" + courseData.p_id;
        document.getElementById('link_course2').href = "{{ url('admin/view_course') }}/" + courseData.p_id;
    }

    function getData(id) {
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
        document.getElementById('subtopic_title2').innerHTML = subtopic.st_name;
        getDataTopic(subtopic.st_t_id);
        subtopicName = subtopic.st_name;
        const type = subtopic.st_jenis;
        const container = document.getElementById('subtopic_container');
        const body = document.createElement('div');
        body.classList.add("d-flex");
        body.classList.add("justify-content-center");
        body.classList.add("align-items-center");

        if (type == 'Task Collection') {
            // Table submission
            getDataSubmission(subtopic.st_id);
        } else if (type == 'Test') {
            // Table nilai ujian
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
                            <td>Shuffle Questions</td>
                            <td>${subtopic.st_is_shuffle === 1 ? 'Yes' : (subtopic.st_is_shuffle === 0 ? 'No' : '-') }</td>
                        </tr>
                        <tr>
                            <td>Grading Method</td>
                            <td>Highest grade</td>
                        </tr>
                    </tbody>
                </table></div>`;
            getDataTest(subtopic.st_id);
        } else if (type == 'Link') {
            body.innerHTML += `
            <iframe src="${subtopic.st_file}" width="800" height="400"></iframe>`;
        } else if (type == 'Feedback') {
            // Display feedback
            getFeedBackByCourseId(subtopic.st_id, userId);
        } else {
            body.innerHTML += `
			<object data="{{ url('public') }}/${subtopic.st_file}#toolbar=0" type="application/pdf" width="100%" height="600px">
			  <p>PDF tidak dapat ditampilkan. Silakan lihat PDF di browser Anda.</p>
			</object>`;
            <?php //<iframe src="{{ url('public') }}/${subtopic.st_file}" width="900" height="600"></iframe>`; ?>

        }

        container.appendChild(body);
    }

    function getDataTopic(id) {
        axios.get(apiUrl + `/topic/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    topic = data.data;
                    document.getElementById('link_course2').textContent = topic.t_name;
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function getDataSubmission(id) {
        axios.get(apiUrl + `/submission-bytask/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    updateTable(data.data);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Function to update the selectedSubmissions array
    function updateSelectedSubmissions() {
        selectedSubmissions = [];

        dataTable.rows().every(function() {
            var row = this.node();
            var checkbox = $(row).find('.select-participant');
            var smId = checkbox.data('sm-id'); // Get the sm-id data attribute

            // Only include rows with a valid sm-id and if they are checked
            if (checkbox.prop('checked') && smId != null && smId !== undefined) {
                selectedSubmissions.push(smId);
            }
        });
        updateDownloadButtonState();
    }

    function updateTable(Data) {
        document.getElementById("submission_container").style.display = "block";
        const tableBody = $('#userDataTable tbody');
        tableBody.empty();

        Data.forEach((d) => {
            const row = `<tr>
                            <td><input type="checkbox" class="select-participant" data-sm-id="${d.sm_id}"></td>
                            <td>${d.nama}</td>
                            <td>${d.sm_status != null ? 'Submitted' : 'No Submission'}</td>
                            <td>${d.sm_creadate != null ? d.sm_creadate : '-'}</td>
                            <td>${d.sm_grade != null ? d.sm_grade : '-'}</td>
                            <td>${d.sm_feedback_comment != null ? d.sm_feedback_comment : '-'}</td>
                            <td><a class="btn btn-info btn-sm mt-1" href="{{ url('admin/view_course/') }}/${courseId}/${stId}/${d.sm_id}">Grade</a></td>
                        </tr>`;
            tableBody.append(row);
        });

        initializeDataTable(); // Initialize or re-initialize the DataTable
        updateDownloadButtonState();
    }

    function initializeDataTable() {
        if (!dataTable) {
            dataTable = $('#userDataTable').DataTable({
                "pagingType": "simple_numbers",
                "responsive": true,
                columns: [{
                        orderable: false
                    }, // Disable sorting for checkbox column
                    {
                        orderable: true
                    }, // Enable sorting for Name column
                    {
                        orderable: true
                    }, // Enable sorting for Status column
                    {
                        orderable: true
                    }, // Enable sorting for Last Modified column
                    {
                        orderable: true
                    }, // Enable sorting for Last Modified column
                    {
                        orderable: true
                    }, // Enable sorting for Last Modified column
                    {
                        orderable: false
                    } // Disable sorting for Last Modified column
                ]
            });
        } else {
            dataTable.clear().draw(); // Redraw DataTable to update data
        }
    }

    // Update download button state based on selected checkboxes
    function updateDownloadButtonState() {
        // const selectedCheckboxes = $('.select-participant:checked');
        // selectedSubmissions = selectedCheckboxes.map(function() {
        //     return $(this).data('sm-id');
        // }).get();

        const downloadButton = $('#download-selected');
        downloadButton.prop('disabled', selectedSubmissions.length === 0);
    }

    function downloadSubmission() {
        if (selectedSubmissions.length > 0) {
            const formData = new FormData();
            formData.append("submissionIds", JSON.stringify(selectedSubmissions)); // Ensure to stringify array

            console.log(JSON.stringify(selectedSubmissions));

            axios.post(apiUrl + '/download-submission', formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    },
                    responseType: 'blob' //file atau zip
                })
                .then(response => {
                    // Handle file download
                    const contentDisposition = response.headers['content-disposition'];
                    const fileName = contentDisposition && contentDisposition.match(/filename="(.+)"/) ?
                        contentDisposition.match(/filename="(.+)"/)[1] : 'All_' + subtopicName + '.zip';

                    // Create a link to trigger the download
                    const blob = response.data;
                    const link = document.createElement('a');
                    link.href = URL.createObjectURL(blob);
                    link.download = fileName;
                    link.click();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        } else {
            alert('No submission selected for download.');
        }
    }

    function getDataTest(stId) {
        axios.get(apiUrl + `/hasil_test-bysubtopicid/${stId}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    const attemp = data.data;
                    updateViewTest(attemp.length);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

    }

    function displayFeedback(feedbackData) {
        const container = document.getElementById('feedbacks-container');

        if (!feedbackData || feedbackData.length === 0) {
            container.innerHTML = '<p class="text-muted">No feedback yet.</p>';
            return;
        }

        container.innerHTML = feedbackData.map(feedback => `
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-2">
                    ${getStarRating(feedback.rating)}
                </div>
                <p class="card-text">${feedback.feedback}</p>
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold">${feedback.nama}</span>
                    <span class="feedback-date">• ${formatDate(feedback.created_at)}</span>
                </div>
            </div>
        </div>
    `).join('');
    }

    function getStarRating(rating) {
        return Array(5).fill(0).map((_, index) =>
            `<i class="bi ${index < rating ? 'bi-star-fill' : 'bi-star'} text-warning"></i>`
        ).join('');
    }

    function formatDate(dateString) {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
    }

    function getFeedBackByCourseId(st_id, user_id) {
        axios.get(apiUrl + `/feedback-course-admin/${st_id}`, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        }).then(response => {
            const data = response.data;

            if (data.success) {
                displayFeedback(data.data);
            } else {
                console.error(data.message);
            }
        }).catch(error => {
            console.error('Error:', error);
        });
    }

    // function updateViewTest(Test, duedate){
    function updateViewTest(attemp) {
        const container = document.getElementById('subtopic_container');
        const body = document.createElement('div');
        body.style.width = '100%';

        body.innerHTML += `<p class="text-muted mt-3">Attempt: ${attemp != null ? attemp : '0'}</p>`;
        body.innerHTML += `<div class="col-lg-12"><a class="btn btn-primary btn-sm" href="{{ url('admin/view_test') }}/${courseId}/${stId}">
                    View Detail</a>
                </div>`;

        container.appendChild(body);
    }

	// Menonaktifkan klik kanan di seluruh halaman
    document.addEventListener("contextmenu", function(e) {
      e.preventDefault();
      alert("Klik kanan dibatasi pada PDF ini.");
    });
</script>
