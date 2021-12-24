<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>@yield('title') | 7Stock Holding </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
  <meta content="Themesbrand" name="author" />
  <!-- FavIcon-->
  <link rel="shortcut icon" href="{{ asset ('website/assets/favicon/favicon.png') }}" type="image/x-icon">
  @include('website.layouts.partials.webcss')
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <div class="wrapper">

    @yield('content')

  </div>
  @include('website.layouts.partials.webjavascript')
  <script>
    //  Bootstrap form validation
    (function() {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>

</html>