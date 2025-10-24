@extends('layouts.user.base')

@section('title', 'Test')
    <style>
        .card-body {
            margin: 20px;
            /* color: #0f6fc5; */
        }

        .disabled {
            pointer-events: none;
            color: gray;
            text-decoration: none;
        }

    </style>
@section('content')
    <div class="pagetitle">
      <h1 id="course_title"></h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
        <form id="ujianForm">
            <div class="card">
                <div class="card-body">
                    <!-- Timer in Card -->
                    <div id="timer" class="position-absolute top-0 end-0 p-2 mt-3 bg-danger text-white rounded-start">
                        Waktu Tersisa : <span id="timer-text">0</span> detik
                    </div><div id="jumlah-soal" class="position-absolute top-0 end-0 p-3 mt-5">
                        Soal : <span id="current-question">0</span> / <span id="total-questions">0</span>
                    </div>

                    <!-- Pertanyaan Container -->
                    <div id="pertanyaan-container" class="mt-5">
                        <!-- Question will be loaded here -->
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" id="previousBtn" onclick="previousQuestion()" class="btn btn-secondary" disabled>Previous</button>
                        <button type="button" id="nextBtn" onclick="nextQuestion()" class="btn btn-secondary">Next</button>
                        <button type="submit" id="submitBtn" class="btn btn-success" style="display:none;">Submit</button>
                    </div>
                </div>
            </div>
        </form>

        </div>

      </div>
    </section>
