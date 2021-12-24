<!-- Jquery Js-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<!-- Bootstrap Js-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<!-- Splide   -->
<!-- counter up  -->
<script src="{{ asset('website/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('website/js/jquery.waypoints.min.js') }}"></script>
<!-- counter up  -->

<!-- <script src="{{ asset('website/js/bootstrap.min.js') }}"></script> -->
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<!--AOS Js-->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<!--Owl Carouse js-->
<script src="{{ asset('website/js/owl.carousel.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
<!-- Custom Js-->
<script src="{{ asset('website/js/custom.js') }}"></script>

<script>
  var prevIcon = '<img src="<?php echo asset('assets/images/bleft.svg'); ?>" alt="">';
  var nextIcon = '<img src="<?php echo asset('assets/images/bright.svg'); ?>" alt="">';
  $('.blog-carousel').owlCarousel({
    loop: true,
    margin: 10,
    nav: true,
    slideBy: 1,
    // autoplay: true,
    autoplayTimeout: 4000,
    autoplayHoverPause: true,
    navText: [
      prevIcon,
      nextIcon
    ],
    responsive: {
      0: {
        items: 1
      },
      600: {
        items: 1
      },
      1000: {
        items: 1
      }
    }
  })
</script>
@yield('javascript')