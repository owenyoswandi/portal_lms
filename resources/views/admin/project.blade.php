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

      <!-- Add Project -->
      <a href="{{ url('/member/project/add') }}" class="btn btn-primary my-3">
        <i class="bi bi-plus-circle"></i> Add Project
      </a>

      <!-- Tab Content -->
      <div class="tab-content mt-3" id="projectTabsContent">

        <!-- ===========================
            RESUME TAB (Static Layout)
        ============================ -->
        <div class="tab-pane fade show active" id="resume" role="tabpanel">
        <div class="row">
            <!-- ======= LEFT TABLE (Modul, Menu, etc) ======= -->
            <div class="col-md-8">
            <h5 class="fw-bold mb-3 text-center">DASHBOARD</h5>
            <table class="table table-bordered align-middle text-center">
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
                <tbody>
                <!-- Pembuatan Artikel -->
                <tr class="table-secondary fw-bold">
                    <td colspan="6" class="text-start">Pembuatan Artikel</td>
                </tr>
                <tr>
                    <td></td>
                    <td>A Pembuatan Artikel 1 (tentang User)</td>
                    <td>39.22%</td>
                    <td>11</td>
                    <td>19.30%</td>
                    <td>7.57%</td>
                </tr>
                <tr>
                    <td></td>
                    <td>B Pembuatan Artikel 2 (tentang Prototype TKT 4)</td>
                    <td>0.00%</td>
                    <td>12</td>
                    <td>21.05%</td>
                    <td>0.00%</td>
                </tr>
                <tr>
                    <td></td>
                    <td>C Pembuatan Artikel 3 (tentang Prototype TKT 5)</td>
                    <td>0.00%</td>
                    <td>14</td>
                    <td>24.56%</td>
                    <td>0.00%</td>
                </tr>

                <!-- Pembuatan luaran selain artikel -->
                <tr class="table-secondary fw-bold">
                    <td colspan="6" class="text-start">Pembuatan luaran selain artikel</td>
                </tr>
                <tr>
                    <td></td>
                    <td>A Pembuatan Materi Kuliah</td>
                    <td>0.00%</td>
                    <td>6</td>
                    <td>10.53%</td>
                    <td>0.00%</td>
                </tr>
                <tr>
                    <td></td>
                    <td>B Pembuatan HKI</td>
                    <td>0.00%</td>
                    <td>7</td>
                    <td>12.28%</td>
                    <td>0.00%</td>
                </tr>
                <tr>
                    <td></td>
                    <td>C Pembuatan konten Media Sosial</td>
                    <td>0.00%</td>
                    <td>7</td>
                    <td>12.28%</td>
                    <td>0.00%</td>
                </tr>

                <!-- Total -->
                <tr class="fw-bold">
                    <td colspan="5" class="text-end">Total</td>
                    <td>7.57%</td>
                </tr>
                </tbody>
            </table>

            <!-- Summary -->
            <div class="mt-3 ms-2">
                <p class="mb-1">Bobot Aktifitas total: <strong>57</strong></p>
                <p class="mb-0">Prosentase total: <strong>7.57%</strong></p>
            </div>
            </div>

            <!-- ======= RIGHT TABLE (Job Data) ======= -->
            <div class="col-md-4">
            <table class="table table-bordered align-middle text-center mt-4">
                <thead class="table-primary">
                <tr>
                    <th>Job</th>
                    <th>Nama</th>
                    <th>Waktu kerja (min)</th>
                </tr>
                </thead>
                <tbody>
                <tr><td>Ketua</td><td>QQ</td><td>120</td></tr>
                <tr><td>Peneliti 1</td><td>Ayu</td><td>90</td></tr>
                <tr><td>Peneliti 2</td><td>CC</td><td>70</td></tr>
                <tr><td>Peneliti 3</td><td>DD</td><td>0</td></tr>
                <tr><td>Peneliti 4</td><td>EE</td><td>100</td></tr>
                <tr><td>Mahasiswa 1</td><td>AB</td><td>0</td></tr>
                <tr><td>Mahasiswa 2</td><td>AC</td><td>0</td></tr>
                <tr><td>Mahasiswa 3</td><td>AD</td><td>0</td></tr>
                <tr><td>Mahasiswa 4</td><td>AE</td><td>0</td></tr>
                </tbody>
            </table>
            </div>
        </div>
        </div>

        <!-- ===========================
             LIST TAB
        ============================ -->
        <div class="tab-pane fade" id="list" role="tabpanel">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
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
              <tr>
                <td colspan="6" class="text-center text-muted">Belum ada data kegiatan</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- ===========================
             JOBS TAB
        ============================ -->
        <div class="tab-pane fade" id="jobs" role="tabpanel">
          <table class="table table-striped table-hover align-middle">
            <thead class="table-primary">
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
              <tr>
                <td colspan="7" class="text-center text-muted">Belum ada pekerjaan</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- ===========================
             LOGBOOK TAB
        ============================ -->
        <div class="tab-pane fade" id="logbook" role="tabpanel">
          <table class="table table-hover align-middle">
            <thead class="table-primary">
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
              <tr>
                <td colspan="8" class="text-center text-muted">Belum ada catatan logbook</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="projectIdToDelete">
        <p>Anda yakin akan menghapus project <span id="projectnameToDelete" class="fw-bold"></span>?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-danger" onclick="deleteProject()">Hapus</button>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  getProjects();
});

