@extends('layouts.login.base')

@section('title', 'Login')

@section('content')

    <div class="pt-4 pb-2">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
        <p class="text-center small">Enter your username & password to login</p>
    </div>
    <div class="alert alert-danger alert-dismissible fade show d-none" role="alert" id="salah-login">
        <i class="bi bi-exclamation-octagon me-1"></i>
        <span class="small">Username atau password tidak sesuai!</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <form class="row g-3 needs-validation" method="post" action="{{ route('login') }}" id="loginForm" novalidate>
        @csrf
        <div class="col-12">
            <label for="yourUsername" class="form-label">Username</label>
            <div class="input-group has-validation">
                <input type="text" name="username" class="form-control" id="yourUsername" required>
                <div class="invalid-feedback">Please enter your username.</div>
            </div>
        </div>

        <div class="col-12">
            <label for="yourPassword" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="yourPassword" required>
            <div class="invalid-feedback">Please enter your password!</div>
            <a href="{{ url('forgot-password') }}" class="small float-end mb-1">
                <span>Forgot Password?</span>
            </a>
        </div>


        <div class="col-12">
            <button class="btn btn-primary w-100" type="submit">Login</button>
        </div>
        <div class="col-12">
            <p class="small mb-0">Don't have account? <a href="{{ url('/register') }}">Create an account</a></p>
        </div>
    </form>

    <script></script>
@endsection
