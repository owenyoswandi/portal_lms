<body>
    <script>
        @if (session('token'))
            var sessionData = {
                api_token: '{{ session('token') }}',
                role: '{{ session('role') }}',
                nama: '{{ session('name') }}',
                username: '{{ session('username') }}',
                id: '{{ session('id') }}',
                // mr_no: '{{ session('mr_no') }}',
                // rumah_sakit: '{{ session('') }}'
            };
            localStorage.setItem('userData', JSON.stringify(sessionData));
        @endif
    </script>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ url('/home') }}" class="logo d-flex align-items-center">

                <span class="app-brand-logo demo">
                    <?php //@include('_partials.macros', ['height' => 36, 'width' => 48])
                    ?>
                    <img src="{{ asset('/assets/img/binus-university-logo.png') }}" width="100%">
                </span>
                <span class="d-none d-lg-block" style="color: black"> {{ config('variables.appName1') }} </span>

                <?php //<span class="d-none d-lg-block" style="color: #3EC7D3">{{ config('variables.appName1') }}</span>
                ?>
                <?php //<span class="d-none d-lg-block" style="color: #DA4468">{{ config('variables.appName2') }}</span>
                ?>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <!-- End Logo -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                @if (session('role') == 'Peserta')
                    <a class="{{ Request::segment(2) == 'finance' ? 'nav-link' : 'nav-link collapsed' }} px-3"
                        href="{{ url('/member/finance') }}">
                        <i class="bx bx-wallet"></i>
                        <span id="balance_all">IDR 0</span>
                    </a>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="{{ url('show-notifikasi') }}">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-danger badge-number" id="notif-badge"></span>
                    </a><!-- End Notification Icon -->

                    {{-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="notification-item">
                            <i class="bi bi-info-circle text-primary"></i>
                            <div>
                                <p id='not_deskripsi'>Quae dolorem earum veritatis oditseno</p>
                                <p id='not_waktu'>4 hrs. ago</p>
                            </div>
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                    </ul><!-- End Notification Dropdown Items --> --}}

                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/img/user.png') }}" alt="Profile" class="rounded-circle">
                        <span class="d-none d-md-block dropdown-toggle ps-2 displayUserName"></span>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6 class="displayUserName"></h6>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <a class="dropdown-item d-flex align-items-center" href="{{ url('/user-profile') }}">
                                <i class="bi bi-person"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <li>
                            <form action="{{ url('/logout') }}" method="post">
                                @csrf
                                <button class="dropdown-item d-flex align-items-center" type="submit"
                                    onclick="deleteLocalStorage()">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <script>
        @if (session('token'))
            var sessionData = {
                api_token: '{{ session('token') }}',
                role: '{{ session('role') }}',
                nama: '{{ session('name') }}',
                username: '{{ session('username') }}',
                id: '{{ session('id') }}',
                mr_no: '{{ session('mr_no') }}'
            };
            localStorage.setItem('userData', JSON.stringify(sessionData));

            // Add the getBalance function definition and immediate call
            const apiUrlBalance = '{{ config('app.api_url') }}'; // Make sure this is defined
            const accessTokenBalance = sessionData.api_token;
            const userIdBalance = sessionData.id;

            function getBalance() {
                if (sessionData.role === 'Peserta') { // Only call if user is Peserta
                    axios.get(apiUrlBalance + '/transaction-balance-byuserid/' + userIdBalance, {
                            headers: {
                                'Authorization': `Bearer ${accessTokenBalance}`
                            }
                        })
                        .then(response => {
                            const data = response.data;
                            if (data.success) {
                                console.log(data.data);
                                let amount_balance = Number(data.data).toLocaleString();
                                const balanceElement = document.getElementById('balance_all');
                                if (balanceElement) {
                                    balanceElement.innerHTML = "IDR " + amount_balance;
                                }
                            } else {
                                console.error(data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                }
            }

            // Call getBalance when DOM is fully loaded
            document.addEventListener('DOMContentLoaded', function() {
                getBalance();

                // Optional: Refresh balance every minute
                setInterval(getBalance, 60000); // 60000 ms = 1 minute
            });
        @endif
    </script>
