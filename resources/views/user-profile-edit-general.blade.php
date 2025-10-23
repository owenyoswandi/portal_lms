@extends('layouts.user.base')

@section('title', 'Edit Profile')

@section('content')
    <div class="pagetitle">
        <a href="{{ url('user-profile') }}" class="btn btn-primary mb-3">Back</a>

        <div class="alert alert-success alert-dismissible fade show d-none" role="alert" id="success-data-post">
            Data has been save.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <h1>Edit General Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-profile') }}">Profile</a></li>
                <li class="breadcrumb-item active">Edit generale profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <!-- Profile Edit Form -->
                <form id="editUserProfileForm">
                    <div class="row mb-3">

                        {{-- <form action="" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile
                                    Image</label>
                                <div class="col-md-8 col-lg-9">
                                    <img src="{{ asset('public/assets/img/profile-img.jpg') }}" alt="Profile">
                                    <div class="button-wrapper my-4">
                                        <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                            <span class="d-none d-sm-block">Upload new photo</span>
                                            <i class="mdi mdi-tray-arrow-up d-block d-sm-none"></i>
                                            <input type="file" id="upload" class="account-file-input"
                                                hidden accept="image/png, image/jpeg" />
                                        </label>
                                        <button type="button"
                                            class="btn btn-outline-danger account-image-reset mb-3">
                                            <i class="mdi mdi-reload d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Reset</span>
                                        </button>

                                        <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 800K
                                        </div>
                                    </div>

                                </div>
                            </form> --}}


                        <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control profileFullName" id="fullName">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="NIK" class="col-md-4 col-lg-3 col-form-label">NIK</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nik" type="text" class="form-control profileNIK" id="NIK">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="text" class="form-control profileEmail" id="email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="no_hp" type="text" class="form-control profilePhone" id="Phone">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Gender</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileGender" name="jk"
                                    aria-label="Default select example">
                                    <option value="Laki-laki">Male</option>
                                    <option value="Perempuan">Female</option>
                                </select>
                            </div>
                        </div>


                        <div class="row mb-3">
                            <label for="Birthdate" class="col-md-4 col-lg-3 col-form-label">Date of Bith</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="tgl_lhr" type="date" class="form-control profileBirthdate" id="Birthdate">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="group_id" class="col-md-4 col-lg-3 col-form-label">Group</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileGroup" name="group_id" id="group_id" aria-label="Pilih group">
                                    <!-- Option akan diisi dari JavaScript -->
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Education</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profilePendidikan" name="pendidikan"
                                    aria-label="Default select example">
                                    <option value="Tidak Sekolah">Tidak Sekolah</option>
                                    <option value="SD">SD</option>
                                    <option value="SLTP">SLTP</option>
                                    <option value="SLTA">SLTA</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3 atau lebih">S3 atau lebih</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Pekerjaan</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profilePekerjaan" name="pekerjaan"
                                    aria-label="Default select example">
                                    <option value="Tidak Bekerja">Tidak Bekerja</option>
                                    <option value="Pegawai Negeri/Swasta">Pegawai Negeri/Swasta</option>
                                    <option value="Wiraswasta">Wiraswasta</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Religion</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileAgama" name="agama"
                                    aria-label="Default select example">
                                    <option value="Islam">Islam</option>
                                    <option value="Katolik">Katolik</option>
                                    <option value="Kristen Protestan">Kristen Protestan</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Budha">Budha</option>
                                    <option value="Konghucu">Kong Hu Cu</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                        </div>

                        

						
                        <div class="row mb-3">
                            <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                            <div class="col-md-8 col-lg-9">
                                <textarea name="alamat" type="text" class="form-control profileAddress" id="Address"></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Provinsi" class="col-md-4 col-lg-3 col-form-label">Province</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileProvinsi" name="provinsi" id="provinsi"
                                    aria-label="Pilih salah satu">
                                </select>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="kabupaten" class="col-md-4 col-lg-3 col-form-label">City</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileKab" name="kota_kab" id="kabupaten"
                                    aria-label="Pilih salah satu">
                                </select>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="kecamatan" class="col-md-4 col-lg-3 col-form-label">Ward</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileKecamatan" name="kecamatan" id="kecamatan"
                                    aria-label="Pilih salah satu">
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="kelurahan" class="col-md-4 col-lg-3 col-form-label">Subdistrict</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileKelurahan" name="kelurahan" id="kelurahan"
                                    aria-label="Pilih salah satu">
                                </select>
                            </div>
                        </div>
                </form>
                <div class="text-center">
                    <button type="button" onclick="editUser()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getwilayah();
            fetchGroups();
            getData();
        });

        const apiUrl = '{{ config('app.api_url') }}';
        const url = '{{ config('app.app_url') }}'
        const accessToken = '{{session('token')}}';
        const userId = storedUserData.id
        const regenciesDropdown = document.getElementById('kabupaten');
        const provincesDropdown = document.getElementById('provinsi');
        const kecDropdown = document.getElementById('kecamatan');
        const kelDropdown = document.getElementById('kelurahan');


        async function getData() {
            const response = await axios.get(apiUrl + `/user/${storedUserData.username}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            const data = response.data;
            if (data.success) {
                console.log(data.data[0])
                provId = data.data[0].provinsi
                kabId = data.data[0].kota_kab
                updateProfileDetails(data.data[0]);
            } else {
                console.error(data.message);
            }
            // .catch(error => {
            //     console.error('Error:', error);
            // });
        }

        async function updateProfileDetails(userData) {
            await fetchRegencies(userData.provinsi);
            await fetchKecamatan(userData.kota_kab);
            await fetchKelurahan(userData.kecamatan)
            setSelectOption(document.querySelector('.profileKab'), userData.kota_kab);
            setSelectOption(document.querySelector('.profileKecamatan'), userData.kecamatan);
            setSelectOption(document.querySelector('.profileKelurahan'), userData.kelurahan);
            const elementsToUpdate = {
                'profileFullName': userData.nama,
                'profileAddress': userData.alamat,
                'profilePhone': userData.no_hp,
                'profileGender': userData.jk,
                'profileProvinsi': userData.provinsi,
                // 'profileKab': userData.kota_kab ? userData.kota_kab : '',
                'profileNIK': userData.nik ? userData.nik : '',
                'profileKelurahan': userData.kelurahan ? userData.kelurahan : '',
                // 'profileKecamatan': userData.kecamatan ? userData.kecamatan : '',
                'profileEmail': userData.email,
                'profileNoMr': userData.mr_no,
                'profilePendidikan': userData.pendidikan,
                'profilePekerjaan':userData.pekerjaan,
                'profileAgama':userData.agama,
                'profilePenghasilan':userData.penghasilan,
                'profilePayer':userData.payer,
                'profilePendampingNama':userData.pendamping_nama,
                'profilePendampingNoHp':userData.pendamping_nohp,
                'profilePendampingHub':userData.pendamping_hubungan,
                'profileGroup': userData.group_id
            };
            document.getElementById('Birthdate').value = userData.tgl_lhr;
            document.getElementById('group_id').value = userData.group_id;

            Object.entries(elementsToUpdate).forEach(([elementId, value]) => {
                const elements = document.querySelectorAll(`.${elementId}`);
                elements.forEach(element => {
                    // console.log(element)
                    if (element.tagName === 'INPUT' || element.tagName === 'TEXTAREA') {
                        element.value = value;
                    } else {
                        setSelectOption(element, value)
                    }
                });
            });
        }

        function setSelectOption(selectElement, value) {
            const options = selectElement.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value === value) {
                    options[i].selected = true;
                    break;
                }
            }
        }

        function editUser() {
            const form = document.getElementById('editUserProfileForm');
            const formData = new FormData(form);
            const userData = {};
            formData.forEach((value, key) => {
                userData[key] = value;
            });
            userData['role'] = storedUserData.role;
            userData['username'] = storedUserData.username;
            userData['user_id'] = storedUserData.id;
            //userData['mr_no'] = storedUserData.mr_no

            console.log(userData)
            axios.put(apiUrl + `/user/update`, userData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('User updated successfully.');
                        window.location.href = "{{ url('user-profile') }}"
                    } else {
                        console.error('Updating user failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getwilayah() {
            const provinceData = url + '/public/assets/js/provinces.json'
            axios.get(provinceData)
                .then(response => {
                    const provinces = response.data;
                    provinces.forEach(province => {
                        const option = document.createElement('option');
                        option.value = province.code;
                        option.text = province.name;
                        provincesDropdown.add(option);
                    });
                })
                .catch(error => console.error('Error fetching provinces:', error));

            provincesDropdown.addEventListener('change', function() {
                const selectedProvinceId = this.value;

                if (selectedProvinceId) {
                    fetchRegencies(selectedProvinceId);
                } else {
                    regenciesDropdown.innerHTML = '<option value="">Select Regency</option>';
                }
            });

            regenciesDropdown.addEventListener('change', function() {
                const selectedRegencyId = this.value;
                if (selectedRegencyId) {
                    fetchKecamatan(selectedRegencyId);
                } else {
                    kecDropdown.innerHTML = '<option value="">Select Kecamatan</option>';
                }
            });
            kecDropdown.addEventListener('change', function() {
                const selectedRegencyId = this.value;
                if (selectedRegencyId) {
                    fetchKelurahan(selectedRegencyId);
                } else {
                    kelDropdown.innerHTML = '<option value="">Select Kelurahan</option>';
                }
            });
        }

        async function fetchRegencies(provinceId) {
            const kabData = url + '/public/assets/js/kabupatens.json'
            await axios.get(kabData)
                .then(response => {
                    const regencies = response.data.filter(d => d.provcode == provinceId);
                    regenciesDropdown.innerHTML = '<option value="" disabled>Pilih salah satu</option>';
                    regencies.forEach(regency => {
                        const option = document.createElement('option');
                        option.value = regency.code;
                        option.text = regency.name;
                        regenciesDropdown.add(option);
                    });
                })
                .catch(error => console.error('Error fetching regencies:', error));
        };

        async function fetchKecamatan(kabId) {
            const kecamatanData = url + '/public/assets/js/kecamatans.json'
            await axios.get(kecamatanData)
                .then(response => {
                    const regencies = response.data.filter(d => d.kabcode == kabId);
                    kecDropdown.innerHTML = '<option value="" disabled>Pilih salah satu</option>';
                    regencies.forEach(regency => {
                        const option = document.createElement('option');
                        option.value = regency.code;
                        option.text = regency.name;
                        kecDropdown.add(option);
                    });
                })
                .catch(error => console.error('Error fetching regencies:', error));
        };

        async function fetchKelurahan(kecId){
            const kelurahanData = url + `/public/assets/js/output_${kecId}.json`
            await axios.get(kelurahanData)
                .then(response => {
                    const regencies = response.data.filter(d => d.keccode == kecId);
                    kelDropdown.innerHTML = '<option value="" disabled>Pilih salah satu</option>';
                    regencies.forEach(regency => {
                        const option = document.createElement('option');
                        option.value = regency.code;
                        option.text = regency.name;
                        kelDropdown.add(option);
                    });
                })
                .catch(error => console.error('Error fetching regencies:', error));
        }

        async function fetchGroups() {
            try {
                const response = await axios.get(apiUrl + '/group', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                });

                const groupDropdown = document.getElementById('group_id');
                const groups = response.data.data;

                groupDropdown.innerHTML = '<option value="" disabled selected>Choose Group</option>';
                groups.forEach(group => {
                    const option = document.createElement('option');
                    option.value = group.group_id;
                    option.text = group.group_name;
                    groupDropdown.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching groups:', error);
            }
        }

    </script>
@endsection
