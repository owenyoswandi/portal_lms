@extends('layouts.user.base')

@section('title', 'Manage Course')
<style>
    .card-body h4 {
        margin-left: 20px;
        color: #0f6fc5;
    }

    #accordion-container {
        margin: 20px;
        color: #0f6fc5;
    }

    .accordion-header {
        /* background-color: #f1f1f1; */
        padding: 10px;
        cursor: pointer;
        font-size: 1.25rem;
        font-weight: semibold;
        display: flex;
        align-items: center;
        border-top: 1px solid rgba(0, 0, 0, 0.2);
    }

    .accordion-body {
        background-color: #f9f9f9;
        /* padding: 0; */
        padding: 0 15px 0 15px !important;
    }

    .accordion-body ul {
        list-style-type: none;
        padding: 0;
    }

    .accordion-body li {
        padding: 3px 0;
    }

    .accordion-header .icon {
        transition: transform 0.3s;
        margin-right: 10px;
    }

    .accordion-header.active .icon {
        transform: rotate(90deg);
    }

    .accordion-body li a {
        display: flex;
        align-items: center;
        text-decoration: none;
        transition: text-decoration 0.3s ease;
    }

    .accordion-body li a img {
        width: 18px;
        height: 18px;
        margin-right: 15px;
    }

    .accordion-body li a span {
        font-size: 17px;
        color: #0f6fc5;
    }

    .accordion-body li a:hover {
        text-decoration: underline;
        color: #0f6fc5;
    }

    .stars i {
        cursor: pointer;
        color: #dee2e6;
        margin-right: 2px;
    }

    .stars i.bi-star-fill {
        color: #ffc107;
    }

    .feedback-date {
        font-size: 0.875rem;
        color: #6c757d;
    }
</style>
@section('content')
    <div class="pagetitle">
        <h1 id="course_title"></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.course') }}">Manage Course</a></li>
                <li class="breadcrumb-item active" id="course_title2"></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h4 class="card-title">Course</h4>
                        <div id="accordion-container">
                            <!-- Accordion items will be dynamically added here -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <script>
        const apiUrl = '{{ config('app.api_url') }}';
        const url = '{{ config('app.app_url') }}'
        const accessToken = '{{ session('token') }}';

        const courseId = @json($id);

        document.addEventListener("DOMContentLoaded", () => {
            getCourseById(courseId);
            getData(courseId);
        });
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
            document.getElementById('course_title2').innerHTML = courseData.p_judul;
        }

        function getData(id) {
        axios.get(apiUrl + `/topic-subtopic/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    console.log(data.data)
                    const topics = data.data;
                    const container = document.getElementById('accordion-container');

                    topics.forEach((topic, index) => {


                        // Create accordion header
                        const header = document.createElement('div');
                        header.classList.add('accordion-header');
                        header.innerHTML = `
                                <span class="icon"><i class="bi bi-caret-right-fill"></i></span>
                                <span>${topic.t_name}</span>
                            `;
                        header.addEventListener('click', () => toggleAccordion(index));

                        // Create accordion body
                        const body = document.createElement('div');
                        body.classList.add('accordion-body');
                        body.style.display = 'none'; // Initially hidden
                        const list = document.createElement('ul');

                            // Add subtopics to the list
                            topic.subtopics.forEach(subtopic => {
                                if(subtopic.st_jenis=='Task Collection') {
                                    list.innerHTML += `<li><a href="{{ url('admin/view_course') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/hand.png')}}">
                                        <span>${subtopic.st_name}</span>
                                    </a></li>`;
                                } else if(subtopic.st_jenis=='Modul') {
                                    list.innerHTML += `<li><a href="{{ url('admin/view_course') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/office-material.png')}}">
                                        <span>${subtopic.st_name}</span>
                                    </a></li>`;
                                } else if(subtopic.st_jenis=='Certificate') {
                                    list.innerHTML += `<li><a href="{{ url('admin/certificate') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/certificate-icon.png')}}">
                                        <span>${subtopic.st_name}</span>
                                    </a></li>`;
                                } else {
                                    list.innerHTML += `<li><a href="{{ url('admin/view_course') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/doc-checkmark.png')}}">
                                        <span>${subtopic.st_name}</span>
                                    </a></li>`;
                            }
                        });

                        body.appendChild(list);

                        // Append the header and body to the container
                        container.appendChild(header);
                        container.appendChild(body);
                    });

                    function toggleAccordion(index) {
                        const header = container.children[index * 2]; // Get the corresponding header
                        const body = container.children[index * 2 + 1]; // Get the corresponding body

                        // Toggle the body visibility
                        body.style.display = (body.style.display === 'none' || body.style.display === '') ?
                            'block' : 'none';

                        // Toggle the icon
                        header.classList.toggle('active');
                    }
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
