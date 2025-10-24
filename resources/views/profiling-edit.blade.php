@extends('layouts.user.base')

@section('title', 'Change Personal Data')

@section('content')
    <div class="pagetitle">
		<a href="{{ url('profiling') }}" class="btn btn-primary mb-3">Back</a>
        @if (isset($_GET['status']))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				Data has been saved.
				<button type="button" class="btn-close" data-bs-dismiss="alert"
					aria-label="Close"></button>
			</div>
		@elseif (isset($_GET['failed']))
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				Failed, try again.
				<button type="button" class="btn-close" data-bs-dismiss="alert"
					aria-label="Close"></button>
			</div>
		@endif
        <h1>Change Personal Data</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-profile') }}">Profiling</a></li>
                <li class="breadcrumb-item active">Change Personal Data</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <!-- Profile Edit Form -->
                <form id="editUserProfileForm">
                    <div class="row mb-3">

                        <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nama" type="text" class="form-control profileFullName" id="fullName" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="NIK" class="col-md-4 col-lg-3 col-form-label">NIK</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="nik" type="text" class="form-control profileNIK" id="NIK" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="text" class="form-control profileEmail" id="email" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Phone" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="no_hp" type="text" class="form-control profilePhone" id="Phone" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Gender</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileGender" name="jk"
                                    aria-label="Default select example" disabled>
                                    <option value="Laki-laki">Male</option>
                                    <option value="Perempuan">Female</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Birthdate" class="col-md-4 col-lg-3 col-form-label">Date of Bith</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="tgl_lhr" type="date" class="form-control profileBirthdate" id="Birthdate" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-4 col-lg-3 col-form-label">Education</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profilePendidikan" name="pendidikan"
                                    aria-label="Default select example" disabled>
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
                                    aria-label="Default select example" disabled>
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
                                    aria-label="Default select example" disabled>
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
                                <textarea name="alamat" type="text" class="form-control profileAddress" id="Address" disabled></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Provinsi" class="col-md-4 col-lg-3 col-form-label">Province</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileProvinsi" name="provinsi" id="provinsi"
                                    aria-label="Pilih salah satu" disabled>
                                </select>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="kabupaten" class="col-md-4 col-lg-3 col-form-label">City</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileKab" name="kota_kab" id="kabupaten"
                                    aria-label="Pilih salah satu" disabled>
                                </select>
                            </div>

                        </div>

                        <div class="row mb-3">
                            <label for="kecamatan" class="col-md-4 col-lg-3 col-form-label">Ward</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileKecamatan" name="kecamatan" id="kecamatan"
                                    aria-label="Pilih salah satu" disabled>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="kelurahan" class="col-md-4 col-lg-3 col-form-label">Subdistrict</label>
                            <div class="col-md-8 col-lg-9">
                                <select class="form-select profileKelurahan" name="kelurahan" id="kelurahan"
                                    aria-label="Pilih salah satu" disabled>
                                </select>
                            </div>
                        </div>
                </form>
				<br>
				<i>If you want change general profile, you can update in <a href="{{ url('user-profile') }}">here</a>.</i>
				<br>
				<br>
				<form id="editProfiling">
					<div class="row mb-3">
						<h3>Education Profile</h3>
					</div>

					<div class="row mb-3">
						<label for="jenjang_pendidikan" class="col-md-4 col-lg-3 col-form-label">Educational level</label>
						<div class="col-md-8 col-lg-9">
							<input name="jenjang_pendidikan" type="text" class="form-control profiling1" id="jenjang_pendidikan" placeholder="Example: S1" value="<?= $profiling['jenjang_pendidikan'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="nama_institusi" class="col-md-4 col-lg-3 col-form-label">Institutions</label>
						<div class="col-md-8 col-lg-9">
							<input name="nama_institusi" type="text" class="form-control profiling2" id="nama_institusi" placeholder="Example: Binus University"  value="<?= $profiling['nama_institusi'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="tahun_masuk" class="col-md-4 col-lg-3 col-form-label">Year of Graduation</label>
						<div class="col-md-8 col-lg-9">
							<input name="tahun_masuk" type="text" class="form-control profiling3" id="tahun_masuk"   value="<?= $profiling['tahun_masuk'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="tahun_lulus" class="col-md-4 col-lg-3 col-form-label">Year of Graduation</label>
						<div class="col-md-8 col-lg-9">
							<input name="tahun_lulus" type="text" class="form-control profiling4" id="tahun_lulus"  value="<?= $profiling['tahun_lulus'] ?>" >
						</div>
					</div>

					<div class="row mb-3">
						<label for="gelar" class="col-md-4 col-lg-3 col-form-label">Gelar</label>
						<div class="col-md-8 col-lg-9">
							<input name="gelar" type="text" class="form-control profiling5" id="gelar"  placeholder="Example: S.Kom."  value="<?= $profiling['gelar'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="bidang_studi" class="col-md-4 col-lg-3 col-form-label">Field of study</label>
						<div class="col-md-8 col-lg-9">
							<input name="bidang_studi" type="text" class="form-control profiling6" id="bidang_studi" placeholder="Example: Information System"  value="<?= $profiling['bidang_studi'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<h3>Job Profile</h3>
					</div>

					<div class="row mb-3">
						<label for="nama_perusahaan" class="col-md-4 col-lg-3 col-form-label">Company name</label>
						<div class="col-md-8 col-lg-9">
							<input name="nama_perusahaan" type="text" class="form-control profiling7" id="nama_perusahaan"  value="<?= $profiling['nama_perusahaan'] ?>" >
						</div>
					</div>

					<div class="row mb-3">
						<label for="posisi" class="col-md-4 col-lg-3 col-form-label">Position</label>
						<div class="col-md-8 col-lg-9">
							<input name="posisi" type="text" class="form-control profiling8" id="posisi"  value="<?= $profiling['posisi'] ?>" >
						</div>
					</div>

					<div class="row mb-3">
						<label for="periode_mulai" class="col-md-4 col-lg-3 col-form-label">Period Start</label>
						<div class="col-md-8 col-lg-9">
							<input name="periode_mulai" type="text" class="form-control profiling9" id="periode_mulai"  value="<?= $profiling['periode_mulai'] ?>" >
						</div>
					</div>

					<div class="row mb-3">
						<label for="periode_selesai" class="col-md-4 col-lg-3 col-form-label">Periode End</label>
						<div class="col-md-8 col-lg-9">
							<input name="periode_selesai" type="text" class="form-control profiling10" id="periode_selesai" placeholder='If you are still working at the same place currently, you can fill in "Now"'  value="<?= $profiling['periode_selesai'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="tanggung_jawab" class="col-md-4 col-lg-3 col-form-label">Responsibility</label>
						<div class="col-md-8 col-lg-9">
							<input name="tanggung_jawab" type="text" class="form-control profiling11" id="tanggung_jawab" placeholder="Example: building an information system"  value="<?= $profiling['tanggung_jawab'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<h3>Social Media Profile</h3>
					</div>

					<div class="row mb-3">
						<label for="linkedin" class="col-md-4 col-lg-3 col-form-label">LinkedIn</label>
						<div class="col-md-8 col-lg-9">
							<input name="linkedin" type="text" class="form-control profiling12" id="linkedin" placeholder="Example: https://"  value="<?= $profiling['linkedin'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="twitter" class="col-md-4 col-lg-3 col-form-label">Twitter</label>
						<div class="col-md-8 col-lg-9">
							<input name="twitter" type="text" class="form-control profiling13" id="twitter" placeholder="Example: https://"   value="<?= $profiling['twitter'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="instagram" class="col-md-4 col-lg-3 col-form-label">Instagram</label>
						<div class="col-md-8 col-lg-9">
							<input name="instagram" type="text" class="form-control profiling14" id="instagram" placeholder="Example: https://"   value="<?= $profiling['instagram'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="facebook" class="col-md-4 col-lg-3 col-form-label">Facebook</label>
						<div class="col-md-8 col-lg-9">
							<input name="facebook" type="text" class="form-control profiling15" id="facebook" placeholder="Example: https://"   value="<?= $profiling['facebook'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="github" class="col-md-4 col-lg-3 col-form-label">GitHub</label>
						<div class="col-md-8 col-lg-9">
							<input name="github" type="text" class="form-control profiling16" id="github"  placeholder="Example: https://"  value="<?= $profiling['github'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<h3>Certification Profile</h3>
					</div>

					<div class="row mb-3">
						<label for="nama_keahlian" class="col-md-4 col-lg-3 col-form-label">Skill Name</label>
						<div class="col-md-8 col-lg-9">
							<input name="nama_keahlian" type="text" class="form-control profiling17" id="nama_keahlian" placeholder="Example: Programmer"  value="<?= $profiling['nama_keahlian'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="sumber_keahlian" class="col-md-4 col-lg-3 col-form-label">Source of Expertise</label>
						<div class="col-md-8 col-lg-9">
							<input name="sumber_keahlian" type="text" class="form-control profiling18" id="sumber_keahlian" placeholder="Example: BNSP"  value="<?= $profiling['sumber_keahlian'] ?>">
						</div>
					</div>

					<div class="row mb-3">
						<label for="sertifikasi" class="col-md-4 col-lg-3 col-form-label">Certification</label>
						<div class="col-md-8 col-lg-9">
							<input name="sertifikasi" type="text" class="form-control profiling19" id="sertifikasi" placeholder="Example: Programmer"  value="<?= $profiling['sertifikasi'] ?>">
						</div>
					</div>

				</form>

                <div class="text-center">
                    <button type="button" onclick="editProfiling()" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getData();
            getwilayah();
        });
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
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
                'profilePendampingHub':userData.pendamping_hubungan
            };
            document.getElementById('Birthdate').value = userData.tgl_lhr

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
            userData['role'] = storedUserData.role
            userData['username'] = storedUserData.username
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

		function editProfiling() {
            const form = document.getElementById('editProfiling');
            const formData = new FormData(form);
            const userData = {};
            formData.forEach((value, key) => {
                userData[key] = value;
            });
            userData['user_id'] = userId;

            console.log(userData)
            axios.post(apiUrl + `/detail-profile/create`, userData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('User updated successfully.');
                        window.location.href = "{{ url('profiling-edit?status=1') }}"
                    } else {
                        console.error('Updating user failed:', data.message);
						window.location.href = "{{ url('profiling-edit?failed=1') }}"
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getwilayah() {
            const provinceData = url + '/assets/js/provinces.json'
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
            const kabData = url + '/assets/js/kabupatens.json'
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
            const kecamatanData = url + '/assets/js/kecamatans.json'
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
            const kelurahanData = url + `/assets/js/output_${kecId}.json`
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
    </script>
@endsection
