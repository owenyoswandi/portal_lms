@extends('layouts.login.base')

@section('title','Forgot Password')

@section('content')
    <div class="pt-4 pb-2">
        <h5 class="card-title text-center pb-0 fs-4">Forgot Password</h5>
        <p class="text-center small">Enter your email</p>
    </div>

    <form class="row g-3 needs-validation" novalidate>

        <div class="col-12">
            <label for="yourUsername" class="form-label">Email</label>
            <div class="input-group has-validation">
                <input type="email" name="email" class="form-control" id="yourUsername" required>
                <div class="invalid-feedback">Please enter your email.</div>
            </div>
        </div>

        <div class="col-12">
            <a href="#" class="btn btn-primary w-100" type="submit">Submit</a>
        </div>
        <div class="col-12">
            <p class="small mb-0"><a href="{{ url('/login') }}">Kembali</a></p>
        </div>
    </form>
@endsection
