@include('layouts.dist.css')
@if (!session('id'))
    <script>
        window.location.href = "{{ route('login') }}";
    </script>
@endif
@include('layouts.user.header')

@include('layouts.user.sidebarnav')

<main id="main" class="main">
    @yield('content')
</main>

@include('layouts.user.footer')
@include('layouts.dist.js')
@section('java_script')
@show
