@extends('layouts.user.base')

@section('title', 'Kelola Kuisioner')

@section('content')
    <div class="pagetitle">
        <h1>Kelola Kuisioner Kualitas Hidup</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item">Kuisioner</li>
                <li class="breadcrumb-item active">Kualitas Hidup</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end my-3">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#kuisionerModal">
                        Tambah Pertanyaan
                    </button>
                </div>
                @include('component.admin.kuisioner_add_modal')

                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Pertanyaan Kuisioner</h5>


                        <!-- Table with stripped rows -->
                        <table class="table" id="kuisionerDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Kuisioner</th>
                                    <th scope="col">Pertanyaan</th>
                                    <th scope="col">Pilihan Jawaban</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">No Urut</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        @include('component.admin.kuisioner_edit_modal')
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
                        <p>Anda yakin akan menghapus kuisioner?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger" onclick="deleteKuisioner()">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getData();
        });
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const accessToken = '{{session('token')}}';

        let itemToDelete = ''
        let itemToEdit = ''

        function getData() {
            axios.get(apiUrl + 'kualitashidup', {
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

        function updateTable(data) {
            const tableBody = document.querySelector('.table tbody');
            tableBody.innerHTML = '';


            data.forEach((d, index) => {
                let jsonString = d.pilihan_jawaban.replace(/'/g, '"');
                console.log(d.pilihan_jawaban)
                console.log(jsonString)
                jsonString = JSON.parse(jsonString);

                const pilihanJawabanList = Object.entries(jsonString[0]).map(([label, value]) => {
                    return `${value}: ${label} </br>`;
                }).join('');
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${d.kuesioner}</td>
                    <td style='width:40%'>${d.pertanyaan_}</td>
                    <td> ${pilihanJawabanList}</td>
                    <td>${d.status}</td>
                    <td>${d.no_urut}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="getKuisionerById('${d.id}')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteKuisionerConfirmation('${d.id}')">Hapus</button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
            const dataTable = new simpleDatatables.DataTable('#kuisionerDataTable');
        }

        function displayEditKuisionerModal(kuisionerData) {
            const editKuisionerModal = new bootstrap.Modal(document.getElementById('editKuisionerModal'));
            // console.log(kuisionerData)
            populateEditForm(kuisionerData);
            editKuisionerModal.show();
        }

        function populateEditForm(data) {
            itemToEdit = data.id
            document.getElementById('editKuisionerPertanyaan').value = data.pertanyaan_;
            document.getElementById('editKuisionerStatus').value = data.status;
            document.getElementById('editKuisionerNoUrut').value = data.no_urut;

            let jsonString = data.pilihan_jawaban.replace(/'/g, '"');
            jsonString = JSON.parse(jsonString);

            const pilihanJawabanList = Object.entries(jsonString[0]).map(([label, value]) => {
                return `${label}`;
            })

            const choiceList = document.getElementById('editChoiceList');
            pilihanJawabanList.forEach(item => {
                const listItem = document.createElement('div');
                listItem.classList.add('input-group', 'mb-3');
                const inputField = document.createElement('input');
                inputField.classList.add('form-control');
                // inputField.setAttribute('readonly', 'true');
                inputField.value = item;

                const appendButton = document.createElement('button');
                appendButton.classList.add('btn', 'btn-outline-secondary');
                appendButton.type = 'button';
                appendButton.innerHTML = '<i class="bi bi-trash"></i>';

                appendButton.addEventListener('click', () => {
                    choiceList.removeChild(listItem);
                });

                listItem.appendChild(inputField);
                listItem.appendChild(appendButton);
                choiceList.appendChild(listItem);
            })
        }

        function getKuisionerById(id) {
            axios.get(apiUrl + `kualitashidup/${id}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        displayEditKuisionerModal(data.data[0]);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function editKuisioner() {
            const form = document.getElementById('editKuisionerForm');
            const formData = new FormData(form);
            const kuisionerData = {};
            formData.forEach((value, key) => {
                kuisionerData[key] = value;
            });
            const choiceListItems = document.getElementById('editChoiceList').getElementsByTagName('div');

            let mergedChoices = {};

            for (let i = 0; i < choiceListItems.length; i++) {
                const inputField = choiceListItems[i].getElementsByTagName('input')[0];
                mergedChoices[inputField.value] = i + 1;
            }

            kuisionerData.pilihan_jawaban = JSON.stringify([mergedChoices]).replace(/"/g, "'");;
            kuisionerData.kuesioner = "Kualitas Hidup"
            kuisionerData.id = itemToEdit
            // console.log(kuisionerData)


            axios.put(apiUrl + `kuesionerpertanyaan/update`, kuisionerData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('data updated successfully.');
                        const choiceList = document.getElementById('editChoiceList');
                        choiceList.innerHTML = ''
                        var myModalEl = document.getElementById('editKuisionerModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Updating data failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function manageChoice(isAdd, value, choiceListId) {
            const choiceList = document.getElementById(choiceListId);
            const listItem = document.createElement('div');
            listItem.classList.add('input-group', 'mb-3');
            const inputField = document.createElement('input');
            inputField.classList.add('form-control');
            inputField.value = value;

            const appendButton = document.createElement('button');
            appendButton.classList.add('btn', 'btn-outline-secondary');
            appendButton.type = 'button';
            appendButton.innerHTML = '<i class="bi bi-trash"></i>';

            appendButton.addEventListener('click', () => {
                choiceList.removeChild(listItem);
            });

            listItem.appendChild(inputField);
            listItem.appendChild(appendButton);

            if (isAdd) {
                choiceList.appendChild(listItem);
            } else {
                choiceList.removeChild(listItem);
            }
        }

        document.getElementById('addChoice').addEventListener('click', () => {
            const choiceInput = document.getElementById('choice');
            const choiceValue = choiceInput.value;
            const choiceListId = 'choiceList'
            if (choiceValue) {
                manageChoice(true, choiceValue, choiceListId);
                choiceInput.value = '';
            }
        });

        document.getElementById('addChoiceEdit').addEventListener('click', () => {
            const choiceInput = document.getElementById('choiceEdit');
            const choiceValue = choiceInput.value;
            const choiceListId = 'editChoiceList'
            if (choiceValue) {
                manageChoice(true, choiceValue, choiceListId);
                choiceInput.value = '';
            }
        });

        function addKuisioner() {
            const form = document.getElementById('addKuisionerForm');
            const formData = new FormData(form);
            const kuisionerData = {};
            formData.forEach((value, key) => {
                kuisionerData[key] = value;
            });

            const choiceListItems = document.getElementById('choiceList').getElementsByTagName('div');

            let mergedChoices = {};

            for (let i = 0; i < choiceListItems.length; i++) {
                const inputField = choiceListItems[i].getElementsByTagName('input')[0];
                mergedChoices[inputField.value] = i + 1;
            }

            kuisionerData.pilihan_jawaban = JSON.stringify([mergedChoices]).replace(/"/g, "'");;
            kuisionerData.kuesioner = "Kualitas Hidup"
            console.log(kuisionerData);

            axios.post(apiUrl + 'kuesionerpertanyaan/create', kuisionerData, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log('data added successfully.');
                        form.reset();
                        const choiceList = document.getElementById('choiceList');
                        choiceList.innerHTML = ''
                        var myModalEl = document.getElementById('kuisionerModal');
                        var modal = bootstrap.Modal.getInstance(myModalEl)
                        modal.hide();
                        getData();
                    } else {
                        console.error('Adding data failed:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }


        function deleteKuisionerConfirmation(item) {
            itemToDelete = item
            const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
            deleteConfirmationModal.show();
        }

        function deleteKuisioner() {
            const id = itemToDelete;
            axios.delete(apiUrl + 'kuesionerpertanyaan/delete', {
                    data: {
                        id: itemToDelete
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
                        getData()

                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }
    </script>

@endsection
