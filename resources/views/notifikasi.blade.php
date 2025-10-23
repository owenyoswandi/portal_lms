@extends('layouts.user.base')

@section('title', 'Notifikasi')

@section('content')
    <div class="pagetitle">
        <h1>Notifikasi</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Notifikasi</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="mt-3 d-flex gap-2 flex-column" id="notificationList">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn btn-primary" onclick="readAll()">Tandai telah dibaca semua</button>
                </div>
            </div>
        </div>
    </section>
    <script></script>
@endsection
