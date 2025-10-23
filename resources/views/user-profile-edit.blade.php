@extends('layouts.user.base')

@section('title', 'Edit Profile')

@section('content')
    <div class="pagetitle">
        <a href="{{ url('user-profile') }}" class="btn btn-primary mb-3">Kembali</a>

        <div class="alert alert-success alert-dismissible fade show d-none" role="alert" id="success-data-post">
            Data berhasil tersimpan
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <div class="alert alert-danger alert-dismissible fade show d-none" role="alert" id="error-data-post">
            Data tidak berhasil tersimpan
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <h1>Edit Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-profile') }}">Profile</a></li>
                <li class="breadcrumb-item active">Isi data diri</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-md-12 mx-auto">
                <div class="card mb-4">
                    <div class="card-body">
                        <form id="editProfile" {{-- method="POST" action="{{ url('user-profile/post') }}" --}}>
                            {{-- @csrf --}}
                            @foreach ($data as $item)
                                @if ($item['profile_pilihan_jwb'] == 'free text')
                                    <div class="form-floating form-floating-outline my-4 flex-fill">
                                        <input class="form-control" type="search" name="{{ $item['profile_id'] }}"
                                            id="{{ $item['profile_id'] }}" />
                                        <label for="{{ $item['profile_id'] }}">{{ $item['profile_pertanyaan'] }}</label>
                                    </div>
                                @elseif(strpos($item['profile_pilihan_jwb'], '[') === 0 && substr($item['profile_pilihan_jwb'], -1) === ']')
                                    <?php
                                    $correctJson = str_replace("'", "\"", $item['profile_pilihan_jwb']);
                                    $options = json_decode($correctJson);
                                    // print_r($options);
                                    ?>
                                    <div class="form-floating form-floating-outline mb-4 flex-fill">
                                        <select class="form-select" id="{{ $item['profile_id'] }}"
                                            name="{{ $item['profile_id'] }}">
                                            <option selected value="" disabled>Pilih salah satu</option>
                                            @foreach ($options[0] as $key => $value)
                                                <option value="{{ $value }}">{{ $key }}</option>
                                            @endforeach
                                        </select>
                                        <label for="{{ $item['profile_id'] }}"
                                            class="form-label">{{ $item['profile_pertanyaan'] }}</label>
                                    </div>
                                @endif
                            @endforeach

                            <div class="d-flex justify-content-end">
                                <div id="loadingSpinner" class="spinner-border text-primary m-3" role="status"
                                    style="display: none;">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <button type="button" class="btn btn-primary" onclick="postProfile()">Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getDataDetail();
        });
        const loadingSpinner = document.getElementById('loadingSpinner')
        const apiUrl = '{{ config('app.api_url') }}';
        const accessToken = '{{session('token')}}';
        const userId = storedUserData.id
        let existingData = [];
        const alertSuccess = document.getElementById('success-data-post');
        const alertError = document.getElementById('error-data-post');

        let successCount = 0;

        function getDataDetail() {
            axios.get(apiUrl + `detail-profile-jwb-byuserid/${userId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        existingData = data.data;
                        updateProfileDetails(existingData);
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
                const element = document.getElementById(d.jwb_profile_id)
                if (element.tagName == 'SELECT') {
                    setSelectOption(element, d.jwb_jawaban)
                } else {
                    element.value = d.jwb_jawaban
                }

            });
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

        function postProfile() {
            const tanggal = new Date()
            const formattedDate = new Date(tanggal.setHours(tanggal.getHours()+7))
            const alert = document.getElementById('success-data-post');
            // const loadingSpinner = document.getElementById('loadingSpinner');
            // loadingSpinner.style.display = 'block';
            var form = document.getElementById('editProfile');
            var formData = new FormData(form);
            const data = {};
            formData.forEach(function(value, key) {
                data['jwb_jawaban'] = value ? value : "null"
                data['jwb_userid'] = userId
                data['jwb_profile_id'] = key
                data['jwb_date'] = formattedDate
                // var singleFormData = new FormData();
                // singleFormData.append('jwb_jawaban', value ? value : "null");
                // singleFormData.append('jwb_userid', userId);
                // singleFormData.append('jwb_profile_id', key);
                // singleFormData.append('jwb_date', new Date())


                const existingRecord = existingData.find(record => record.jwb_profile_id == key);
                if (existingRecord) {
                    data['jwb_id'] = existingRecord.jwb_id
                    // singleFormData.append('jwb_id', existingRecord.jwb_id);
                    setTimeout(() => {
                        axios.put(apiUrl + 'detail-profile-jwb/update', data, {
                                headers: {
                                    'Authorization': `Bearer ${accessToken}`
                                },
                                timeout: 10000
                            })
                            .then(response => {
                                // console.log(response.data);
                                successCount++;
                                var formDataArray = Array.from(formData.entries());
                                console.log(successCount,formDataArray.length)
                                checkCompletion(formData);
                            })
                            .catch(error => {
                                console.error('Error:', error)
                                alertError.classList.remove('d-none');
                        });
                    }, key * 1000);
                } else {
                    setTimeout(() => {
                        axios.post(apiUrl + 'detail-profile-jwb/create', data, {
                                headers: {
                                    'Authorization': `Bearer ${accessToken}`
                                },
                                timeout: 10000
                            })
                            .then(response => {
                                console.log(response.data);
                                successCount++;
                                checkCompletion(formData);
                            })
                            .catch(error => {
                                console.error('Error:', error)
                                alertError.classList.remove('d-none');
                            });
                    }, key * 1000);
                }

            });
        }

        function checkCompletion(formData) {
            if (successCount == formData.size) {
                loadingSpinner.style.display = 'none';
                alertSuccess.classList.remove('d-none');
                window.scrollTo(0, 0);
            }else{
                loadingSpinner.style.display = 'block';
            }
        }
    </script>
@endsection
