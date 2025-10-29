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
            RESUME TAB
        ============================ -->
        <div class="tab-pane fade show active" id="resume" role="tabpanel">
          <div class="row">
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
                  <tr class="table-secondary fw-bold">
                    <td colspan="6" class="text-start">Pembuatan Artikel</td>
                  </tr>
                  <tr><td>A</td><td>Pembuatan Artikel 1</td><td>39.22%</td><td>11</td><td>19.30%</td><td>7.57%</td></tr>
                  <tr><td>B</td><td>Pembuatan Artikel 2</td><td>0%</td><td>12</td><td>21.05%</td><td>0%</td></tr>
                  <tr><td>C</td><td>Pembuatan Artikel 3</td><td>0%</td><td>14</td><td>24.56%</td><td>0%</td></tr>

                  <tr class="table-secondary fw-bold">
                    <td colspan="6" class="text-start">Pembuatan luaran selain artikel</td>
                  </tr>
                  <tr><td>A</td><td>Pembuatan Materi Kuliah</td><td>0%</td><td>6</td><td>10.53%</td><td>0%</td></tr>
                  <tr><td>B</td><td>Pembuatan HKI</td><td>0%</td><td>7</td><td>12.28%</td><td>0%</td></tr>
                  <tr><td>C</td><td>Konten Media Sosial</td><td>0%</td><td>7</td><td>12.28%</td><td>0%</td></tr>

                  <tr class="fw-bold">
                    <td colspan="5" class="text-end">Total</td>
                    <td>7.57%</td>
                  </tr>
                </tbody>
              </table>
            </div>

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
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <!-- ===========================
            LIST TAB (Tabel seperti Excel Screenshot)
        ============================ -->
        <div class="tab-pane fade" id="list" role="tabpanel">
          <div class="table-responsive" style="overflow-x:auto;">
            <table class="table table-bordered text-center align-middle" style="font-size: 13px; min-width: 1600px;">
              <thead class="table-light">
                <tr>
                  <th rowspan="2" style="vertical-align: middle;">No</th>
                  <th rowspan="2" style="vertical-align: middle;">Kegiatan</th>
                  <th rowspan="2" style="vertical-align: middle;">Bobot Perkiraan</th>
                  <th colspan="4">Mei 2025</th>
                  <th colspan="4">Jun 2025</th>
                  <th colspan="4">Jul 2025</th>
                  <th colspan="4">Agu 2025</th>
                  <th colspan="4">Sep 2025</th>
                  <th colspan="4">Okt 2025</th>
                  <th rowspan="2" style="vertical-align: middle;">Mulai</th>
                  <th rowspan="2" style="vertical-align: middle;">Akhir</th>
                  <th rowspan="2" style="vertical-align: middle;">Keterangan</th>
                </tr>
                <tr>
                  @for ($i = 0; $i < 6; $i++)
                    <th>1</th><th>2</th><th>3</th><th>4</th>
                  @endfor
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td class="text-start">Pembuatan Artikel 1 (tentang User)</td>
                  <td>20%</td>
                  <td colspan="8" class="bg-primary text-white"></td>
                  <td colspan="16"></td>
                  <td>1-May-2025</td>
                  <td>21-Jun-2025</td>
                  <td>Menguji pengguna perlu solusi yang dihasilkan</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td class="text-start">Pembuatan Artikel 2 (Prototype TKT)</td>
                  <td>20%</td>
                  <td colspan="4"></td>
                  <td colspan="8" class="bg-success text-white"></td>
                  <td colspan="12"></td>
                  <td>1-Jun-2025</td>
                  <td>7-Aug-2025</td>
                  <td>Prototype sudah jadi dan fungsional</td>
                </tr>
                <tr>
                  <td>3</td>
                  <td class="text-start">Pembuatan Artikel 3 (Implementasi)</td>
                  <td>25%</td>
                  <td colspan="8"></td>
                  <td colspan="8" class="bg-secondary text-white"></td>
                  <td colspan="8"></td>
                  <td>1-Jul-2025</td>
                  <td>30-Oct-2025</td>
                  <td>Menunggu revisi 2 bulan</td>  
                </tr>
                <tr>
                  <td>4</td>
                  <td class="text-start">Pembuatan Materi Kuliah</td>
                  <td>10%</td>
                  <td colspan="16"></td>
                  <td colspan="4" class="bg-info text-white"></td>
                  <td colspan="4"></td>
                  <td>1-Sep-2025</td>
                  <td>21-Sep-2025</td>
                  <td>Perencanaan materi selesai</td>
                </tr>
                <tr>
                  <td>5</td>
                  <td class="text-start">Pembuatan HKI</td>
                  <td>15%</td>
                  <td colspan="16"></td>
                  <td colspan="4" class="bg-warning text-dark"></td>
                  <td colspan="4"></td>
                  <td>8-Sep-2025</td>
                  <td>7-Oct-2025</td>
                  <td>HKI sudah didaftarkan</td>
                </tr>
                <tr>
                  <td>6</td>
                  <td class="text-start">Pembuatan Konten Media Sosial</td>
                  <td>10%</td>
                  <td colspan="20"></td>
                  <td colspan="4" style="background-color:#a020f0;" class="text-white"></td>
                  <td>1-Oct-2025</td>
                  <td>30-Nov-2025</td>
                  <td>Konten bisa dibuat lebih dari satu</td>
                </tr>
              </tbody>
            </table>
          </div>
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
            <tbody>
              <tr><td colspan="7" class="text-center text-muted">Belum ada pekerjaan</td></tr>
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
            <tbody>
              <tr><td colspan="8" class="text-center text-muted">Belum ada catatan logbook</td></tr>
            </tbody>
          </table>
        </div>

      </div>
    </div>
  </div>
</section>
@endsection 