@extends('layouts.user.base')

@section('title', 'Profile')

@section('content')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ asset('public/assets/img/user.png') }}" style="width:200px" alt="Profile" class="rounded-circle">
                        <h2 class="profileFullName"></h2>
                    </div>
                </div>
                @if (session('role') == 'Pasien')
                    <div class="row">
                        <div class="d-flex">
                            <a type="button" class="btn btn-primary btn-lg mx-auto"
                                href="{{ route('user-profile-dtl') }}">Detail Data Diri</a>
                        </div>

                    </div>
                @endif
            </div>

            <div class="col-xl-8">

                <div class="card">
                    <div class="card-body pt-3">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change
                                    Password</button>
                            </li>

                        </ul>

                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">General Profile</h5>
                                    <div class="my-auto">
                                        <a type="button" class="btn btn-primary"
                                            href="{{ route('user-profile-edit-general') }}">
                                            Edit General Profile
                                        </a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                                    <div class="col-lg-9 col-md-8 profileFullName"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Username</div>
                                    <div class="col-lg-9 col-md-8 profileUsername"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8 profileEmail"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">NIK</div>
                                    <div class="col-lg-9 col-md-8 profileNIK"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Phone</div>
                                    <div class="col-lg-9 col-md-8 profilePhone"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Gender</div>
                                    <div class="col-lg-9 col-md-8 profileGender"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Date of Birth</div>
                                    <div class="col-lg-9 col-md-8 profileBirthdate"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Age</div>
                                    <div class="col-lg-9 col-md-8" id="umur"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Pendidikan</div>
                                    <div class="col-lg-9 col-md-8 profilePendidikan"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Pekerjaan</div>
                                    <div class="col-lg-9 col-md-8 profilePekerjaan"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Agama</div>
                                    <div class="col-lg-9 col-md-8 profileAgama"></div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                                    <div class="col-lg-9 col-md-8 profileAddress">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Ward</div>
                                    <div class="col-lg-9 col-md-8 profileKelurahan" id="kelurahan">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Subdistrict</div>
                                    <div class="col-lg-9 col-md-8 profileKecamatan" id="kecamatan">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">City</div>
                                    <div class="col-lg-9 col-md-8 profileKab" id="kabupaten">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-3 col-md-4 label">Province</div>
                                    <div class="col-lg-9 col-md-8 profileProvinsi" id='provinsi'></div>
                                </div>

                            </div>


                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form method="post" action="{{ route('change-password') }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <input type="hidden" name="username" value="" id="usernameInput">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">
                                            New Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="newpassword" type="password" class="form-control"
                                                id="newPassword">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>
                        </div>

                    </div><!-- End Bordered Tabs -->

                </div>
            </div>

        </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getData();
            // getDataDetail();
        });

        const apiUrl = '{{ config('app.api_url') }}';
        const accessToken = '{{session('token')}}';
        const username = storedUserData.username;
        const userId = storedUserData.id
        const url = '{{ config('app.app_url') }}'

        document.getElementById('usernameInput').value = username;

        function getData() {
            axios.get(apiUrl + `/user/${username}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data[0])
                        updateProfileGeneral(data.data[0]);

                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getDataDetail() {
            axios.get(apiUrl + `detail-profile-jwb-byuserid/${userId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data)
                        updateProfileDetails(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateProfileDetails(data) {
            data.forEach(d => {
                document.getElementById(d.jwb_profile_id).innerHTML = d.jwb_jawaban
            });
        }

        async function updateProfileGeneral(userData) {
            const tanggal = new Date()
            const formattedDate = new Date(tanggal.setHours(tanggal.getHours()+7))
            const umur = document.getElementById('umur')
            const provinsi = document.getElementById('provinsi')
            const kabupaten = document.getElementById('kabupaten')
            const kecamatan = document.getElementById('kecamatan')
            const kelurahan = document.getElementById('kelurahan')
            provinsi.innerHTML = await getNameByCode('provinsi', userData.provinsi, '', '', '')
            kabupaten.innerHTML = await getNameByCode('kabupaten', userData.kota_kab, userData.provinsi, '', '')
            kecamatan.innerHTML = await getNameByCode('kecamatan', userData.kecamatan, '', userData.kota_kab, '')
            kelurahan.innerHTML = await getNameByCode('kelurahan', userData.kelurahan, '', '', userData.kecamatan)
            umur.innerHTML = Math.floor((formattedDate - new Date(userData.tgl_lhr)) / (365.25 * 24 * 60 * 60 * 1000)) +
                ' tahun ' + Math.floor(((formattedDate - new Date(userData.tgl_lhr)) % (365.25 * 24 * 60 * 60 * 1000)) / (
                    30.44 * 24 * 60 * 60 * 1000)) + ' bulan';
            const elementsToUpdate = {
                'profileFullName': userData.nama,
                'profileUsername': userData.username,
                'profileAddress': userData.alamat,
                'profilePhone': userData.no_hp,
                'profileGender': userData.jk,
                'profileBirthdate': formatBirthdate(userData.tgl_lhr),
                'profileNIK': userData.nik ? userData.nik : '',
                'profileEmail': userData.email,
                'profilePendidikan': userData.pendidikan,
                'profilePekerjaan': userData.pekerjaan,
                'profileAgama': userData.agama,
            };

            Object.entries(elementsToUpdate).forEach(([elementId, value]) => {
                const elements = document.querySelectorAll(`.${elementId}`);
                elements.forEach(element => {
                    if (element.tagName === 'INPUT' || element.tagName === 'SELECT') {
                        element.value = value;
                    } else {
                        element.innerText = value;
                    }
                });
            });
        }

        async function getNameByCode(type, code, provCode, kabCode, kecCode) {
            const url = '{{ config('app.app_url') }}'
            let dataEndpoint = ''
            if (type == 'provinsi') {
                dataEndpoint = 'provinces.json'
            } else if (type == 'kabupaten') {
                dataEndpoint = 'kabupatens.json'
            } else if (type == 'kelurahan') {
                dataEndpoint = `output_${kecCode}.json`
            } else {
                dataEndpoint = 'kecamatans.json'
            }

            const response = await axios.get(`${url}/public/assets/js/${dataEndpoint}`);
            const data = response.data;
            console.log(data)
            let filteredData = ''
            if (type == 'provinsi') {
                filteredData = data
            } else if (type == 'kabupaten') {
                filteredData = data.filter(d => d.provcode == provCode)
            } else if (type == 'kelurahan') {
                filteredData = data
            } else {
                filteredData = data.filter(d => d.kabcode == kabCode)
            }
            const foundItem = filteredData.find(item => item.code == code);

            if (foundItem) {
                console.log(foundItem.name);
                return foundItem.name;
            }


        }
    </script>
@endsection
