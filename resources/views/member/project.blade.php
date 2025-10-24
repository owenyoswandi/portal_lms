@extends('layouts.user.base')

@section('title', 'Projects')

<style>
    .link {
        position: absolute;
        width: 100%;
        height: 80%;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .card-body {
        padding-bottom: 5px;
    }

    #course .card:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
    }

    .card-title {
        min-height: 75px;
        margin-bottom: 0px;
        padding-bottom: 0px;
    }

    .card-img-top {
        height: 200px;
    }
</style>

@section('content')
    <div class="pagetitle">
        <h1>My Projects</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">My Projects</a></li>
                <li class="breadcrumb-item">View Data</li>
            </ol>
        </nav>
        <div class="mb-3">
            <a href="{{ url('/member/project/add') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Project
            </a>
        </div>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="row" id="course">
                    <!-- Projects will be dynamically inserted here -->
                </div>
            </div>
            <div id="error"></div>
        </div>
    </section>
@endsection

@section('java_script')
    <script>
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const accessToken = '{{ session('token') }}';
        const userId = '{{ session('userid') }}';

        window.onload = function() {
            fetchProjects();
        };

        function fetchProjects() {
            axios.get(apiUrl + `/project-by-user/${userId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        renderProjects(data.data);
                    } else {
                        console.error(data.message);
                        document.getElementById('error').innerHTML =
                            `<div class="alert alert-danger">${data.message}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('error').innerHTML =
                        `<div class="alert alert-danger">Error fetching projects: ${error.message}</div>`;
                });
        }

        function renderProjects(projects) {
            const courseContainer = document.getElementById('course');
            let html = '';
            projects.forEach(project => {
                const badgeClass = project.status === 'active' ? 'bg-success' : 'bg-secondary';
                html += `
        <div class="col-sm-3 mb-3">
          <div class="card h-100">
            <a href="project/${project.project_id}" class="text-decoration-none">
              <div class="card-body">
                <h5 class="card-title text-dark">${project.project_name}</h5>
                <p class="card-text text-dark">${project.project_desc}</p>
                <p class="card-text"><small class="text-muted">Start Date: ${project.start_date}</small></p>
                <p class="card-text"><small class="text-muted">End Date: ${project.end_date}</small></p>
                <p class="card-text">Status: <span class="badge ${badgeClass}">${project.status}</span></p>
              </div>
            </a>
          </div>
        </div>
      `;
            });
            courseContainer.innerHTML = html;
        }
    </script>
@endsection