const apiUrl = '{{ config('app.api_url') }}';
const accessToken = '{{ session('token') }}';
const baseUrl = "{{ rtrim(url('/'), '/') }}";

function getProjects() {
  axios.get(`${apiUrl}/project`, {
    headers: { 'Authorization': `Bearer ${accessToken}` }
  })
  .then(response => {
    const data = response.data;
    if (data.success) {
      renderResumeTable(data.data);
      // Later, you can call renderList(data.data), renderJobs(data.data), etc.
    } else {
      console.error(data.message);
    }
  })
  .catch(error => console.error('Error:', error));
}

function renderResumeTable(projects) {
  const tbody = document.getElementById('resumeTableBody');
  tbody.innerHTML = '';

  if (!projects || projects.length === 0) {
    tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">No projects found</td></tr>';
    return;
  }

  projects.forEach((p, index) => {
    const row = `
      <tr>
        <td>${index + 1}</td>
        <td>${p.project_name}</td>
        <td>${p.project_desc || '-'}</td>
        <td>${formatDate(p.start_date)}</td>
        <td>${formatDate(p.end_date)}</td>
        <td>${p.status}</td>
        <td>${p.completion}%</td>
        <td>
          <div class="d-flex gap-2 flex-column">
            <a href="${baseUrl}/member/project/${p.project_id}" class="btn btn-warning btn-sm">View</a>
            <button class="btn btn-danger btn-sm" onclick="deleteProjectConfirmation('${p.project_id}', '${p.project_name}')">Hapus</button>
          </div>
        </td>
      </tr>`;
    tbody.insertAdjacentHTML('beforeend', row);
  });
}

function formatDate(dateString) {
  if (!dateString) return '-';
  const date = new Date(dateString);
  const day = date.getDate().toString().padStart(2, '0');
  const month = (date.getMonth() + 1).toString().padStart(2, '0');
  const year = date.getFullYear();
  return `${day}-${month}-${year}`;
}

function deleteProjectConfirmation(projectId, projectName) {
  document.getElementById('projectIdToDelete').value = projectId;
  document.getElementById('projectnameToDelete').textContent = projectName;
  const modal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
  modal.show();
}

function deleteProject() {
  const projectId = document.getElementById('projectIdToDelete').value;
  axios.put(`${apiUrl}/project-delete/${projectId}`, {}, {
    headers: { 'Authorization': `Bearer ${accessToken}` }
  })
  .then(response => {
    const data = response.data;
    if (data.success) {
      const modalEl = document.getElementById('deleteConfirmationModal');
      const modal = bootstrap.Modal.getInstance(modalEl);
      modal.hide();
      getProjects();
    } else {
      console.error(data.message);
    }
  })
  .catch(error => console.error('Error deleting project:', error));
}
</script>
@endsection
