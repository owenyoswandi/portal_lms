@extends('layouts.user.base')

@section('title', 'Home')

@section('content')
    <div class="pagetitle">
        <h1>Profiling</h1>
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

                        <div class="accordion" id="accordionExample">
							<div class="accordion-item">
							  <h2 class="accordion-header" id="headingOne">
								<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								  Experience Management System (EMS)
								</button>
							  </h2>
							  <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
								<div class="accordion-body">
								  <div class="list-group"><a href="<?= url(session('link_ems')) ?>" class="list-group-item list-group-item-action">Login As <span class="fw-bold">Member</span></a></div>
								</div>
							  </div>
							</div>
							<br>
							<div class="accordion-item">
							  <h2 class="accordion-header" id="headingTwo">
								<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								  Project Management System (PMS)
								</button>
							  </h2>
							  <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
								<div class="accordion-body">
								  <div class="list-group"><a href="<?= url(session('link_pms')) ?>" class="list-group-item list-group-item-action">Login As <span class="fw-bold">User</span></a></div>
								</div>
							  </div>
							</div>
							<br>
							
						  </div><!-- End Default Accordion Example -->
                    </div>
                </div>

                
    </section>
    <script>
        
    </script>
@endsection
