<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8" />
    <title>@yield('title') | 7Stock Holding Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    @include('admin.layouts.partials.appcss')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">
        @include('admin.layouts.partials.appheader')
        @include('admin.layouts.partials.leftsidebar')
        <div class="main-content">
            <div class="page-content">
                @if (session('status'))
                    <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
                @endif
                @if ($errors->any())
                     @foreach ($errors->all() as $error)
                         <div class="alert alert-danger">{{$error}}</div>
                     @endforeach
                @endif
                @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
        @include('admin.layouts.partials.footer')
       
    </div>
    <audio id="success-audio">
        <source src="{{ asset('assets/audio/success.ogg') }}" type="audio/ogg">
        <source src="{{ asset('assets/audio/success.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="error-audio">
        <source src="{{ asset('assets/audio/error.ogg') }}" type="audio/ogg">
        <source src="{{ asset('assets/audio/error.mp3') }}" type="audio/mpeg">
    </audio>
    <audio id="warning-audio">
        <source src="{{ asset('assets/audio/warning.ogg') }}" type="audio/ogg">
        <source src="{{ asset('assets/audio/warning.mp3') }}" type="audio/mpeg">
    </audio>
    @include('admin.layouts.partials.rightsidebar')
    @include('admin.layouts.partials.appjavascript')
</body>

</html>