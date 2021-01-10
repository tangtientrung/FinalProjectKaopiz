<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Home | E-Shopper</title>
    <base href="{{asset('')}}">
    @yield('css')
    <link href="frontend/assets/vendor/icofont/icofont.min.css" rel="stylesheet">
    <link href="frontend/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="frontend/css/bootstrap.min.css" rel="stylesheet">
    <link href="frontend/css/font-awesome.min.css" rel="stylesheet">
    <link href="frontend/css/prettyPhoto.css" rel="stylesheet">
    <link href="frontend/css/price-range.css" rel="stylesheet">
    <link href="frontend/css/animate.css" rel="stylesheet">
  <link href="frontend/css/main.css" rel="stylesheet">
  <link href="frontend/css/responsive.css" rel="stylesheet">
    <!-- Font Awesome -->
  <link rel="stylesheet" href="admin/plugins/fontawesome-free/css/all.min.css">
 <!--  <link rel="stylesheet" href="admin/dist/css/adminlte.min.css"> -->
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="frontend/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="frontend/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="frontend/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="frontend/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="frontend/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->

<body>
  <header id="header"><!--header-->
    
    
    @include('frontend.layouts.header')
    @include('frontend.layouts.menu')
  
    

      
  </header><!--/header-->
  
  @yield('content')
  
  <footer id="footer">
    @include('frontend.layouts.footer')
  </footer><!-- End Footer -->
  

  
    <script src="frontend/js/jquery.js"></script>
    <script src="frontend/js/jquery.min.js"></script>
  <script src="frontend/js/bootstrap.min.js"></script>
  <script src="frontend/js/jquery.scrollUp.min.js"></script>
  <script src="frontend/js/price-range.js"></script>
    <script src="frontend/js/jquery.prettyPhoto.js"></script>
    <script src="frontend/js/main.js"></script>
    <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v9.0'
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));</script>
    @yield('script')
</body>
</html>