@extends('layouts.user.base')

@section('title', 'Topic')
    <style>
        .card-body {
            margin: 20px;
            /* color: #0f6fc5; */
        }

        .drop-area {
            width: 100%;
            height: 200px;
            border: 2px dashed #007bff;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-size: 16px;
            color: #007bff;
            background-color: #f8f9fa;
            flex-wrap: wrap;
            overflow: auto;
            position: relative;
            padding: 10px;
        }

        .drop-area.drag-over {
            background-color: #e9ecef;
        }

        .file-preview {
            display: flex;
            flex-direction: column;
            align-items: center; /* Center the image and text */
            justify-content: flex-start; /* Align the content to the top */
            margin: 5px;
            max-width: 150px;
            max-height: 150px;
            flex-wrap: wrap;
        }

        .file-preview img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            margin-bottom: 10px; /* Add space between image and file name */
        }

        .file-preview .file-name {
            font-size: 12px;
            text-align: center;
            color: #333;
            word-wrap: break-word;
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
                    <div id="dropArea" class="drop-area">
                        <p id="instructionText">Drag & drop files here or click to select files</p>
                    </div>

                    <input type="file" id="fileInput" multiple class="d-none">
                    
                    <input type="hidden" name="sm_creadate" id="sm_creadate">

                    <div class="mt-3">
                        <button id="uploadButton" class="btn btn-primary" onclick="addSubmission()">Save Changes</button>
                    </div>
                </div>
            </div>
          </div>

        </div>

      </div>	  
    </section>
@endsection 

	<!-- silahkan isi dengan java script -->
	<script>
        const apiUrl = '{{ config('app.api_url') }}';
        const url = '{{ config('app.app_url') }}'
        const accessToken = '{{ session('token') }}';
        const accessMember = '{{ session('usermember') }}';
        const userId = '{{ session('userid') }}';

        const courseId = @json($p_id);
        const stId = @json($st_id);

        // let filesToUpload = []; 
        let fileToUpload = null;

		window.onload = function() {
            getCourseById(courseId);
			getData(stId);
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
            document.getElementById('course_title').innerHTML= courseData.p_judul;
            document.getElementById('link_course').textContent= courseData.p_judul;
            document.getElementById('link_course').href = "{{ url('member/course/topic') }}/" + courseData.p_id;
            document.getElementById('link_course2').href = "{{ url('member/course/topic') }}/" + courseData.p_id;
        }

        function getBalance(){
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

        function displaySubtopic(subtopic){
            document.getElementById('subtopic_title').innerHTML= subtopic.st_name; 
            document.getElementById('subtopic_title2').innerHTML= subtopic.st_name;
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
                        console.log(data.data);
                        document.getElementById('link_course2').textContent= topic.t_name;
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById("dropArea");
            const fileInput = document.getElementById("fileInput");
            const instructionText = document.getElementById("instructionText");

            dropArea.addEventListener("dragover", (e) => {
                e.preventDefault();
                dropArea.classList.add("drag-over");
            });

            dropArea.addEventListener("dragleave", () => {
                dropArea.classList.remove("drag-over");
            });

            dropArea.addEventListener("drop", (e) => {
                e.preventDefault();
                dropArea.classList.remove("drag-over");
                const files = e.dataTransfer.files;
                displayFiles(files);
            });

            dropArea.addEventListener("click", () => {
                fileInput.click();
            });

            fileInput.addEventListener("change", () => {
                const files = fileInput.files;
                displayFiles(files);
            });

            function displayFiles(files) {
                // Hide instruction text if there are files
                instructionText.style.display = "none";
                
                // Array.from(files).forEach((file) => {
                    // Periksa apakah file sudah ada dalam array
                    // if (!filesToUpload.some(existingFile => existingFile.name === file.name)) {

                        if (files.length > 1) {
                            alert("You can only upload one file.");
                            return;
                        }

                        // Check file size (10MB limit)
                        if (files[0].size > 10 * 1024 * 1024) {
                            alert("The file is too large. Please select a file less than 10MB.");
                            return;
                        }
                        // Tambahkan file baru ke dalam array
                        fileToUpload = files[0];

                        const filePreview = document.createElement("div");
                        filePreview.classList.add("file-preview");

                        let previewContent = '';

                        if (fileToUpload.type.startsWith("image")) {
                            const imgURL = URL.createObjectURL(fileToUpload);
                            previewContent = `<img src="${imgURL}" alt="${fileToUpload.name}">`;
                        } else if (fileToUpload.type === "application/pdf") {
                            previewContent = `<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="${fileToUpload.name}" style="width: 50px; height: 50px;">`;
                        } else {
                            previewContent = `<img src="https://cdn-icons-png.flaticon.com/512/337/337946.png" alt="${fileToUpload.name}">`;
                        }

                        filePreview.innerHTML = `${previewContent}<span class="file-name">${fileToUpload.name}</span>`;
                        dropArea.appendChild(filePreview);
                    // }
                // });
                
                // Observe the drop area for changes (when files are added or removed)
                const observer = new MutationObserver(checkDropArea);
                observer.observe(dropArea, {
                    childList: true
                });
            }

            // Function to check if there are files in the drop area and show the instruction text if empty
            function checkDropArea() {
                const filePreviews = dropArea.getElementsByClassName("file-preview");
                if (filePreviews.length === 0) {
                    instructionText.style.display = "block";  // Show instruction text if no files
                }
            }
            
        });

        

        

        function addSubmission() {
            // const creadate = new Date().toISOString().split('T')[0];
            const dateTime = new Date().toISOString().split('T'); // ["YYYY-MM-DD", "HH:mm:ss.sssZ"]
            const formattedDateTime = `${dateTime[0]} ${dateTime[1].split('.')[0]}`; //hapus milidetik

            if (!fileToUpload) {
                alert("Please select files to upload.");
                return;
            }

            const formData = new FormData();
            // filesToUpload.forEach((file) => {
            //     formData.append("files[]", file); // Append each file to the formData array
            // });

            formData.append("files", fileToUpload);

            formData.append("sm_user_id", userId); // Adding user ID
            formData.append("sm_st_id", stId); // Adding task/subtopic ID
            formData.append("sm_creadate", formattedDateTime);
            formData.append("sm_status", "0"); // 0 belum diperiksa

            console.log(formData);

            axios.post(apiUrl + '/submission', formData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('Submission added successfully.');
                        console.log(data.data);
                        window.location.href = "{{ url('member/course/topic') }}/" + courseId + "/" + stId;
                    } else {
                        console.error('Adding submission failed:', data.message);
                    }
                })
                .catch(error => {
                    if (error.response) {
                        console.error('Error response:', error.response);
                        if (error.response.data) {
                            console.error('Response data:', error.response.data);
                        }
                        if (error.response.status) {
                            console.error('Response status:', error.response.status);
                        }
                        if (error.response.headers) {
                            console.error('Response headers:', error.response.headers);
                        }
                    } else if (error.request) {
                        console.error('Error request:', error.request);
                    } else {
                        console.error('Error message:', error.message);
                    }
                });
        }

	</script>