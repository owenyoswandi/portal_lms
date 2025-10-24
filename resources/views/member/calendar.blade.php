@extends('layouts.user.base')

@section('title', 'Calendar')

@section('content')
    <div class="pagetitle">
        <h1>My Calendar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">My Calendar</a></li>
                <li class="breadcrumb-item">View Project</li>
            </ol>
        </nav>

    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-5" style="overflow-x:auto">
                    <div id="calendar">
                    </div>
                </div>
            </div>
            </div>
        </div>
    </section>
@endsection

@section('java_script')
    <script>
    const apiUrl = window.apiUrl || '{{ config('app.api_url') }}';
        const accessToken = '{{ session('token') }}';
        const userId = '{{ session('userid') }}';

        document.addEventListener("DOMContentLoaded", () => {
           fetchCalendarData();
        });


        function fetchCalendarData() {
            var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth',
                events: function(info, successCallback, failureCallback) {
                    axios.get(apiUrl + `/project-by-user/${userId}`, {
                        headers: {
                            'Authorization': `Bearer ${accessToken}`
                        }
                    })
                    .then(function(response) {
                        if (response.data.success) {
                            successCallback(response.data.data.map(event => ({
                                title: event.project_name,  // Mengambil judul project
                                start: event.start_date,  // Mengambil start_date
                                end: event.end_date   // Mengambil end_date
                            })));
                        } else {
                            console.error('Gagal mengambil event:', response.data.message);
                            failureCallback('Gagal mengambil event');
                        }
                    })
                    .catch(function(error) {
                        console.error('Error:', error);
                    });
                }
            });

            calendar.render();


        }


    </script>
@endsection
