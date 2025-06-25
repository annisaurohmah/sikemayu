<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SIKEMAYU</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/">
    <!-- <link href="{{ URL::asset('assets/css/attendanceFront.css') }}" rel="stylesheet" type="text/css" /> -->
        <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ URL::asset('assets/css/fontawesome.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/templatemo-plot-listing.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/animated.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ URL::asset('assets/css/owl.css') }}" type="text/css" />
    <!-- Tambahkan di dalam <head> HTML -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/v4-shims.min.css">
        <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    
    @include('layouts.head')
</head>

<body>
  
    @yield('content')
    @include('layouts.footer-script')
    @include('includes.flash')
    <!-- <script src="{{ URL::asset('assets/js/attendanceFront.js') }}"></script> -->
    <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="{{ URL::asset('assets/js/owl-carousel.js') }}"></script>
  <script src="{{ URL::asset('assets/js/animation.js') }}"></script>
  <script src="{{ URL::asset('assets/js/imagesloaded.js') }}"></script>
  <script src="{{ URL::asset('assets/js/custom.js') }}"></script>
   
</body>

</html>
