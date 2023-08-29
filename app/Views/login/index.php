<?php 
use App\Models\Konfigurasi_model;
$konfigurasi  = new Konfigurasi_model;
$site         = $konfigurasi->listing();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Affan - PWA Mobile HTML Template">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#0134d4">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title -->
    <title>Affan - PWA Mobile HTML Template</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Favicon -->
    <link rel="icon"  href="<?php echo base_url()?>/assets/mobile/img/core-img/favicon.ico">
    <link rel="apple-touch-icon" href="<?php echo base_url()?>/assets/mobile/img/icons/icon-96x96.png">
    <link rel="apple-touch-icon" sizes="152x152"  href="<?php echo base_url()?>/assets/mobile/img/icons/icon-152x152.png">
    <link rel="apple-touch-icon" sizes="167x167"  href="<?php echo base_url()?>/assets/mobile/img/icons/icon-167x167.png">
    <link rel="apple-touch-icon" sizes="180x180"  href="<?php echo base_url()?>/assets/mobile/img/icons/icon-180x180.png">
    <!-- CSS Libraries -->
    <link rel="stylesheet"  href="<?php echo base_url()?>/assets/mobile/css/bootstrap.min.css">
    <link rel="stylesheet"  href="<?php echo base_url()?>/assets/mobile/css/bootstrap-icons.css">
    <link rel="stylesheet"  href="<?php echo base_url()?>/assets/mobile/css/tiny-slider.css">
    <link rel="stylesheet"  href="<?php echo base_url()?>/assets/mobile/css/baguetteBox.min.css">
    <link rel="stylesheet"  href="<?php echo base_url()?>/assets/mobile/css/rangeslider.css">
    <link rel="stylesheet"  href="<?php echo base_url()?>/assets/mobile/css/vanilla-dataTables.min.css">
    <link rel="stylesheet"  href="<?php echo base_url()?>/assets/mobile/css/apexcharts.css">
    <!-- Core Stylesheet -->
    <link rel="stylesheet" href="<?php echo base_url()?>/assets/mobile/style.css">
    <!-- Web App Manifest -->
    <link rel="manifest" href="<?php echo base_url()?>/assets/mobile/manifest.json">
  </head>
  <body>
    <!-- Preloader -->
    <div id="preloader">
      <div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
    </div>
    <!-- Internet Connection Status -->
    <!-- # This code for showing internet connection status -->
    <div class="internet-connection-status" id="internetStatus"></div>
    <!-- Back Button -->
    <div class="login-back-button"><a href="element-hero-blocks.html">
        <svg class="bi bi-arrow-left-short" width="32" height="32" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
        </svg></a></div>
    <!-- Login Wrapper Area -->
    <div class="login-wrapper d-flex align-items-center justify-content-center">
      <div class="custom-container">
        <div class="text-center px-4"><img class="login-intro-img" src="<?php echo base_url()?>/assets/mobile/img/bg-img/36.png" alt=""></div>
        <!-- Register Form -->
        <div class="register-form mt-4">
          <h6 class="mb-3 text-center">Log in to continue to Affan.</h6>

          <?php echo '<span class="text-danger">'.\Config\Services::validation()->listErrors().'</span>'; ?>
<?php 

 echo form_open(base_url('login')); ?>
      <?= csrf_field() ?>

        <!-- <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div> -->
        <div class="form-group">
              <input class="form-control" name="username" type="text" placeholder="Username">
            </div>
            <div class="form-group position-relative">
              <input class="form-control"  name="password" id="password" type="password" placeholder="Enter Password">
              <div class="position-absolute" id="password-visibility"><i class="bi bi-eye"></i><i class="bi bi-eye-slash"></i></div>
            </div>
        <!-- <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div> -->
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      <?php echo form_close(); ?>
        </div>
        <!-- Login Meta -->
        <div class="login-meta-data text-center"><a class="stretched-link forgot-password d-block mt-3 mb-1" href="page-forget-password.html">Forgot Password?</a>
          <p class="mb-0">Didn't have an account? <a class="stretched-link" href="page-register.html">Register Now</a></p>
        </div>
      </div>
    </div>
    <!-- All JavaScript Files -->
    <script src="<?php echo base_url()?>/assets/mobile/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/slideToggle.min.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/internet-status.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/tiny-slider.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/baguetteBox.min.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/countdown.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/rangeslider.min.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/vanilla-dataTables.min.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/index.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/magic-grid.min.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/dark-rtl.js"></script>
    <script src="<?php echo base_url()?>/assets/mobile/js/active.js"></script>
    <!-- PWA -->
    <script src="<?php echo base_url()?>/assets/mobile/js/pwa.js"></script>
  </body>
</html>