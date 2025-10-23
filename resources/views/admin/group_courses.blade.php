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
                <li class="breadcrumb-item active" id="group_title">Manage Group Courses</li>
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
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title" id="group_title2"></h5>
                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body" style="overflow-x:auto">
                        <h5 class="card-title">Courses</h5>
                        <!-- Table with stripped rows -->
                        <table class="table" id="userDataTable2">
                            <thead>
                                <tr>
                                    <th scope="col">Course</th>
                                    <th scope="col">Description</th>
                                    <th><input type="checkbox" id="select-all"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <button id="download-selected" class="btn btn-primary" onclick="addCourse()" disabled>Add Selected Courses</button> <!-- Tombol Download -->
                        
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
                        <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Hidden input to store group ID -->
                        <input type="hidden" id="courseIdToDelete">
                        <p>Are you sure to delete this data "<span id="coursenameToDelete"></span>"?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteCourse()">Delete</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
        getCourses(groupId);

        $('#select-all').on('click', function() {
            var isChecked = $(this).prop('checked');
            if (isChecked) {
                // Select all rows on all pages
                dataTable.rows().every(function() {
                    var row = this.node();
                    var checkbox = $(row).find('.select-participant');
                    checkbox.prop('checked', true);
                    $(row).addClass('selected-row');
                });
            } else {
                // Deselect all rows on all pages
                dataTable.rows().every(function() {
                    var row = this.node();
                    var checkbox = $(row).find('.select-participant');
                    checkbox.prop('checked', false);
                    $(row).removeClass('selected-row');
                });
            }
            updateSelectedCourses();
        });

        $('#userDataTable2 tbody').on('change', '.select-participant', function() {
            updateSelectedCourses();
            var allChecked = $('.select-participant:checked').length === $('.select-participant').length;
            $('#select-all').prop('checked', allChecked);  
        });
    });

    function initializeDataTable() {
        if (!dataTable) {
            dataTable = $('#userDataTable2').DataTable({
                "pagingType": "simple_numbers",
                "responsive": true,
                columns: [
                    { orderable: true },
                    { orderable: true },
                    { orderable: false }
                ]
            });
        }
    }

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
        document.getElementById('group_title1').innerHTML = group.group_name + " Courses";
        document.getElementById('group_title2').innerHTML = group.group_name + " Courses";
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
        axios.get(apiUrl + '/group_access-byid/' + id, {
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

        Data.forEach((d, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${index + 1}</td>
            <td>${d.p_judul}</td>
            <td>${d.p_deskripsi}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="deleteCourseConfirmation('${d.p_id}', '${d.p_judul}')">Delete</button>
            </td>`;
            questiontableBody.appendChild(row);
        });
        const table = new simpleDatatables.DataTable('#userDataTable');
    }

    function getCourses(id) {
        axios.get(apiUrl + `/group_access_courses-byid/${id}`, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    updateTableCourses(data.data);
                } else {
                    console.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    function updateTableCourses(Data) {
        const tableBody = document.querySelector('#userDataTable2 tbody');
        tableBody.innerHTML = '';

        Data.forEach((d, index) => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${d.p_judul}</td>
            <td>${d.p_deskripsi}</td>
            <td><input type="checkbox" class="select-participant" data-product-id="${d.p_id}"></td>
        `;
            tableBody.appendChild(row);
        });

        if (!dataTable) {
        initializeDataTable();  // Initialize only if DataTable is not already initialized
        } else {
            dataTable.clear().rows.add($(tableBody).find('tr')).draw(); // Add the rows and redraw the table
        }
        updateDownloadButtonState();
    }

    function updateDownloadButtonState() {
        const downloadButton = $('#download-selected');
        downloadButton.prop('disabled', selectedCourses.length === 0);
    }

    // Function to update the selectedCourses array
    function updateSelectedCourses() {
        selectedCourses = [];

        dataTable.rows().every(function() {
            var row = this.node();
            var checkbox = $(row).find('.select-participant');
            var productId = checkbox.data('product-id'); // Get the product-id data attribute

            // Only include rows with a valid product-id and if they are checked
            if (checkbox.prop('checked') && productId != null && productId !== undefined) {
                selectedCourses.push(productId);
            }
        });
        updateDownloadButtonState();
    }

    function addCourse() {
        if (selectedCourses.length > 0) {
            const formData = new FormData();
            formData.append("productIds", JSON.stringify(selectedCourses));  // Ensure to stringify array
            formData.append("group_id", groupId);  // Ensure to stringify array
            
            axios.post(apiUrl + '/group_access/create', formData, {
                headers: {
                    'Authorization': `Bearer ${accessToken}`,
                    'Content-Type': 'multipart/form-data'
                }
            })
            .then(response => {
                const data = response.data;
                if (data.success) {
                    selectedCourses = [];
                    getData(groupId);
                    getCourses(groupId);
                } else {
                    console.error('Adding group failed:', data.message);
                }
            })
            .catch(error => {
                if (error.response && error.response.data) {
                    const errors = error.response.data;
                    console.error('Validation errors:', errors);
                } else {
                    console.error('Error:', error);
                }
            });
        } else {
            alert('No questions selected.');
        }
    }

    function deleteCourseConfirmation(Id, Name) {
        document.getElementById('courseIdToDelete').value = Id;
        document.getElementById('coursenameToDelete').textContent = Name;
        const deleteConfirmationModal = new bootstrap.Modal(document.getElementById('deleteConfirmationModal'));
        deleteConfirmationModal.show();
    }

    function deleteCourse() {
        const Id = document.getElementById('courseIdToDelete').value;

        axios.delete(apiUrl + '/group_access/delete', {
            data: {
                group_id: groupId,
                product_id: Id,
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
                getData(groupId);
                getCourses(groupId);
            } else {
                console.error(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>