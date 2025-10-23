@extends('layouts.user.base')

@section('title', 'Home')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <div class="my-3">
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">

                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Halo👋 !</h5>

                                <div class="d-flex">
                                    <span>Selamat datang di aplikasi </span>
                                    <span class="app-brand-logo demo">
                                        @include('_partials.macros', ['height' => 20, 'width' => 32])
                                    </span>
                                    <span class="d-lg-block"
                                        style="color: #3EC7D3; font-weight: 700;font-family: 'Nunito', sans-serif;">{{ config('variables.appName1') }}</span>
                                    <span class="d-lg-block"
                                        style="color: #DA4468; font-weight: 700;font-family: 'Nunito', sans-serif;">{{ config('variables.appName2') }},</span>
                                </div>
                                <span class="displayUserName"></span>!

                                @php
                                    $userRole = session('role');
                                @endphp
                                @if ($userRole == 'Pasien')
                                    <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show  mt-3"
                                        role="alert">
                                        <span>
                                            Silakan untuk mengisi catatan harian jantungku <a
                                                href="{{ url('kondisi-harian-add') }}" class="fw-bold text-white">di
                                                sini</a>
                                        </span>

                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="alert alert-primary bg-primary text-light border-0 alert-dismissible fade show"
                                        role="alert">
                                        <span>
                                            Silakan untuk mengisi penilaian kualitas hidup <a
                                                href="{{ url('penilaian-hidup-form') }}" class="fw-bold text-white">di
                                                sini</a>
                                        </span>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @if (session('role') != 'Pasien')
                        <div class="col-lg-6">
                        @else
                            <div class="col-lg-12">
                    @endif
                    <div class="card">
                        <div class="card-title">
                            <h5 class="fw-bold px-3">Data Kunjungan</h5>
                        </div>
                        <div class="card-body">
                            <div id="lineChart"></div>
                        </div>
                    </div>
                </div>
                @if (session('role') != 'Pasien')
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-title">
                                <h5 class="fw-bold px-3">Data Sebaran User</h5>
                            </div>
                            <div class="card-body">
                                <div id="sebaranChart"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                @if (session('role') != 'Pasien')
                    <div class="col-lg-6">
                    @else
                        <div class="col-lg-12">
                @endif
                <div class="card">
                    <div class="card-title">
                        <h5 class="fw-bold px-3" id="RerataCatatanHarianTitle">
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="RerataCatatanHarian"></div>
                    </div>
                </div>
            </div>
            @if (session('role') != 'Pasien')
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-title">
                            <h5 class="fw-bold px-3">Rerata Berat Badan Pasien</h5>
                        </div>
                        <div class="card-body">
                            <div id="RerataBeratBadan"></div>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('role') != 'Pasien')
				<?php
				/*
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-title">
                            <h5 class="fw-bold px-3">Scoring Kualitas Hidup</h5>
                        </div>
                        <div class="card-body">
                            <div id="ScoringKualitasHidup"></div>
                        </div>
                    </div>
                </div>
				*/
				?>
            @endif
        </div>
        </div><!-- End Left side columns -->

        </div>
    </section>
    <script>
        const apiUrl = '{{ config('app.api_url') }}';
        const accessToken = '{{ session('token') }}';
        const rumah_sakit = '{{ session('rumah_sakit') }}'
        const userId = storedUserData.id

        const url = '{{ config('app.app_url') }}'

        document.addEventListener("DOMContentLoaded", () => {
            if (userRole == 'Pasien') {
                getDataperUser();
            } else {
                const currentDate = new Date();
                const currentMonthName = currentDate.toLocaleString('id', {
                    month: 'long'
                });
                document.getElementById('RerataCatatanHarianTitle').innerHTML =
                    `Grafik Presentase Catatan Harian Bulan ${currentMonthName}`
                getData();
                getDataSebaran();
                getRerataCHPerBulan()
                getBBData()
            }
        });

        function getBBData() {
            axios.get(apiUrl + `grafik-kondisiharian-bb`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'X-Rumah-Sakit': rumah_sakit ? rumah_sakit : ''
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data)
                        const formattedData = data.data.map(d => ({
                            kh_date: d.kh_date,
                            total: d.RaataanBB.toFixed(2)
                        }));
                        renderLineChart("RerataBeratBadan", {
                            seriesName: "Rerata Berat Badan",
                            data: formattedData,
                            categoryField: "kh_date"
                        }, 'sebaran');
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getRerataCHPerBulan() {
            axios.get(apiUrl + `dashboard-kondisiharian-jumlah`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'X-Rumah-Sakit': rumah_sakit ? rumah_sakit : ''
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data.data)
                        const totals = data.data.map(item => item.Jumlah);
                        const users = data.data.map(item => item.nama)
                        // const totalPerMonth = totals.reduce((acc, curr) => acc + curr, 0);
                        const daysInCurrentMonth = moment().daysInMonth();
                        const percentages = totals.map(total => ((total / daysInCurrentMonth) * 100).toFixed(2));
                        renderColumnChart("RerataCatatanHarian", {
                            seriesName: "Total Catatan Harian",
                            data: percentages,
                            categoryField: users
                        });
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function renderColumnChart(chartId, dataset) {
            console.log(dataset)
            new ApexCharts(document.querySelector(`#${chartId}`), {
                series: [{
                    name: dataset.seriesName,
                    data: dataset.data,
                    color: '#3EC7D3'
                }],
                chart: {
                    type: 'bar',
                    height: 350
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: dataset.categoryField,
                },
                yaxis: {
                    min: 0,
                    max: 100,
                    title: {
                        text: dataset.seriesName
                    }
                },
                fill: {
                    opacity: 1
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toFixed(2) + '%';
                        }
                    }
                }
            }).render();
        }

        function renderLineChart(chartId, dataset, type) {
            let category = ''
            if (type == "kunjungan") {
                category = dataset.data.map(item => getMonthName(item[dataset.categoryField]))
            } else {
                category = dataset.data.map(item => item[dataset.categoryField] || "UNKNOWN");
            }
            const chartData = {
                series: [{
                    name: dataset.seriesName,
                    data: dataset.data.map(item => item.total)
                }],
                chart: {
                    height: 350,
                    type: 'line',
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                colors: ['#00AEB8'],
                stroke: {
                    curve: 'straight'
                },
                grid: {
                    row: {
                        colors: ['#f3f3f3', 'transparent'],
                        opacity: 0.5
                    },
                },
                xaxis: {
                    categories: category
                }
            };

            new ApexCharts(document.querySelector(`#${chartId}`), chartData).render();
        }


        function getData() {
            axios.get(apiUrl + `dashboard-kunjungan`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'X-Rumah-Sakit': rumah_sakit
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        // console.log(data)
                        const totals = data.data.map(item => item.total);
                        renderLineChart("lineChart", {
                            seriesName: "Total Kunjungan",
                            data: data.data,
                            categoryField: "month"
                        }, 'kunjungan');
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function getDataSebaran() {
            // Fetch sebaran data
            axios.get(apiUrl + 'dashboard-sebaran', {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'X-Rumah-Sakit': rumah_sakit
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        console.log(data);
                        axios.get(url + '/public/assets/js/provinces.json')
                            .then(provincesResponse => {
                                const provincesData = provincesResponse.data;

                                const provinceMap = new Map(provincesData.map(province => [province.code.toString(),
                                    province.name
                                ]));

                                const newData = data.data.map(item => ({
                                    provinsi: provinceMap.get(item.provinsi) || item
                                        .provinsi,
                                    total: item.total
                                }));

                                renderLineChart("sebaranChart", {
                                    seriesName: "Total Sebaran",
                                    data: newData,
                                    categoryField: "provinsi"
                                }, 'sebaran');
                            })
                            .catch(provincesError => {
                                console.error('Error loading provinces data:', provincesError);
                            });
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }



        function getDataperUser() {
            axios.get(apiUrl + `dashboard-kunjungan/${userId}`, {
                    headers: {
                        'Authorization': `Bearer ${accessToken}`,
                        'X-Rumah-Sakit': rumah_sakit
                    }
                })
                .then(response => {
                    const data = response.data;
                    if (data.success) {
                        const totals = data.data.map(item => item.total);
                        renderLineChart("lineChart", {
                            seriesName: "Total Kunjungan",
                            data: data.data,
                            categoryField: "month"
                        }, "kunjungan");
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });

        }

        function getMonthName(monthNumber) {
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Juni", "Juli", "Agu", "Sept",
                "Okt", "Nov", "Des"
            ];
            return monthNames[monthNumber - 1]; // Adjust month number to array index
        }
    </script>
@endsection
