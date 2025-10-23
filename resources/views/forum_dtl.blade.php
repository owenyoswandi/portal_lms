@extends('layouts.user.base')

@section('title', 'Konsultasi Detail')

@section('content')
    <div class="pagetitle mb-3">
        <a href="{{ route('konsultasi') }}" class="btn btn-primary mb-3">Kembali</a>
        <h5>{{ $judul['fr_subject'] }}</h5>
        <h1>{{ $judul['fr_pertanyaan'] }}</h1>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            @foreach ($data as $item)
                <div class="col-md-12 d-flex flex-column mt-3 gap-4">
                    <div class="d-flex flex-column gap-4">
                        @if ($item['frd_user_id'] == session('id'))
                            <div class="d-flex flex-row-reverse gap-2">
                            @else
                                <div class="d-flex gap-2">
                        @endif
                        @if ($item['role'] == 'Dokter')
                            <div class="avatar">
                                <i class="bi bi-person-circle fs-1 text-success"></i>
                            </div>
                            <div class="bg-white rounded shadow flex-fill p-3">
                                <div class="d-flex justify-content-between text-success">
                                    <span class="fw-bold">{{ $item['username'] }}</span>
                                    <span>{{ $item['role'] }}</span>
                                </div>
                                <p>{{ $item['frd_tanggapan'] }}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <p class="my-auto" style="font-size: 12px">{{ $item['formatted_modifieddate'] }}</p>
                                    @if ($item['frd_user_id'] == session('id'))
                                        <div class="d-flex gap-2 ">
                                            <i class="bi bi-x-circle-fill text-danger my-auto" style="cursor: pointer;"
                                                onclick="deleteDataConfirmation({{ $item['frd_id'] }})"></i>
                                            <i class="bi bi-pencil-square text-success my-auto" style="cursor: pointer;"
                                                onclick="getForumById({{ $item['frd_id'] }})"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif($item['role'] == 'Pasien')
                            <div class="avatar">
                                <i class="bi bi-person-circle fs-1 text-primary"></i>
                            </div>
                            <div class="bg-white rounded shadow flex-fill p-3">
                                <div class="d-flex justify-content-between text-primary">
                                    <span class="fw-bold">{{ $item['username'] }}</span>
                                    <span>{{ $item['role'] }}</span>
                                </div>
                                <p>{{ $item['frd_tanggapan'] }}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <p class="my-auto" style="font-size: 12px">{{ $item['formatted_modifieddate'] }}</p>
                                    @if ($item['frd_user_id'] == session('id'))
                                        <div class="d-flex gap-2">
                                            <i class="bi bi-x-circle-fill text-danger my-auto" style="cursor: pointer;"
                                                onclick="deleteDataConfirmation({{ $item['frd_id'] }})"></i>
                                            <i class="bi bi-pencil-square text-success my-auto" style="cursor: pointer;"
                                                onclick="getForumById({{ $item['frd_id'] }})"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @else
                            <div class="avatar">
                                <i class="bi bi-person-circle fs-1 text-warning"></i>
                            </div>
                            <div class="bg-white rounded shadow flex-fill p-3">
                                <div class="d-flex justify-content-between text-warning">
                                    <span class="fw-bold">{{ $item['username'] }}</span>
                                    <span>{{ $item['role'] }}</span>
                                </div>
                                <p>{{ $item['frd_tanggapan'] }}
                                </p>
                                <div class="d-flex justify-content-between">
                                    <p class="my-auto" style="font-size: 12px">{{ $item['formatted_modifieddate'] }}</p>
                                    @if ($item['frd_user_id'] == session('id'))
                                        <div class="d-flex gap-2">
                                            <i class="bi bi-x-circle-fill text-danger my-auto" style="cursor: pointer;"
                                                onclick="deleteDataConfirmation({{ $item['frd_id'] }})"></i>
                                            <i class="bi bi-pencil-square text-success my-auto" style="cursor: pointer;"
                                                onclick="getForumById({{ $item['frd_id'] }})"></i>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        @endif

                    </div>
                </div>
            @endforeach

            <div class="bg-white rounded p-3">
                <form id="kosultasi_detail">
                    <textarea class="form-control" name="frd_tanggapan" placeholder="Masukkan pesan!" id="kuisionerPertanyaan"
                        style="height: 100px;"></textarea>
                    <div class="d-flex justify-content-end mt-3">
                        <a type="button" class="btn btn-primary" onclick="addQuestion()">
                            Kirim
                        </a>
                    </div>
                </form>

            </div>
        </div>
        </div>
        @include('component.forum.forum-question-edit-detail')
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
        const apiUrl = '{{ config('app.api_url') }}';
        const accessToken = '{{session('token')}}';
        const userId = storedUserData.id
        let idToDelete = ''
        let idToEdit = ''
        const tanggalForum = new Date()
        const formattedDateForum = new Date(tanggalForum.setHours(tanggalForum.getHours() + 7))

        const pathname = location.pathname;
        const number = pathname.split('/').pop();

        function addQuestion() {
            const form = document.getElementById('kosultasi_detail');
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            data['frd_fr_id'] = number
            data['frd_user_id'] = userId
            data['frd_createdby'] = userId
            data['frd_modifiedby'] = userId
            data['frd_createddate'] = formattedDateForum
            data['frd_modifieddate'] = formattedDateForum
            console.log(data)
            axios.post(apiUrl + 'konsultasi-detail/create', data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const result = response.data;
                    if (result.success) {
                        console.log('data added successfully.');
                        let text =
                            `Pesan baru untuk {{ $judul['fr_subject'] }} : {{ $judul['fr_pertanyaan'] }} silahkan klik link <a href={{ url('konsultasi-dtl') }}/${number}>ini</a>`
                        postNotif(text)
                        form.reset();
                    } else {
                        console.error('Adding data failed:', result.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function postNotif(text) {
            const data = {}
            var notUserId = @json($judul['fr_createdby']);
            data['not_userid'] = notUserId
            data['not_deskripsi'] = text
            data['not_statusbaca'] = 0
            data['not_created'] = formattedDateForum
            data['not_modified'] = null

            axios.post(apiUrl + 'notifikasi/create', data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const result = response.data;
                    if (result.success) {
                        console.log('Notification added successfully');
                        window.location.reload();
                    } else {
                        console.error('Adding notification failed', 'Error:',
                            result.message);
                    }
                })
                .catch(error => {
                    console.error('Error sending notification for doctor ID:', 'Error:', error);
                });
        }

        function deleteDataConfirmation(data) {
            idToDelete = data;
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteData() {
            axios.delete(apiUrl + 'konsultasi-detail/delete', {
                    data: {
                        frd_id: idToDelete
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
            const editUserModal = new bootstrap.Modal(document.getElementById('forumDetailEditModal'));
            populateEditForm(data);
            editUserModal.show();
        }

        function getForumById(id) {
            axios.get(apiUrl + `konsultasi-detail/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        idToEdit = data.data[0].frd_id
                        userIdForum = data.data[0].frd_user_id
                        createdByForum = data.data[0].frd_createdby
                        createdDateForum = data.data[0].frd_createddate
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
            document.getElementById('frd_tanggapan').value = data.frd_tanggapan;

        }

        function editDtlForum() {
            const form = document.getElementById('editPertanyaanForm');
            const formData = new FormData(form);
            const data = {};
            formData.forEach((value, key) => {
                data[key] = value;
            });
            data['frd_id'] = idToEdit
            data['frd_fr_id'] = number
            data['frd_user_id'] = userIdForum
            data['frd_createdby'] = createdByForum
            data['frd_modifiedby'] = userId
            data['frd_createddate'] = createdDateForum
            data['frd_modifieddate'] = new Date()

            axios.put(apiUrl + `konsultasi-detail/update`, data, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('data updated successfully.');
                        var myModalEl = document.getElementById('forumDetailEditModal');
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

        // function postNotif() {
        //     const data = {}
        //     data['userid'] = userId
        //     no
        //     axios.post(apiUrl + 'notifikasi/create', data, {
        //             headers: {
        //                 'Authorization': `Bearer ${accessToken}`
        //             }
        //         })
        //         .then(response => {
        //             const result = response.data;
        //             if (result.success) {
        //                 console.log('data added successfully.');
        //                 form.reset();
        //                 var myModalEl = document.getElementById('forumAddModal');
        //                 var modal = bootstrap.Modal.getInstance(myModalEl)
        //                 modal.hide();
        //                 window.location.reload();
        //             } else {
        //                 console.error('Adding user failed:', result.message);
        //             }
        //         })
        //         .catch(error => {
        //             console.error('Error:', error);
        //         });
        // }
    </script>
@endsection
