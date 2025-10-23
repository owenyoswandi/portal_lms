@extends('layouts.user.base')

@section('title', 'Topic')

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
                <li class="breadcrumb-item"><a href="{{ url('member/course') }}">My Course</a></li>
                <li class="breadcrumb-item active" id="course_title2"></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
            <h4 class="card-title">Course</h4>
            <div id="accordion-container">
                <!-- Accordion items will be dynamically added here -->
            </div>
            </div>
          </div>

            </div>

        </div>
        {{-- <div class="card">
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

                <div> --}}
                    {{-- <h5 class="mb-3">Course Review</h5> --}}
                    {{-- <div id="feedbacks-container">
                    </div>
                </div>
            </div> --}}
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

    const courseId = @json($id);

    window.onload = function() {
        getCourseById(courseId);
        getData(courseId);
        getFeedBackByCourseId(courseId, userId);
        // getBalance();
    };

    // function displayFeedback(feedbackData) {
    //     const container = document.getElementById('feedbacks-container');
    //     const feedbackForm = document.querySelector('.bg-light.p-4');

    //     const userFeedback = feedbackData.find(feedback => feedback.user_id == userId);
    //     console.log(feedbackData);
    //     if (userFeedback) {
    //         feedbackForm.style.display = 'none';
    //     }

    //     if (!feedbackData || feedbackData.length === 0) {
    //         container.innerHTML = '<p class="text-muted">No feedback yet.</p>';
    //         return;
    //     }

    //     container.innerHTML = feedbackData.map(feedback => `
    //     <div class="card mb-3">
    //         <div class="card-body">
    //             <div class="mb-2">
    //                 ${getStarRating(feedback.rating)}
    //             </div>
    //             <p class="card-text">${feedback.feedback}</p>
    //             <div class="d-flex align-items-center gap-2">
    //                 <span class="fw-bold">${feedback.nama}</span>
    //                 <span class="feedback-date">• ${formatDate(feedback.created_at)}</span>
    //             </div>
    //         </div>
    //     </div>
    // `).join('');
    // }

    // function getStarRating(rating) {
    //     return Array(5).fill(0).map((_, index) =>
    //         `<i class="bi ${index < rating ? 'bi-star-fill' : 'bi-star'} text-warning"></i>`
    //     ).join('');
    // }

    // function formatDate(dateString) {
    //     return new Date(dateString).toLocaleDateString('en-US', {
    //         year: 'numeric',
    //         month: 'long',
    //         day: 'numeric'
    //     });
    // }

    // // Add this to your window.onload function or document ready
    // document.addEventListener('DOMContentLoaded', function() {
    //     const stars = document.querySelectorAll('.stars i');
    //     const ratingDisplay = document.getElementById('selected-rating');
    //     const feedbackText = document.getElementById('feedback-text');
    //     const submitButton = document.getElementById('submit-feedback');
    //     let selectedRating = 0;

    //     stars.forEach(star => {
    //         star.addEventListener('mouseover', function() {
    //             const rating = this.dataset.rating;
    //             updateStars(rating);
    //         });

    //         star.addEventListener('mouseout', function() {
    //             updateStars(selectedRating);
    //         });

    //         star.addEventListener('click', function() {
    //             selectedRating = this.dataset.rating;
    //             updateStars(selectedRating);
    //             updateSubmitButton();
    //         });
    //     });

    //     function updateStars(rating) {
    //         stars.forEach(star => {
    //             const starRating = star.dataset.rating;
    //             star.classList.remove('bi-star', 'bi-star-fill');
    //             star.classList.add(starRating <= rating ? 'bi-star-fill' : 'bi-star');
    //         });
    //         ratingDisplay.textContent = `${rating}/5`;
    //     }

    //     feedbackText.addEventListener('input', updateSubmitButton);

    //     function updateSubmitButton() {
    //         submitButton.disabled = !(selectedRating > 0 && feedbackText.value.trim());
    //     }

    //     submitButton.addEventListener('click', function() {
    //         const feedback = {
    //             course_id: courseId,
    //             rating: selectedRating,
    //             feedback: feedbackText.value.trim(),
    //             user_id: userId
    //         };

    //         submitButton.disabled = true;
    //         submitButton.innerHTML =
    //             `<span class="spinner-border spinner-border-sm me-2"></span>Submitting...`;

    //         axios.post(apiUrl + '/feedback', feedback, {
    //                 headers: {
    //                     'Authorization': `Bearer ${accessToken}`
    //                 }
    //             })
    //             .then(response => {
    //                 if (response.data.success) {
    //                     const alertHtml = `
    //                 <div class="alert alert-success alert-dismissible fade show" role="alert">
    //                     Thank you for your feedback!
    //                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //                 </div>
    //             `;
    //                     document.querySelector('.card-body').insertAdjacentHTML('afterbegin',
    //                         alertHtml);

    //                     // Reset form
    //                     selectedRating = 0;
    //                     feedbackText.value = '';
    //                     updateStars(0);
    //                     updateSubmitButton();

    //                     // Refresh feedback list
    //                     getFeedBackByCourseId(courseId, userId);
    //                 } else {
    //                     throw new Error(response.data.message);
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Error:', error);
    //                 const alertHtml = `
    //             <div class="alert alert-danger alert-dismissible fade show" role="alert">
    //                 Error submitting feedback. Please try again.
    //                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //             </div>
    //         `;
    //                 document.querySelector('.card-body').insertAdjacentHTML('afterbegin',
    //                     alertHtml);
    //             })
    //             .finally(() => {
    //                 submitButton.disabled = false;
    //                 submitButton.innerHTML = 'Submit Feedback';
    //             });
    //     });
    // });

    // function getFeedBackByCourseId(course_id, user_id) {
    //     axios.get(apiUrl + `/feedback-course/${course_id}/${user_id}`, {
    //         headers: {
    //             'Authorization': `Bearer ${accessToken}`
    //         }
    //     }).then(response => {
    //         const data = response.data;

    //         if (data.success) {
    //             displayFeedback(data.data);
    //         } else {
    //             console.error(data.message);
    //         }
    //     }).catch(error => {
    //         console.error('Error:', error);
    //     });
    // }

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
                                    list.innerHTML += `<li><a href="{{ url('member/course/topic') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/hand.png')}}">
                                        <span>${subtopic.st_name}</span>
                                    </a></li>`;
                                } else if(subtopic.st_jenis=='Modul') {
                                    list.innerHTML += `<li><a href="{{ url('member/course/topic') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/office-material.png')}}">
                                        <span>${subtopic.st_name}</span>
                                    </a></li>`;
                                } else if(subtopic.st_jenis=='Certificate') {
                                    list.innerHTML += `<li><a href="{{ url('member/certificate') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/certificate-icon.png')}}">
                                        <span>${subtopic.st_name}</span>
                                    </a></li>`;
                                } else {
                                    list.innerHTML += `<li><a href="{{ url('member/course/topic') }}/${courseId}/${subtopic.st_id}"><img src="{{asset('public/assets/img/doc-checkmark.png')}}">
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
