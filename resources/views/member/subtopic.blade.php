@extends('layouts.user.base')

@section('title', 'Topic')
<style>
    .card-body {
        margin: 20px;
        /* color: #0f6fc5; */
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    table td:first-child {
        width: 250px;
    }

    .disabled {
        pointer-events: none;
        color: gray;
        text-decoration: none;
    }

    #feedback-card, #score_container {
        display: none;
    }
</style>
@section('content')
    <div class="pagetitle">
        <h1 id="course_title"></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('member/course') }}">My Course</a></li>
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
                            <div id="test_container" style="width: 100%;"></div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-12" id="score_container">
                <div class="card">
                    <div class="card-body">
                    <h5>Score Attemp</h5>
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Status</th>
                                    <th>Started On</th>
                                    <th>Score</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card" id="feedback-card">
                    <div class="card-body">
                        <h4 class="card-title">Course Feedback</h4>
                        <div class="bg-light p-4 rounded mb-4">
                            <h5 class="mb-3">Submit Your Feedback</h5>
                            <div class="mb-3">
                                <label class="form-label">Rating</label>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="stars">
                                        <i class="bi bi-star fs-4" data-rating="1"></i>
                                        <i class="bi bi-star fs-4" data-rating="2"></i>
                                        <i class="bi bi-star fs-4" data-rating="3"></i>
                                        <i class="bi bi-star fs-4" data-rating="4"></i>
                                        <i class="bi bi-star fs-4" data-rating="5"></i>
                                    </div>
                                    <span id="selected-rating" class="text-muted">0/5</span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="feedback-text" class="form-label">Your Feedback</label>
                                <textarea id="feedback-text" class="form-control" rows="4"
                                    placeholder="Share your experience with this course..."></textarea>
                            </div>
                            <button id="submit-feedback" class="btn btn-primary" disabled>Submit Feedback</button>
                        </div>

                        <div>
                            {{-- <h5 class="mb-3">Course Review</h5> --}}
                            <div id="feedbacks-container">
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        </div>

        <!-- Start Exam Confirmation Modal -->
        <div class="modal fade" id="startExamConfirmationModal" tabindex="-1"
            aria-labelledby="startExamConfirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="startExamConfirmationModalLabel">Start Test</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store topic ID -->
                        <input type="hidden" id="topicIdToDelete">
                        <p>Are you ready to start the test <span id="judulTest"></span> ?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" onclick="startTest()">Start</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

