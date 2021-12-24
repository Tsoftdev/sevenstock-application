<!doctype html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <title>@yield('title') | 7Stock Holding </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ url('assets/images/favicon.ico') }}"> 
        @include('admin.layouts.partials.auth-css')
        
        
    </head>

<body>
    @yield('content')
    @include('admin.layouts.partials.auth-javascript')
</body>

</html>