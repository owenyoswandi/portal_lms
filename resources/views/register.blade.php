@extends('layouts.login.base')

@section('title', 'Register')

@section('content')
    <div class="pt-4 pb-2">
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
        <p class="text-center small">Enter your personal details to create account</p>
    </div>

    <form class="row g-3 needs-validation" method="post" action="{{ route('register') }}" id="registerUser" novalidate>
        @csrf
        <div class="col-12">
            <label for="yourName" class="form-label">Your Name</label>
            <input type="text" name="nama" class="form-control" id="yourName" required>
            <div class="invalid-feedback">Please, enter your name!</div>
        </div>

        <div class="col-12">
            <label for="yourUsername" class="form-label">Your Username</label>
            <input type="text" name="username" class="form-control" id="yourUsername" placeholder="example: williamwals" required>
            <div class="invalid-feedback">Please enter a the username!</div>
        </div>

        <div class="col-12">
            <label for="yourEmail" class="form-label">Your Email</label>
            <input type="email" name="email" class="form-control" id="yourEmail" required>
            <div class="invalid-feedback">Please enter a the email!</div>
        </div>

        <div class="col-12">
            <label for="yourPassword" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="yourPassword" required>
            <div class="invalid-feedback">Please enter your password!</div>
        </div>

        <div class="col-md mb-4">
            <span class="fw-medium d-block">Gender</span>
            <div class="form-check form-check-inline mt-2">
                <input class="form-check-input" type="radio" name="jk" id="inlineRadio1" value="Laki-laki"
                    required />
                <label class="form-check-label" for="inlineRadio1">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="jk" id="inlineRadio2" value="Perempuan"
                    required />
                <label class="form-check-label" for="inlineRadio2">Female</label>
            </div>
        </div>

        <div class="col-12">
            <label for="html5-date-input" class="form-label">Date f Birth</label>
            <input class="form-control" type="date" name="tgl_lhr" id="html5-date-input" required />
        </div>

        <div class="col-12">
            <label for="yourPhone" class="form-label">Phone</label>
            <input class="form-control" type="text" name="no_hp" id="yourPhone" required />
        </div>

        <div class="col-12">
            <label for="exampleFormControlSelect1" class="form-label">Role</label>
            <select class="form-select" id="exampleFormControlSelect1" name="role" aria-label="Default select example"
                required>
                <option value="Peserta">Member</option>
            </select>

        </div>

        <div class="col-12 mb-3">
            <label for="floatingTextarea" class="form-label">Address (Alamat di KTP)</label>
            <textarea class="form-control" name="alamat" id="floatingTextarea" style="height: 100px;" required></textarea>
        </div>

        <div class="row mb-3">
            <label for="Provinsi" class="form-label">Province (Provinsi)</label>
            <div class="col-md-12">
                <select class="form-select profileProvinsi" name="provinsi" id="provinsi"
                    aria-label="Pilih salah satu">
                </select>
            </div>

        </div>

        <div class="row mb-3">
            <label for="kabupaten" class="form-label">City (Kota/Kab.)</label>
            <div class="col-md-12">
                <select class="form-select profileKab" name="kota_kab" id="kabupaten"
                    aria-label="Pilih salah satu">
                </select>
            </div>

        </div>

        <div class="row mb-3">
            <label for="kecamatan" class="form-label">Subdistrict (Kecamatan)</label>
            <div class="col-md-12">
                <select class="form-select profileKecamatan" name="kecamatan" id="kecamatan"
                    aria-label="Pilih salah satu">
                </select>
            </div>
        </div>

        <div class="row mb-3">
            <label for="kelurahan" class="col-form-label">Ward (Kelurahan)</label>
            <div class="col-md-12">
                <select class="form-select profileKelurahan" name="kelurahan" id="kelurahan"
                    aria-label="Pilih salah satu">
                </select>
            </div>
        </div>

        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Create Account</button>
        </div>
        <div class="col-12">
            <p class="small mb-0">Already have an account? <a href="{{ url('/login') }}">Log in</a></p>
        </div>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getwilayah();
        });
        const url = '{{ config('app.app_url') }}'
        const regenciesDropdown = document.getElementById('kabupaten');
        const provincesDropdown = document.getElementById('provinsi');
        const kecDropdown = document.getElementById('kecamatan');
        const kelDropdown = document.getElementById('kelurahan');

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

        async function fetchKelurahan(kecId) {
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
    </script>
@endsection
