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
            <li class="breadcrumb-item"><a id="subtopic_title"></a></li>
            <li class="breadcrumb-item active">Grading</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <div id="submission_container" style="width: 100%;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Grade</h5>
                    <form class="row g-3 needs-validation" id="addGradeForm" novalidate enctype="multipart/form-data">
                        <div class="col-12">
                            <label for="sm_grade" class="form-label">Grade out of 100</label>
                            <input type="number" name="sm_grade" class="form-control" id="sm_grade" required>
                            <!-- <div class="invalid-feedback">Please enter the price!</div> -->
                        </div>
                        <div class="col-12">
                            <label for="sm_feedback_comment" class="form-label">Feedback Comment</label>
                            <textarea class="form-control" name="sm_feedback_comment" id="sm_feedback_comment" style="height: 160px;"></textarea>
                        </div>
                        <!-- Hidden fields -->
                        <input type="hidden" name="sm_id" id="sm_id">
                    </form>
                    <button type="button" class="btn btn-primary" onclick="addGrade()">Save</button>
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
    const smId = @json($sm_id);

    document.addEventListener("DOMContentLoaded", () => {
        getCourseById(courseId);
        getData(stId);
        getSubmission(smId);
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
        document.getElementById('subtopic_title').textContent = subtopic.st_name;
        document.getElementById('subtopic_title').href = "{{ url('admin/view_course') }}/" + courseId + "/" + stId;
        getDataTopic(subtopic.st_t_id);
        subtopicName = subtopic.st_name;
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

    function getSubmission(id) {
        axios.get(apiUrl + `/submission/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                console.log(data)
                if (data.success) {
                    displaySubmission(data.data);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function displaySubmission(data){
        const container = document.getElementById('submission_container');
        container.innerHTML = "";
        const body = document.createElement('div');
        body.classList.add("d-flex");
        body.classList.add("justify-content-center");
        body.classList.add("align-items-center");
        body.innerHTML += `
        <iframe src="{{ url('public') }}/${data.sm_file}" width="800" height="400"></iframe>`;
        document.getElementById('sm_id').value = smId;
        document.getElementById('sm_grade').value = data.sm_grade;
        document.getElementById('sm_feedback_comment').value = data.sm_feedback_comment;
        container.appendChild(body);
    }

    function addGrade(){
        const form = document.getElementById('addGradeForm');

        const formData = new FormData(form);

        axios.post(apiUrl + `/submission/${smId}?_method=PUT`, formData, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log('Grading successfully.');
                    const alertHtml = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            Grading successfull!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `;
                    document.querySelector('.row').insertAdjacentHTML('afterbegin',alertHtml);

                    getSubmission(smId);
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
</script>
