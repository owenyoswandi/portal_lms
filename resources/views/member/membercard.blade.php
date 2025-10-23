@extends('dist.layout_member') 

@section('title')
    {{env('APP_NAME')}} | My Course
@endsection
@section('css')
    <style>
      .link {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
      }
      .card-footer p {
        margin-top: 0px;
        margin-bottom: 5px;
      }
    </style>
@endsection

@section('menu')
@include('dist.menu_member') 
@endsection 

@section('content')
    <div class="pagetitle">
      <h1>Member Card</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Users</a></li>
          <li class="breadcrumb-item">Member Card</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div id="course">
            
          </div>
        </div>
      </div>	  
    </section>
@endsection 

@section('java_script')
	<!-- silahkan isi dengan java script -->
	<script>
		
	</script>
@endsection 