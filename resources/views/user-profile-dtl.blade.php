@extends('layouts.user.base')

@section('title', 'Detail Profile')

@section('content')
    <div class="pagetitle">
        <h1>Detail Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user-profile') }}">Profile</a></li>
                <li class="breadcrumb-item active">Detail Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            @foreach ($result->groupBy('profile_kategori') as $category => $items)
                <div class="col-lg-6">
                    <div class="card flex-fill">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-lg-12">
                                    <h5 class="fw-bold">{{ $category }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($items as $item)
                                <div class="row mb-3">
                                    <div class="col-lg-6 col-md-4 d-flex flex-column" style="color: rgba(1, 41, 112, 0.6);">
                                        <span class="fw-bold">{{ $item['profile_pertanyaan'] }}</span>
                                        <small class="font-size:12px">{{ $item['profile_keterangan'] }}</small>
                                    </div>
                                    @if ($item['profile_pilihan_jwb'] == 'free text')
                                        <div class="col-lg-6 col-md-8 profile-question" id="{{ $item['profile_id'] }}"
                                            data-profile-id="{{ $item['profile_id'] }}" data-options="free text"></div>
                                    @else
                                        <div class="col-lg-6 col-md-8 profile-question" id="{{ $item['profile_id'] }}"
                                            data-profile-id="{{ $item['profile_id'] }}"
                                            data-options="{{ $item['profile_pilihan_jwb'] }}"></div>
                                    @endif
                                    {{-- <div class="col-lg-6 col-md-8" id="{{ $item['profile_id'] }}"></div> --}}

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            getDataDetail();
        });

    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const accessToken = '{{session('token')}}';
        const username = storedUserData.username;
        const userId = storedUserData.id
        const url = '{{ config('app.app_url') }}'

        function getDataDetail() {
            axios.get(apiUrl + `detail-profile-jwb-byuserid/${userId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data)
                        updateProfileDetails(data.data);
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateProfileDetails(data) {
            const answers = {};

            data.forEach(answer => {
                answers[answer.jwb_profile_id] = answer.jwb_jawaban;
            });

            const profileQuestions = document.querySelectorAll('.profile-question');
            profileQuestions.forEach(question => {
                const profileId = question.dataset.profileId;
                const answer = answers[profileId];
                const options = question.dataset.options;

                if (options != 'free text') {
                    // console.log(options)
                    let strippedOption = options.slice(1, -1);
                    let correctedOption = strippedOption.replace(/'/g, '"');
                    // console.log(correctedOption);
                    correctedOption = JSON.parse(correctedOption)
                    console.log(correctedOption);
                    const selectedOption = Object.keys(correctedOption).find(key => correctedOption[key] == answer);
                    question.innerHTML = selectedOption ? selectedOption : '-';
                } else {
                    question.innerHTML = answer ? answer : '-';
                }
            });
        }
    </script>
@endsection
