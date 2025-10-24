@include('layouts.dist.css')
<body>

<main>
    <div class="container">
        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
				<div class="row justify-content-center">
					<div class="col-sm-2">
						<img src="{{ asset('/assets/img/binus-university-logo.png') }}" width="100%">
					</div>
				</div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
							<?php
								/*
                            <a href="index.html" class="logo d-flex align-items-center w-auto">
								
                                <span class="app-brand-logo demo">
									@include('_partials.macros', ['height' => 36, 'width' => 48])
                                </span>
                                <span class="d-none d-lg-block" style="color: #3EC7D3">{{ config('variables.appName1') }}</span>
                                <span class="d-none d-lg-block" style="color: #DA4468">{{ config('variables.appName2') }}</span>
								
                            </a>
							*/
							?>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                @yield('content')

                            </div>
                        </div>

                        <div class="credits">
                            <!-- All the links in the footer should remain intact. -->
                            <!-- You can delete the links only if you purchased the pro version. -->
                            <!-- Licensing information: https://bootstrapmade.com/license/ -->
                            <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                        </div>

                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->

@yield('footer')
@include('layouts.dist.js')

{{--@include('footer')--}}
