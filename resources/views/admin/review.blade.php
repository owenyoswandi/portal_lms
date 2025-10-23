@extends('layouts.user.base')

@section('title', 'Review')
<style>
    i {
        font-size: 1.5rem; /* Increase icon size */
        font-weight: bold; /* Make icon appear thicker */
        margin-left: 5px; /* Add some space between the answer text and the icon */
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
            <li class="breadcrumb-item active">Review</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body" style="overflow-x:auto">
                    <h5 class="card-title" id='subtopic_title2'></h5>
                    <div id="subtopic_container" style="width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>	  
</section>

@endsection 

<script>
    const apiUrl = '{{ config('app.api_url') }}';
    const url = '{{ config('app.app_url') }}';
    const accessToken = '{{ session('token') }}';
    const userId = '{{ session('userid') }}';

    const courseId = @json($p_id);
    const stId = @json($st_id);
    const hasilId = @json($hasil_id);

    document.addEventListener("DOMContentLoaded", () => {
        getCourseById(courseId);
        getData(stId);
        getDataTest(hasilId);
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
        document.getElementById('subtopic_title2').innerHTML = subtopic.st_name;
        document.getElementById('subtopic_title').textContent = subtopic.st_name;
        document.getElementById('subtopic_title').href = "{{ url('admin/view_course') }}/" + courseId + "/" + stId;
        getDataTopic(subtopic.st_t_id);
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
    function getDataTest(id) {
        axios.get(apiUrl + `/detail-test-byhasilid/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data[0]);
                    displayHasilTest(data.data[0]);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function displayHasilTest(data) {
        const container = document.getElementById('subtopic_container');
        let body = '';

        let totalBobot = data.total_bobot_questions.toFixed(2);

        // Create the table with personal info
        body += `
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Name</td>
                        <td>${data.nama}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>${data.email}</td>
                    </tr>
                    <tr>
                        <td>Started On</td>
                        <td>${data.waktu_respon}</td>
                    </tr>
                    <tr>
                        <td>State</td>
                        <td>${data.status}</td>
                    </tr>
                    <tr>
                        <td>Grade</td>
                        <td>${data.total_score.toFixed(2)} out of ${totalBobot}</td>
                    </tr>
                </tbody>
            </table>
        `;

        let i = 1;

        // Iterate through questions and generate HTML
        data.pertanyaan.forEach(p => {
            // let marks = p.score / data.total_bobot_questions * 100;
            // let maks_nilai = p.maks_nilai / data.total_bobot_questions * 100;
            let marks = p.score.toFixed(2);
            let maks_nilai = p.maks_nilai.toFixed(2);
            body += `
                <div class="row">
                    <div class="col-lg-3">
                        <div class="alert alert-secondary">
                            <h6>Question ${i}</h6>
                            <h6>${p.isCorrect > 0 ? 'Correct' : 'Incorrect'}</h6>
                            <h6>Max Score ${maks_nilai}</h6>
                            <h6>Mark ${marks} of ${totalBobot}</h6>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-info">
                                    <h6>${p.teks_pertanyaan}</h6>
            `;

            if(p.pilihan_jawaban.length > 0){
                // Create answer choices dynamically
                p.pilihan_jawaban.forEach(j => {
                    body += `
                        <div class="answer">
                            <label>
                                <input type="radio" name="question-${p.pertanyaan_id}" value="${j.pilihan_id}" disabled ${j.is_checked ? 'checked' : ''}>
                                ${j.teks_pilihan}
                    `;
                    
                    // Add icon based on the correctness of the answer
                    if (j.is_checked) {
                        if (j.is_jawaban_benar) {
                            body += `<i class="bi bi-check-lg" style="color: green;"></i>`;
                        } else {
                            body += `<i class="bi bi-x" style="color: red;"></i>`;
                        }
                    }

                    body += `</label></div>`;
                });

                // Check if jawaban_benar is not null or undefined
                if (p.jawaban_benar) {
                    body += `</div></div>`;
                    body += `<div class="col-lg-12">
                        <div class="alert alert-warning">
                            <h6>The correct answer is: ${p.jawaban_benar.teks_pilihan}</h6>
                        </div>
                    </div>`;
                } else {
                    body += `</div></div>`;
                }
            } else if(p.teks_pertanyaan != "pilihan_ganda") {
                //menampilkan isian
                
                body += `<p>Answer: </p><textarea class="form-control" disabled>${p.essay}</textarea>`;
                body += `</div></div>`;
            } else {
                body += `</div></div>`;
            }
            body += ` </div>
                </div>
            </div>`;

            i++; // Increment question number
        });

        // Append the content to the container
        container.innerHTML = body;
    }



</script>
