@extends('layouts.user.base')

@section('title', 'Kelola Pengguna')

@section('content')
    <div class="pagetitle">
        <h1>Kelola Pengguna</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Kelola Pengguna</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Tambah User
                    </button>
                </div>
                @include('component.admin.user_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Pengguna</h5>


                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Username</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">No Hp</th>
                                    <th scope="col">Jenis Kelamin</th>
                                    <th scope="col">Tanggal Lahir</th>
                                    <th scope="col">Role</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.user_edit_modal')
                    </div>
                </div>

            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin akan menghapus user <span id="usernameToDelete"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteUser()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getUserData();
            getwilayah(provinces, regencies, kec, kel);
        });
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const url    = "{{ rtrim(url('/'), '/') }}";
        const accessToken = '{{session('token')}}';
        const regencies = document.getElementById('kabupaten');
        const provinces = document.getElementById('provinsi');
        const kec = document.getElementById('kecamatan');
        const kel = document.getElementById('kelurahan');
        const regenciesDropdownEdit = document.getElementById('kabupatenedit');
        const provincesDropdownEdit = document.getElementById('provinsiedit');
        const kecDropdownEdit = document.getElementById('kecamatanedit');
        const kelDropdownEdit = document.getElementById('kelurahanedit');

        function getUserData() {
            axios.get(apiUrl + '/user', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data)
                        updateTable(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateTable(userData) {
            const tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = '';

            userData.forEach((user, index) => {
				// Mengonversi tanggal dan memformat menjadi dd-MM-yyyy
				const date = new Date(user.tgl_lhr);
				const formattedDate = date.getDate().toString().padStart(2, '0') + '-' + (date.getMonth() + 1).toString().padStart(2, '0') + '-' + date.getFullYear();

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${user.username}</td>
                    <td>${user.nama}</td>
                    <td>${user.email}</td>
                    <td>${user.no_hp}</td>
                    <td>${user.jk}</td>
                    <td>${formattedDate}</td>
                    <td>${user.role}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="getUserById('${user.username}')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteUserConfirmation('${user.username}')">Hapus</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#userDataTable');
        }

        function displayEditUserModal(userData) {
            const editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
            populateEditForm(userData);
            editUserModal.show();
        }

        async function populateEditForm(userData) {
            console.log(userData)
            await fetchRegencies(userData.provinsi, regenciesDropdownEdit);
            await fetchKecamatan(userData.kota_kab, kecDropdownEdit);
            await fetchKelurahan(userData.kecamatan, kelDropdownEdit)
            setSelectOption(document.getElementById('kabupatenedit'), userData.kota_kab);
            setSelectOption(document.getElementById('kecamatanedit'), userData.kecamatan);
            setSelectOption(document.getElementById('kelurahanedit'), userData.kelurahan);
            setSelectOption(document.getElementById('provinsiedit'), userData.provinsi);
            document.getElementById('editUserName').value = userData.nama;
            document.getElementById('editUserUsername').value = userData.username;
            document.getElementById('editUserEmail').value = userData.email;
            document.getElementById('editUserPassword').value = userData.password;
            document.getElementById('editUserPhone').value = userData.no_hp;

            const genderRadioButtons = document.getElementsByName('jk');
            for (const radioButton of genderRadioButtons) {
                if (radioButton.value === userData.jk) {
                    radioButton.checked = true;
                } else {
                    radioButton.checked = false;
                }
            }

            document.getElementById('editUserDateOfBirth').value = userData.tgl_lhr;

            document.getElementById('editUserRole').value = userData.role;
            document.getElementById('editUserRumahSakit').value = userData.rumah_sakit;
            document.getElementById('editUserAddress').value = userData.alamat;
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

        function getUserById(userId) {
            axios.get(apiUrl + `/user/${userId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {


                        getwilayah(provincesDropdownEdit, regenciesDropdownEdit, kecDropdownEdit, kelDropdownEdit)
                        displayEditUserModal(data.data[0]);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function editUser() {
            const form = document.getElementById('editUserForm');
            const formData = new FormData(form);
            const userData = {};
            formData.forEach((value, key) => {
                userData[key] = value;
            });
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
                        var myModalEl = document.getElementById('editUserModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getUserData();
                    } else {
                        console.error('Updating user failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function addUser() {
            const form = document.getElementById('addUserForm');
            const formData = new FormData(form);
            const userData = {};
            formData.forEach((value, key) => {
                userData[key] = value;
            });

            axios.post(apiUrl + '/user/create', userData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('User added successfully.');
                        form.reset();
                        var myModalEl = document.getElementById('exampleModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getUserData();
                    } else {
                        console.error('Adding user failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function deleteUserConfirmation(username) {
            document.getElementById('usernameToDelete').innerText = username;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteUser() {
            const username = document.getElementById('usernameToDelete').innerText;
            axios.delete(apiUrl + '/user/delete', {
                    data: {
                        username: username
                    },
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        var myModalEl = document.getElementById('deleteConfirmationModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getUserData()

                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        function getwilayah(provincesDropdown, regenciesDropdown, kecDropdown, kelDropdown) {
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
                    fetchRegencies(selectedProvinceId, regenciesDropdown);
                } else {
                    regenciesDropdown.innerHTML = '<option value="">Select Regency</option>';
                }
            });

            regenciesDropdown.addEventListener('change', function() {
                const selectedRegencyId = this.value;
                if (selectedRegencyId) {
                    fetchKecamatan(selectedRegencyId, kecDropdown);
                } else {
                    kecDropdown.innerHTML = '<option value="">Select Kecamatan</option>';
                }
            });
            kecDropdown.addEventListener('change', function() {
                const selectedRegencyId = this.value;
                if (selectedRegencyId) {
                    fetchKelurahan(selectedRegencyId, kelDropdown);
                } else {
                    kelDropdown.innerHTML = '<option value="">Select Kelurahan</option>';
                }
            });
        }

        async function fetchRegencies(provinceId, regenciesDropdown) {
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

        async function fetchKecamatan(kabId, kecDropdown) {
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

        async function fetchKelurahan(kecId, kelDropdown) {
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
