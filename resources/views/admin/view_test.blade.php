@extends('layouts.user.base')

@section('title', 'Review Test')

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
            <li class="breadcrumb-item active">Result</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title" id='subtopic_title2'></h5>

                    <!-- Table Wrapper with Horizontal Scrolling -->
                    <div style="overflow-x:auto;">
                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>State</th>
                                    <th>Started On</th>
                                    <th>Completed</th>
                                    <th>Time Taken</th>
                                    <th><span id='grade'></span></th>
                                    <!-- Additional question columns will be dynamically inserted here -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data peserta akan ditambahkan di sini menggunakan JavaScript -->
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table Wrapper -->
                </div>
            </div>
        </div>
    </div>	  
    <!-- Add Score Modal -->
    <div class="modal fade" id="addScorenModal" tabindex="-1" aria-labelledby="addScorenModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScorenModalLabel">Add Score Essay</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" id="addScoreForm" novalidate>
                        <!-- Hidden input to store detail ID -->
                        <input type="hidden" id="detailId">
                        <div class="col-12">
                            <label for="jawaban_isian" class="form-label">Answer</label>
                            <textarea class="form-control" name="jawaban_isian" id="jawaban_isian" style="height: 100px;" disabled></textarea>
                        </div>
                        <div class="col-12">
                            <label for="nilai_jawaban_isian" class="form-label">Score <small class="text-danger">* Max score is 10</small></label>
                            <input class="form-control" type="number" name="nilai_jawaban_isian" id="edit_nilai_jawaban_isian" max="10" />
                        </div>
                        
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" onclick="updateDetail()">Save</button>
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

    document.addEventListener("DOMContentLoaded", () => {
        getCourseById(courseId);
        getData(stId);
        

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

    let subtopicShuffle = 0;

    function displaySubtopic(subtopic) {
        document.getElementById('subtopic_title2').innerHTML = subtopic.st_name;
        document.getElementById('subtopic_title').textContent = subtopic.st_name;
        document.getElementById('subtopic_title').href = "{{ url('admin/view_course') }}/" + courseId + "/" + stId;
        subtopicShuffle = subtopic.st_is_shuffle;
        getDataTopic(subtopic.st_t_id);
        getDataTest(stId);
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
        if(subtopicShuffle == 1){
            axios.get(apiUrl + `/detail-test-bysubtopicidshuffle/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    displayHasilTest(data.data)
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            axios.get(apiUrl + `/detail-test-bysubtopicid/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    displayHasilTest(data.data)
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
        
    }
    let dataTable;  // Variabel untuk menyimpan referensi ke DataTable

    function displayHasilTest(data) {
        const tableBody = document.querySelector("#userDataTable tbody");
        const tableHeader = document.querySelector("#userDataTable thead tr");

        // Jika DataTable belum diinisialisasi, inisialisasi pertama kali
        if (!dataTable) {
            dataTable = $('#userDataTable').DataTable({
                "pagingType": "simple_numbers",
                "responsive": true,
                dom: '<"row" <"col-12 text-end" B>><"row" <"col-6" l><"col-6 text-end mb-1" fr>> t <"row m-1" <"col-6" i><"col-6 text-end mt-1" p>>',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        className: 'btn btn-primary',
                        text: 'Download Excel'
                    }
                ],
                "autoWidth" : true,
                "columnDefs": [
                    {
                        "targets": "_all",  // Menargetkan semua kolom
                        "className": "text-start"  // Mengatur teks menjadi rata kiri
                    }
                ]
            });
        }

        dataTable.clear();

        const questionCount = data[1]?.jawaban.length || 0;
        while (tableHeader.children.length > 7) {
            tableHeader.removeChild(tableHeader.lastChild);
        }

        // Tambahkan kolom untuk setiap soal dengan bobot
        let headerHTML = tableHeader.innerHTML; 
        if(subtopicShuffle == 1){
            for (let i = 1; i <= questionCount; i++) {
                headerHTML += `<th>Q.${i}</th>`;
            }
        } else {
            for (let i = 1; i <= questionCount; i++) {
                const bobot = data[0].jawaban[i - 1]?.bobot || 0;
                // headerHTML += `<th>Q.${i} (${(bobot / data[0].total_bobot_questions * 100).toFixed(2)})</th>`;
                headerHTML += `<th>Q.${i} (${(bobot).toFixed(2)})</th>`;
            }
        }
        
        tableHeader.innerHTML = headerHTML;

        document.getElementById("grade").innerHTML = `Grade / ${data[0]?.total_bobot_questions.toFixed(2)}`;

        // Generate table rows with data
        let bodyHTML = '';
        data.forEach(participant => {
            let rowHTML = `<tr>
                <td>${participant.nama}`;
                if(participant.hasil_id){
                    rowHTML += `<div><a href="{{ url('admin/review') }}/${courseId}/${stId}/${participant.hasil_id}" class="mt-2">Review Attemp</a></div>`;
                }
            rowHTML += `</td>
                <td>${participant.email}</td>
                <td>${participant.status}</td>
                <td>${participant.waktu_respon ? participant.waktu_respon : '-'}</td>
                <td>${participant.waktu_submit ? participant.waktu_submit : '-'}</td>`;
                // Calculate time taken
                if (participant.waktu_respon && participant.waktu_submit) {
                    const waktuRespon = new Date(participant.waktu_respon);
                    const waktuSubmit = new Date(participant.waktu_submit);
                    const timeDiff = (waktuSubmit - waktuRespon) / 1000; // Time difference in seconds

                    const minutes = Math.floor(timeDiff / 60);
                    const seconds = Math.floor(timeDiff % 60);
                    rowHTML += `<td>${minutes} mins ${seconds} secs</td>`;
                } else {
                    rowHTML += `<td>-</td>`;
                }
                rowHTML +=`<td>${participant.total_score ? (participant.total_score / participant.total_bobot_questions  * 100).toFixed(2) : '0.00'}</td>`;

            // Check if the jawaban length is 0 or if it's empty
            const allAnswersAreEmpty = !participant.jawaban || participant.jawaban.length === 0;

            // Add answers for each question
            for (let i = 0; i < questionCount; i++) {
                // Get the current answer, or set it to '-' if it's missing
                //const answer = allAnswersAreEmpty ? '-' : (participant.jawaban[i].score != null ? (participant.jawaban[i].score).toFixed(2) : '0.00');
                const answer = allAnswersAreEmpty ? '-' : '0.00';

                // If the current jawaban exists, process it
                if (participant.jawaban[i]) {
                    if (participant.jawaban[i].tipe_pertanyaan !== 'pilihan_ganda') {
                        //essay
                        rowHTML += `<td>${answer} 
                                        <a href="javascript:void(0)" onclick="addScore('${participant.jawaban[i].hasil_id_detail}')">
                                            <i class="m-1 bi bi-pencil" style="font-size: 18px; color: green;"></i>
                                        </a>
                                    </td>`;
                    } else {
                        //pilihan ganda
                        rowHTML += `<td>${answer}</td>`;
                    }
                } else {
                    rowHTML += `<td>${answer}</td>`;
                }
            }

            rowHTML += `</tr>`;
            bodyHTML += rowHTML;
        });

        // Tambahkan data ke tabel
        dataTable.rows.add($(bodyHTML)).draw();
    }

    function addScore(detailId) {
        getDataDetail(detailId);
        // document.getElementById('detailId').value = detailId;
        // document.getElementById('topicNameToDelete').textContent = topicName;
        const addScorenModal = new bootstrap.Modal(document.getElementById('addScorenModal'));
        addScorenModal.show();
    }

    function getDataDetail(id) {
        axios.get(apiUrl + `/detail-test/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    detail = data.data;
                    document.getElementById('detailId').value = detail.hasil_id_detail;
                    document.getElementById('jawaban_isian').value = detail.jawaban_isian;
                    document.getElementById('edit_nilai_jawaban_isian').value = detail.nilai_jawaban_isian;
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateDetail() {

        const form = document.getElementById('addScoreForm');
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            return;
        }

        const formData = new FormData(form);
        const detailId = document.getElementById('detailId').value; // Get the ID

        axios.post(apiUrl + `/detail-test/${detailId}?_method=PUT`, formData, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    var myModalEl = document.getElementById('addScorenModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                    
                    getDataTest(stId);
                } else {
                    console.error('Updating failed:', data.message);
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