@endsection

	<!-- silahkan isi dengan java script -->
	<script>
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const url    = "{{ rtrim(url('/'), '/') }}";
        const accessToken = '{{ session('token') }}';
        const userId = '{{ session('userid') }}';

        const courseId = @json($p_id);
        const stId = @json($st_id);
        const hasilId = @json($hasil_id);

        let currentQuestionIndex = 0;
        let totalQuestions = 0;
        let soalData = [];
        let interval;
        let waktuUjian = '2'; //dummy

        document.addEventListener("DOMContentLoaded", () => {
            setTimer(hasilId);
            loadQuestions(stId);

            // Handle form submit (Submit Exam)
            document.getElementById('submitBtn').addEventListener('click', function(event) {
                event.preventDefault();
                submitExam();
            });
        });

        // Start timer function
        function startTimer() {
            interval = setInterval(function() {
                if (waktuUjian <= 0) {
                    clearInterval(interval);
                    alert('Waktu habis');
                    document.getElementById('previousBtn').disabled = true;
                    document.getElementById('nextBtn').disabled = true;
                    document.getElementById('submitBtn').disabled = true;
                    localStorage.clear();
                    window.location.href = `{{ url('member/course/topic') }}/${courseId}/${stId}`;
                } else {
                    waktuUjian--;
                    updateTimerDisplay(waktuUjian);
                }
            }, 1000);
        }

        function updateTimerDisplay(timeInSeconds) {
            const hours = Math.floor(timeInSeconds / 3600); // Get the hours part
            const minutes = Math.floor((timeInSeconds % 3600) / 60); // Get the minutes part
            const seconds = timeInSeconds % 60; // Get the seconds part

            // Display the formatted time (e.g., 01:30:05)
            document.getElementById('timer-text').innerText = `${hours < 10 ? '0' + hours : hours}:${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
        }

        function setTimer(id) {
            axios.get(apiUrl + '/hasil-test/' + id, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    const hasil = data.data;
                    console.log(hasil);

                    // Ambil waktu_respon dari database (dalam format UTC)
                    const waktuRespon = new Date(hasil.waktu_respon); // Asumsi waktu_respon adalah tanggal dalam format UTC

                     // Mendapatkan waktu saat ini di zona waktu Jakarta (Asia/Jakarta)
                    const jakartaTime = new Date().toLocaleString("en-US", { timeZone: "Asia/Jakarta" });

                    // Mengonversi waktu ke objek Date
                    const nowInJakarta = new Date(jakartaTime);

                    // Format Jakarta time to YYYY-MM-DD HH:mm:ss (optional for debugging)
                    const formattedNow = nowInJakarta.getFullYear() + '-' +
                                        ('0' + (nowInJakarta.getMonth() + 1)).slice(-2) + '-' +
                                        ('0' + nowInJakarta.getDate()).slice(-2) + ' ' +
                                        ('0' + nowInJakarta.getHours()).slice(-2) + ':' +
                                        ('0' + nowInJakarta.getMinutes()).slice(-2) + ':' +
                                        ('0' + nowInJakarta.getSeconds()).slice(-2);

                    console.log("Waktu Jakarta Sekarang: ", formattedNow);

                    // Hitung sisa waktu
                    const waktuTersisa = (waktuRespon.getTime() + hasil.st_duration * 60 * 1000) - nowInJakarta.getTime();

                    if (waktuTersisa > 0) {
                        waktuUjian = Math.floor(waktuTersisa / 1000); // Ubah ke detik
                        startTimer();
                    } else {
                        alert('Waktu habis');
                        clearInterval(interval);
                        // Disable tombol setelah waktu habis
                        document.getElementById('previousBtn').disabled = true;
                        document.getElementById('nextBtn').disabled = true;
                        document.getElementById('submitBtn').disabled = true;
                        localStorage.clear();

                        window.location.href = `{{ url('member/course/topic') }}/${courseId}/${stId}`;
                    }
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }


        function loadQuestions(subtopicId) {
            axios.get(apiUrl + '/subtopic_test_jawaban-byid/' + subtopicId, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data);
                    soalData = data.data;
                    totalQuestions = soalData.length;
                    document.getElementById('total-questions').innerText = totalQuestions;
                    loadQuestion(currentQuestionIndex);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        function loadQuestion(index) {
            let soal = soalData[index];
            let html = `
                <h5 class="card-title">${index + 1}. ${soal.teks_pertanyaan}</h5>
            `;

            if (soal.tipe_pertanyaan === 'pilihan_ganda') {
                soal.pilihan_jawaban.forEach((pilihan) => {
                    html += `
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="jawaban" value="${pilihan.pilihan_id}" id="jawaban_${pilihan.pilihan_id}" />
                            <label class="form-check-label" for="jawaban_${pilihan.pilihan_id}">
                                ${pilihan.teks_pilihan}
                            </label>
                        </div>
                    `;
                });
            } else {
                html += `
                    <div class="mb-3">
                        <textarea class="form-control" style="height: 100px;" name="jawaban_isian" placeholder="Your Answer" ></textarea>

                    </div>
                `;
            }

            document.getElementById('pertanyaan-container').innerHTML = html;
            document.getElementById('current-question').innerText = currentQuestionIndex + 1;

            // Check if an answer is already stored in localStorage and load it
            loadStoredAnswer();
        }
        // Load stored answer from localStorage when revisiting a question
        function loadStoredAnswer() {
            const storedAnswer = localStorage.getItem('jawaban_' + soalData[currentQuestionIndex].pertanyaan_id);
            if (storedAnswer) {
                if (soalData[currentQuestionIndex].tipe_pertanyaan === 'pilihan_ganda') {
                    const radioButton = document.getElementById('jawaban_' + storedAnswer);
                    if (radioButton) {
                        radioButton.checked = true;
                    }
                } else {
                    const textInput = document.querySelector('input[name="jawaban_isian"]');
                    if (textInput) {
                        textInput.value = storedAnswer;
                    }
                }
            }
        }


        function nextQuestion() {
            // Save the current answer first
            const form = new FormData(document.getElementById('ujianForm'));
            const jawaban = form.get('jawaban') || form.get('jawaban_isian');

            // If no answer is selected, show an alert and stop
            if (!jawaban) {
                alert('Please select or enter an answer before proceeding!');
                return;
            }

            saveAnswer();


            if (currentQuestionIndex < totalQuestions - 1) {
                currentQuestionIndex++;
                loadQuestion(currentQuestionIndex);
                document.getElementById('previousBtn').disabled = false;
                if (currentQuestionIndex === totalQuestions - 1) {
                    document.getElementById('nextBtn').style.display = 'none';
                    document.getElementById('submitBtn').style.display = 'block';
                }
            }
        }


        // Previous question function
        function previousQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                loadQuestion(currentQuestionIndex);
                document.getElementById('nextBtn').style.display = 'block';
                document.getElementById('submitBtn').style.display = 'none';
            }
            if (currentQuestionIndex === 0) {
                document.getElementById('previousBtn').disabled = true; // Disable "Previous" button at the start
            }
        }

        function saveAnswer() {
            const form = new FormData(document.getElementById('ujianForm'));

            const jawaban = form.get('jawaban') || form.get('jawaban_isian');
            const tipeSoal = form.get('jawaban') ? 'pilihan_ganda' : 'isian';

            // Save answer to localStorage
            const formData = new FormData();

            formData.append("hasil_id", hasilId);
            formData.append("pertanyaan_id", soalData[currentQuestionIndex].pertanyaan_id);
            formData.append("jawaban_id", tipeSoal === 'pilihan_ganda' ? jawaban : '');
            formData.append("jawaban_isian", tipeSoal === 'isian' ? jawaban : '');

            axios.post(apiUrl + '/detail-test', formData, {
                headers: {
                    "Content-Type": "multipart/form-data",
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    const detail = data.data;
                    // Save answer to localStorage
                    localStorage.setItem('jawaban_' + detail.pertanyaan_id, jawaban);
                } else {
                    console.error('Adding data failed:', data.message);
                    alert('Failed to save the answer. Please try again!');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the answer. Please try again!');
            });
        }

        function submitExam() {
            saveAnswer();

            const formData = new FormData();

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

            formData.append("waktu_submit", formattedDateTime);

            axios.post(apiUrl + `/hasil-test/${hasilId}?_method=PUT`, formData, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    alert('Ujian selesai!');
                    localStorage.clear();
                    console.log(localStorage); // Check if it's cleared
                    window.location.href = `{{ url('member/course/topic') }}/${courseId}/${stId}`;
                } else {
                    console.error('Updating hasil test failed:', data.message);
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
