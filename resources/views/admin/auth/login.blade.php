@extends('admin.layouts.auth')
@section('title', 'Login')
@section('content')
<div class="account-pages my-5 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="card-body pt-0">

                        <h3 class="text-center mt-5 mb-4">
                            <a href="javascript:void(0);" class="d-block auth-logo">
                                <img src="{{ url('assets/images/logo.png') }}" alt="" height="50" class="auth-logo-dark">
                            </a>
                        </h3>
                        @if(Session::has('message') && !Auth::guard('admin')->check())
                        <div class="alert {{ Session::get('alert-class') }} alert-dismissible fade show mb-0" role="alert">
                            
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            <strong>{{ Session::get('message') }}</strong>
                        </div>
                        @endif
                        <div class="p-3">
                            <form class="form-horizontal mt-4 needs-validation" method="POST" action="{{ url('admin/authenticate') }}" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                                </div>
                                <div class="mb-3 row mt-4">
                                    <div class="col-12 text-center">
                                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="mb-3 text-center">
                            &copy; {{ date('Y') }} 7Stock Holding <span class="d-none d-sm-inline-block"> - Crafted with <i class="mdi mdi-heart text-danger"></i> by 7Stock Team.</span>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
@stop
@section('javascript')
<script src="{{ asset('assets/js/backstretch.min.js') }}"></script>
<script>
    $.backstretch([
      "../assets/images/directory-bg.jpg",
    ], {duration: 3000, fade: 750});
</script>
@endsection