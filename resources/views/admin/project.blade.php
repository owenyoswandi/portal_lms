@extends('layouts.user.base')

@section('title', 'Kelola Project')

@section('content')
<div class="pagetitle">
    <h1>Kelola Project</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Kelola Project</li>
        </ol>
    </nav>
</div>

<section class="section">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Project Overview</h5>

            <!-- Tabs -->
            <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="resume-tab" data-bs-toggle="tab" data-bs-target="#resume" type="button" role="tab">Resume</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="list-tab" data-bs-toggle="tab" data-bs-target="#list" type="button" role="tab">List</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs" type="button" role="tab">Jobs</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="logbook-tab" data-bs-toggle="tab" data-bs-target="#logbook" type="button" role="tab">Logbook</button>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content mt-3" id="projectTabsContent">

                <!-- Resume -->
                <div class="tab-pane fade show active" id="resume" role="tabpanel">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Modul</th>
                                <th>Menu</th>
                                <th>% Complete</th>
                                <th>Bobot</th>
                                <th>Prosentase</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="resumeTableBody">
                            <!-- Filled dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- List -->
                <div class="tab-pane fade" id="list" role="tabpanel">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kegiatan</th>
                                <th>Bobot</th>
                                <th>Mulai</th>
                                <th>Akhir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="listTableBody">
                            <!-- Filled dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Jobs -->
                <div class="tab-pane fade" id="jobs" role="tabpanel">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode</th>
                                <th>Pekerjaan</th>
                                <th>Progress</th>
                                <th>Pelaksana</th>
                                <th>Start</th>
                                <th>Finish</th>
                            </tr>
                        </thead>
                        <tbody id="jobsTableBody">
                            <!-- Filled dynamically -->
                        </tbody>
                    </table>
                </div>

                <!-- Logbook -->
                <div class="tab-pane fade" id="logbook" role="tabpanel">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kegiatan</th>
                                <th>Job Code</th>
                                <th>Progress</th>
                                <th>Pelaksana</th>
                                <th>Durasi</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="logbookTableBody">
                            <!-- Filled dynamically -->
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", () => {
    getProjectData();
});

const apiUrl = '{{ config("app.api_url") }}';
const token = '{{ session("token") }}';

function getProjectData() {
    axios.get(`${apiUrl}/project`, {
        headers: { Authorization: `Bearer ${token}` }
    })
    .then(res => {
        const data = res.data.data;
        renderResume(data);
        renderList(data);
        renderJobs(data);
        renderLogbook(data);
    })
    .catch(err => console.error(err));
}

function renderResume(data) {
    const tbody = document.getElementById('resumeTableBody');
    tbody.innerHTML = `
        <tr>
            <td>Pembuatan Artikel</td>
            <td>Artikel 1</td>
            <td>39.22%</td>
            <td>11</td>
            <td>19.30%</td>
            <td>7.57%</td>
        </tr>`;
}

// You can repeat similar functions for List, Jobs, and Logbook
</script>
@endsection
