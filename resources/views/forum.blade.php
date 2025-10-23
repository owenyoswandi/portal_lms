@extends('layouts.user.base')

@section('title', 'Konsultasi')

@section('content')
    <div class="pagetitle">
        <h1>Konsultasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Konsultasi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-md-12">
                @if(session('role')=='Pasien')
                <div class="d-flex justify-content-end my-3">
                    <a type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#forumAddModal">
                        Tambah Pertanyaan
                    </a>
                </div>
                @endif
                @include('component.forum.forum-question-add')
                @foreach ($data as $item)
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ url('konsultasi-dtl/' . $item['fr_id']) }}"
                                    class="text-reset text-decoration-none">
                                    <h5 class="card-title">{{ $item['fr_subject'] }}</h5>
                                </a>
                                @if (session('id') == $item['fr_createdby'])
                                    <div class="d-flex gap-2">
                                        <i class="bi bi-x-circle-fill text-danger my-auto" style="cursor: pointer;"
                                            onclick="deleteDataConfirmation({{ $item['fr_id'] }})"></i>
                                        <i class="bi bi-pencil-square text-success my-auto" style="cursor: pointer;"
                                            onclick="getForumById({{ $item['fr_id'] }})"></i>
                                    </div>
                                @endif
                            </div>
                            <p class="text-decoration-none">{{ $item['fr_pertanyaan'] }}</p>
                            <div class="d-flex justify-content-end">
                                {{-- <div class="d-flex gap-2 my-auto">
                                    <i class="bi bi-chat-left-dots"></i>
                                    <span class="text-gray" style="font-size: 12px">3</span>
                                </div> --}}
                                <div class="d-flex flex-column gap-2 my-auto">
                                    <span class="text-gray" style="font-size: 12px">Terakhir update oleh :
                                        {{ $item['username'] }}</span>
                                    <span class="text-gray text-decoration-none" style="font-size: 12px">Terakhir update:
                                        {{ $item['formatted_modifieddate'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @include('component.forum.forum-question-edit')
        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Data</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <p>Anda yakin akan menghapus pertanyaan forum?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteData()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getDokterPerawat();
        });
        const apiUrl = '{{ config('app.api_url') }}';
        const accessToken = '{{session('token')}}';
        const userId = storedUserData.id
        const role = storedUserData.role
        let dokters = []
        let dokterIds = ''
        let idToDelete = ''
        let idToEdit = ''
        let userIdForum = ''
        let createdByForum = ''
        let createdDateForum = ''

        function addSubjectKonsultasi() {
            const tanggal = new Date()
            const formattedDate = new Date(tanggal.setHours(tanggal.getHours()+7))
            const form = document.getElementById('addPertanyaanForm');
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            data['fr_user_id'] = userId
            data['fr_createdby'] = userId
            data['fr_modifiedby'] = userId
            data['fr_createddate'] = formattedDate
            data['fr_modifieddate'] = formattedDate
            console.log(data)
            axios.post(apiUrl + 'konsultasi/create', data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const result = response.data;
                    if (result.success) {
                        console.log('data added successfully.');
                        form.reset();
                        let text = ''
                        text =
                            `${data['fr_subject']} : ${data['fr_pertanyaan']} telah dibuat oleh ${role} silahkan klik link <a href={{ url('konsultasi-dtl') }}/${result.data.id}>ini</a>`
                        notifyDoktersAndReload(text, dokterIds)
                    } else {
                        console.error('Adding user failed:', result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getDokterPerawat() {
            axios.get(apiUrl + 'user', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const result = response.data;
                    if (result.success) {
                        dokters = result.data.filter(user => user.rumah_sakit === '{{ session('rumah_sakit') }}') 
                        dokters = dokters.filter(user => user.role === 'Dokter' || user.role === 'Per-clinic' ||
                            user.role === 'Per-home').map(dokter => ({
                            id: dokter.user_id,
                            name: dokter.nama
                        }));
                        dokterIds = dokters.map(dokter => dokter.id);
                        console.log(dokters)
                    } else {
                        console.error('Adding user failed:', result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function postNotifToDokters(text, doctorIds) {
            console.log(doctorIds)
            const tanggal = new Date()
            const formattedDate = new Date(tanggal.setHours(tanggal.getHours() + 7))
            const notificationPromises = doctorIds.map(doctorId => {
                const data = {
                    not_userid: doctorId,
                    not_deskripsi: text,
                    not_statusbaca: 0,
                    not_created: formattedDate,
                    not_modified: null
                };

                return axios.post(apiUrl + 'notifikasi/create', data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                });
            });
            return notificationPromises;
        }

        function notifyDoktersAndReload(text, doctorIds) {
            const notificationPromises = postNotifToDokters(text, doctorIds);

            Promise.all(notificationPromises)
                .then(results => {
                    console.log('All notifications completed successfully:', results);
                    var myModalEl = document.getElementById('forumAddModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                    window.location.reload();
                })
                .catch(error => {
                    console.error('Error notifying dokters:', error);
                });
        }

        function deleteDataConfirmation(data) {
            idToDelete = data;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteData() {
            axios.delete(apiUrl + 'konsultasi/delete', {
                    data: {
                        fr_id: idToDelete
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
                        window.location.reload();
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function displayEditUserModal(data) {
            const editUserModal = new bootstrap.Modal(document.getElementById('forumEditModal'));
            populateEditForm(data);
            editUserModal.show();
        }

        function getForumById(id) {
            axios.get(apiUrl + `konsultasi/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        idToEdit = data.data[0].fr_id
                        userIdForum = data.data[0].fr_user_id
                        createdByForum = data.data[0].fr_createdby
                        createdDateForum = data.data[0].fr_createddate
                        displayEditUserModal(data.data[0]);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function populateEditForm(data) {
            const element = document.getElementById('forumSubjekEdit')
            setSelectOption(element, data.fr_subject)
            document.getElementById('forumPertanyaanEdit').value = data.fr_pertanyaan;

        }

        function setSelectOption(selectElement, value) {
            const options = selectElement.options;
            for (let i = 0; i < options.length; i++) {
                if (options[i].value == value) {
                    options[i].selected = true;
                    break;
                }
            }
        }

        function editForum() {
            const tanggal = new Date()
            const formattedDate = new Date(tanggal.setHours(tanggal.getHours()+7))
            const form = document.getElementById('editPertanyaanForm');
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            data['fr_id'] = idToEdit
            data['fr_user_id'] = userIdForum
            data['fr_createdby'] = createdByForum
            data['fr_modifiedby'] = userId
            data['fr_createddate'] = createdDateForum
            data['fr_modifieddate'] = formattedDate

            axios.put(apiUrl + `konsultasi/update`, data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('data updated successfully.');
                        var myModalEl = document.getElementById('forumEditModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        window.location.reload();
                    } else {
                        console.error('Updating data failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endsection
