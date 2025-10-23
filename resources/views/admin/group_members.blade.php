@extends('layouts.user.base')

@section('title', 'Manage Course')

<style>
    #userDataTable2 {
        width: 100% !important; /* Sets the table width to 100% */
        table-layout: auto !important; /* Automatically adjusts the table layout */
    }
</style>

@section('content')
    <div class="pagetitle">
        <h1 id="group_title1"></h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin-group') }}">Manage Group</a></li>
                <li class="breadcrumb-item active" id="group_title">Manage Group Members</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Detail</h5>
                        <div id="group_container" style="width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
				
                <div class="card">
					
                    <div class="card-body" style="overflow-x:auto">
						<br>
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#selectUserModal">
							Assign User
						</button>
						<br>
					
                        <h5 class="card-title" id="group_title2"></h5>
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
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
	
		<!-- Select User -->
        <div class="modal fade" id="selectUserModal" tabindex="-1" aria-labelledby="selectUserModal"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectUserModal">Pilih User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" id="assignForm" novalidate>
							<label for="userdata">Pilih Nama Pegguna:</label><br>
							<select id="userdata" name="userdata[]" multiple size="5" required>
								<?php
									foreach($datauser as $ou) {
								?>
									<option value="<?= $ou->user_id ?>"><?= $ou->nama ?></option>
								<?php
									}
								?>
							</select>
						</form>

						
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" onclick="assignUser()">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
@endsection

<script>
    const apiUrl = '{{ config('app.api_url') }}';
    const url = '{{ config('app.app_url') }}'
    const accessToken = '{{ session('token') }}';

    const groupId = @json($group_id); 

    let dataTable;
    let selectedCourses = [];

    document.addEventListener("DOMContentLoaded", () => {
        getGroupById(groupId);
        getData(groupId);
    });

    function getGroupById(id) {
        axios.get(apiUrl + `/group/${id}`, {
            headers: {
                'Authorization': `Bearer ${accessToken}`
            }
        })
        .then(response => {
            const data = response.data;
            console.log(data)
            if (data.success) {
                displayGroups(data.data);
            } else {
                console.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }

    function displayGroups(group) {
        document.getElementById('group_title').innerHTML = group.group_name;
        document.getElementById('group_title1').innerHTML = "Peserta " + group.group_name;
        document.getElementById('group_title2').innerHTML = "Peserta " + group.group_name;
        const container = document.getElementById('group_container');
        const body = document.createElement('div');

        body.innerHTML += `<div style="width: 100%;">
            <div class="col-lg-12">
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Group Name</td>
                        <td>${group.group_name}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>${group.group_email}</td>
                    </tr>
                    <tr>
                        <td>Phone Number</td>
                        <td>${group.group_phone}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>${group.group_alamat}</td>
                    </tr>
                </tbody>
        </table></div>`;

        container.appendChild(body);
    }

    function getData(id) {
        axios.get(apiUrl + '/group_member-byid/' + id, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    updateTable(data.data);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateTable(Data) {
        const questiontableBody = document.querySelector('#userDataTable tbody');
        questiontableBody.innerHTML = '';

        Data.forEach((user, index) => {
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
            <td>${user.role}</td>`;
            questiontableBody.appendChild(row);
        });
        const table = new simpleDatatables.DataTable('#userDataTable');
    }
	
	function assignUser() {
		const form = document.getElementById('assignForm');
		const formData = new FormData(form);

		// Ambil semua nilai dari select multiple name="userdata[]"
		const userIds = formData.getAll('userdata[]'); // hasil array, contoh: [1,2,3]

		console.log("data assign:", userIds);

		axios.get(url + `admin-group/member/${groupId}`, {
			params: {
				datauserid: userIds.join(',') // Kirim sebagai "1,2,3"
			}
		})
		.then(res => console.log(res.data))
		.catch(err => console.error(err));
		
		$('#selectUserModal').modal('hide');
		getData(groupId);

	}
</script>