<!-- silahkan isi dengan java script -->
<script>
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
    const url    = "{{ rtrim(url('/'), '/') }}";
    const accessToken = '{{ session('token') }}';
    const accessMember = '{{ session('usermember') }}';
    const userId = '{{ session('userid') }}';

    const courseId = @json($p_id);
    const stId = @json($st_id);

    window.onload = function() {
        getCourseById(courseId);
        getData(stId);
        // getFeedBackByCourseId(stId, userId);
        // getBalance();
    };

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
        document.getElementById('course_title').innerHTML = courseData.p_judul;
        document.getElementById('link_course').textContent = courseData.p_judul;
        document.getElementById('link_course').href = "{{ url('member/course/topic') }}/" + courseData.p_id;
        document.getElementById('link_course2').href = "{{ url('member/course/topic') }}/" + courseData.p_id;
    }

    function getBalance() {
        axios.get(apiUrl + '/transaction-balance-byuserid/' + userId, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    let amount_balance = Number(data.data).toLocaleString();
                    document.getElementById('balance_all').innerHTML = "IDR " + amount_balance;
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
        const feedbackForm = document.querySelector('.bg-light.p-4');

        const userFeedback = feedbackData.find(feedback => feedback.user_id == userId);
        console.log(feedbackData);
        if (userFeedback) {
            feedbackForm.style.display = 'none';
        }

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

    // Add this to your window.onload function or document ready
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.stars i');
        const ratingDisplay = document.getElementById('selected-rating');
        const feedbackText = document.getElementById('feedback-text');
        const submitButton = document.getElementById('submit-feedback');
        let selectedRating = 0;

        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const rating = this.dataset.rating;
                updateStars(rating);
            });

            star.addEventListener('mouseout', function() {
                updateStars(selectedRating);
            });

            star.addEventListener('click', function() {
                selectedRating = this.dataset.rating;
                updateStars(selectedRating);
                updateSubmitButton();
            });
        });

        function updateStars(rating) {
            stars.forEach(star => {
                const starRating = star.dataset.rating;
                star.classList.remove('bi-star', 'bi-star-fill');
                star.classList.add(starRating <= rating ? 'bi-star-fill' : 'bi-star');
            });
            ratingDisplay.textContent = `${rating}/5`;
        }

        feedbackText.addEventListener('input', updateSubmitButton);

        function updateSubmitButton() {
            submitButton.disabled = !(selectedRating > 0 && feedbackText.value.trim());
        }

        submitButton.addEventListener('click', function() {
            const feedback = {
                subtopic_id: stId,
                course_id: courseId,
                rating: selectedRating,
                feedback: feedbackText.value.trim(),
                user_id: userId
            };

            submitButton.disabled = true;
            submitButton.innerHTML =
                `<span class="spinner-border spinner-border-sm me-2"></span>Submitting...`;

            axios.post(apiUrl + '/feedback', feedback, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    if (response.data.success) {
                        const alertHtml = `
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        Thank you for your feedback!
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;
                        document.querySelector('.card-body').insertAdjacentHTML('afterbegin',
                            alertHtml);

                        // Reset form
                        selectedRating = 0;
                        feedbackText.value = '';
                        updateStars(0);
                        updateSubmitButton();

                        // Refresh feedback list
                        getFeedBackByCourseId(stId, userId);
                    } else {
                        throw new Error(response.data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    const alertHtml = `
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    Error submitting feedback. Please try again.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
                    document.querySelector('.card-body').insertAdjacentHTML('afterbegin',
                        alertHtml);
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Submit Feedback';
                });
        });
    });

    function getFeedBackByCourseId(st_id, user_id) {
        axios.get(apiUrl + `/feedback-course/${st_id}/${user_id}`, {
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

    function getData(id) {
        axios.get(apiUrl + `/subtopic/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
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
        const type = subtopic.st_jenis;
        const container = document.getElementById('subtopic_container');
        const body = document.createElement('div');
        body.classList.add("d-flex");
        body.classList.add("justify-content-center");
        body.classList.add("align-items-center");
        if (type == 'Task Collection') {
            //drag and drop area
            getDataSubmission(subtopic.st_id, subtopic.st_due_date);
        } else if (type == 'Test') {
            getDataTest(subtopic.st_attemp_allowed, subtopic.st_due_date);
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
        } else if (type == 'Link') {
            body.innerHTML += `
                <iframe src="${subtopic.st_file}" width="800" height="400"></iframe>`;
        } else if(type== 'Feedback'){
            document.getElementById('feedback-card').style.display = 'block';
            getFeedBackByCourseId(subtopic.st_id, userId);

        }else {
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
                    console.log(data.data);
                    document.getElementById('link_course2').textContent = topic.t_name;
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function getDataSubmission(id, duedate) {
        axios.get(apiUrl + `/submission-bytaskUser/${id}/${userId}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    updateViewSubmission(data.data, duedate)
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateViewSubmission(submission, duedate) {
        const container = document.getElementById('subtopic_container');
        const body = document.createElement('div');
        body.style.width = '100%';

        const timeRemainingText = timeRemaining(duedate);
        const isOverdue = timeRemainingText === "Overdue!";

        let submissionStatus = submission ? "You already made a submission." : "You have not made a submission yet.";
        let gradingStatus = submission?.sm_grade ?? 'Not Yet Graded';
        let feedbackComment = submission?.sm_feedback_comment ?? '-';
        let lastModified = submission?.sm_modidate ?? submission?.sm_creadate ?? '-';

        body.innerHTML = `
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <tbody>
                            <tr><td>Submission Status</td><td>${submission ? 'Attempt' : 'No attempt'}</td></tr>
                            <tr><td>Grading Status</td><td>${gradingStatus}</td></tr>
                            <tr><td>Time remaining</td><td>${timeRemainingText}</td></tr>
                            <tr><td>Feedback Comment</td><td>${feedbackComment}</td></tr>
                            <tr><td>Last Modified</td><td>${lastModified}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        if (!submission) {
            body.innerHTML += `<div class="col-lg-12">
                <a id="btnSubmit" href="{{ url('member/course/submission') }}/${courseId}/${stId}" class="btn btn-primary">Add Submission</a>
            </div>`;
        }

        body.innerHTML += `<p class="text-muted mt-3">${submissionStatus}</p>`;

        container.appendChild(body);

        if (isOverdue) {
            const submitButton = document.getElementById('btnSubmit');
            if (submitButton) {
                submitButton.remove();
            }
        }
    }

    function timeRemaining(targetDateString) {
        const now = new Date().toLocaleString("en-US", {
            timeZone: "Asia/Jakarta"
        });
        const nowTime = new Date(now).getTime(); // Convert to timestamp
        const targetDate = new Date(targetDateString + " UTC").getTime();

        const timeLeft = targetDate - nowTime;

        if (timeLeft <= 0) {
            return "Overdue!";
        }

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        return `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`;
    }

    function getDataTest(allow, duedate) {
        axios.get(apiUrl + `/hasil_test-byuser-subtopicid/${stId}/${userId}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    updateViewTest(allow, data.data, duedate);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });

    }

    // function updateViewTest(Test, duedate){
    function updateViewTest(allow, data, duedate) {
        let attemp = data ? data.length : 0;
        const dt = timeRemaining(duedate);
        const container = document.getElementById('test_container');
        const body = document.createElement('div');
        body.style.width = '100%';
        body.innerHTML += `<p class="text-muted mt-3">Attempt: ${attemp != null ? attemp : '0'}</p>`;
        // body.innerHTML += `<div class="col-lg-12"><a id="btnStart" href="{{ url('member/course/test') }}/${courseId}/${stId}" class="btn btn-primary">Get Started</a></div></div>`;
        body.innerHTML += `<div class="col-lg-12"><button id="btnStart" class="btn btn-primary btn-sm" onclick="startExamConfirmation()">Get Started</button>
                </div></div>`;

        container.appendChild(body);

        if (timeRemaining(duedate) == "Overdue!" || attemp >= allow) {
            document.getElementById('btnStart').remove();
        }


        if(attemp > 0 ){
            const tableBody = document.querySelector('#userDataTable tbody');
            tableBody.innerHTML = '';

            data.forEach((d, index) => {
                console.log(d);
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${index + 1}</td>
                <td>${d.status}</td>
                <td>${d.waktu_respon}</td>
                <td>${d.total_score.toFixed(2)} / ${d.total_bobot.toFixed(2)}</td>
            `;
                tableBody.appendChild(row);
            });
            const dataTable2 = new simpleDatatables.DataTable('#userDataTable');
            document.getElementById('score_container').style.display = 'block';
        }
    }


    function timeRemaining(targetDateString) {
        const now = new Date().toLocaleString("en-US", {
            timeZone: "Asia/Jakarta"
        });
        const nowTime = new Date(now).getTime(); // Convert to timestamp
        const targetDate = new Date(targetDateString + " UTC").getTime();

        const timeLeft = targetDate - nowTime;

        if (timeLeft <= 0) {
            return "Overdue!";
        }

        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

        return `${days} Hari ${hours} Jam ${minutes} Menit ${seconds} Detik`;
    }

    function startExamConfirmation() {
        const startExamModal = new bootstrap.Modal(document.getElementById('startExamConfirmationModal'));
        startExamModal.show();
    }

    function startTest() {
        const formData = new FormData();

        formData.append("peserta_id", userId);
        formData.append("subtopic_id", stId);

        const jakartaTime = new Date().toLocaleString("en-US", {
            timeZone: "Asia/Jakarta"
        });

        // Mengonversi ke format 'YYYY-MM-DD HH:mm:ss'
        const dateObj = new Date(jakartaTime);
        const formattedDateTime = dateObj.getFullYear() + '-' +
            ('0' + (dateObj.getMonth() + 1)).slice(-2) + '-' +
            ('0' + dateObj.getDate()).slice(-2) + ' ' +
            ('0' + dateObj.getHours()).slice(-2) + ':' +
            ('0' + dateObj.getMinutes()).slice(-2) + ':' +
            ('0' + dateObj.getSeconds()).slice(-2);

        formData.append("waktu_respon", formattedDateTime);

        axios.post(apiUrl + '/hasil-test', formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    const hasil = data.data;
                    console.log(data.data);
                    var myModalEl = document.getElementById('startExamConfirmationModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                    window.location.href = `{{ url('member/course/test') }}/${courseId}/${stId}/${hasil.hasil_id}`;
                } else {
                    console.error('Adding data failed:', data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
</script>
