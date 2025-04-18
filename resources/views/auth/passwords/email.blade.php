<!doctype html>
<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/"
  data-template="horizontal-menu-template"
  data-style="light">
  <head>
      <style type="text/css">
          body {
          background-image: url("../img/bg4.jpg");
          height: 100%;

          background-position: center;
          background-repeat: no-repeat;
          background-attachment: fixed;
          background-size: cover;
          }
      </style>
      <meta charset="utf-8" />
      <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

      <title>App Sinergy</title>
      <!-- Favicon -->
      <link rel="icon" type="image/x-icon" href="{{url('img/siplogooke.webp')}}" />

      <!-- Fonts -->
      <link rel="preconnect" href="https://fonts.googleapis.com" />
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
      <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

      <!-- Icons -->
      <link rel="stylesheet" href="../../assets/vendor/fonts/boxicons.css" />
      <link rel="stylesheet" href="../../assets/vendor/fonts/fontawesome.css" />
      <link rel="stylesheet" href="../../assets/vendor/fonts/flag-icons.css" />

      <!-- Core CSS -->
      <link rel="stylesheet" href="../../assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
      <link rel="stylesheet" href="../../assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
      <link rel="stylesheet" href="../../assets/css/demo.css" />

      <!-- Vendors CSS -->
      <link rel="stylesheet" href="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
      <link rel="stylesheet" href="../../assets/vendor/libs/typeahead-js/typeahead.css" />
      <!-- Vendor -->
      <link rel="stylesheet" href="../../assets/vendor/libs/@form-validation/form-validation.css" />

      <!-- Page CSS -->
      <!-- Page -->
      <link rel="stylesheet" href="../../assets/vendor/css/pages/page-auth.css" />

      <!-- Helpers -->
      <script src="../../assets/vendor/js/helpers.js"></script>
      <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
      <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
      <script src="../../assets/vendor/js/template-customizer.js"></script>
      <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
      <script src="../../assets/js/config.js"></script>
  </head>

  <body>
      <div class="authentication-wrapper authentication-cover">
        <!-- Logo -->
        <a href="index.html" class="app-brand auth-cover-brand gap-2">
          <span class="app-brand-logo demo">
            <!-- <img src="{{url('img/siplogooke.webp')}}" width="25"> -->
          </span>
          <!-- <span class="app-brand-text demo text-heading fw-bold">SIMS-APP</span> -->
        </a>
        <!-- /Logo -->
        <div class="authentication-inner row m-0">
          <!-- /Left Text -->
          <div class="d-none d-lg-flex col-lg-7 col-xl-8" style="padding-right: 0;padding-left: 0;">
            <div class="w-100 position-relative" style="height: 100vh; overflow: hidden;">
              <img src="{{ asset('/img/JIT-edited-v1.png') }}" 
                   class="img-fluid w-100 h-100" 
                   alt="Login image" 
                   style="object-fit: cover;">

              <div class="text-white px-4 py-3" 
                   style="
                     position: absolute;
                     bottom: 0;
                     width: 100%;
                     background-color: rgba(79, 39, 39, 0.19);
                     text-align: center;
                     opacity: 0.8;
                   ">
                <h5 class="mb-1" style="text-align: left;color: white;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">Sinergy Integrated Management System</h5>
                <p style="font-size: 12px; margin: 0;text-align: left;font-family: 'Lucida Sans', 'Lucida Grande', 'Lucida Sans Unicode', Geneva, Verdana, sans-serif;">
                  This website, which was made by the PT Sinergy Informasi Pratama (“SIP” hereinafter), is the property of SIP. If you are not a registered user or do not have the authority to access the website, you must not connect to this web page.
                </p>
              </div>
            </div>
          </div>
          <!-- /Left Text -->

          <!-- Reset Password -->
          <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-6 p-sm-12">
            <div class="w-px-400 mx-auto mt-12 pt-5">
              <h6 class="mb-1">Reset Password 🔒</h6>
              <p class="mb-6">
                <div class="logo text-center"><img src="{{asset('/img/siplogin.webp')}}" width="90" height="40" alt="Klorofil Logo"></div>
                <p class="text-center">Sinergy Integrated Management System</p>
              </p>
              @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
              @endif
              <form id="formAuthentication" class="mb-6" action="{{ route('password.email') }}" method="POST">
                {{ csrf_field() }}
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Email</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="email"
                      id="email"
                      class="form-control"
                      name="email"
                      placeholder="Email"
                      aria-describedby="email" />
                  </div>
                </div>
                <button class="btn btn-primary d-grid w-100 mb-6">{{ __('Send Password Reset Link') }}</button>
                <div class="text-center">
                  <a href="{{url('/login')}}">
                    <i class="bx bx-chevron-left scaleX-n1-rtl me-1_5 align-top"></i>
                    Back to login
                  </a>
                </div>
              </form>
            </div>
          </div>
          <!-- /Reset Password -->
        </div>
      </div>

      <!-- / Content -->

      <!-- Core JS -->
      <!-- build:js assets/vendor/js/core.js -->

      <script src="../../assets/vendor/libs/jquery/jquery.js"></script>
      <script src="../../assets/vendor/libs/popper/popper.js"></script>
      <script src="../../assets/vendor/js/bootstrap.js"></script>
      <script src="../../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
      <script src="../../assets/vendor/libs/hammer/hammer.js"></script>
      <script src="../../assets/vendor/libs/i18n/i18n.js"></script>
      <script src="../../assets/vendor/libs/typeahead-js/typeahead.js"></script>
      <script src="../../assets/vendor/js/menu.js"></script>

      <!-- endbuild -->

      <!-- Vendors JS -->
      <script src="../../assets/vendor/libs/@form-validation/popular.js"></script>
      <script src="../../assets/vendor/libs/@form-validation/bootstrap5.js"></script>
      <script src="../../assets/vendor/libs/@form-validation/auto-focus.js"></script>

      <!-- Main JS -->
      <script src="../../assets/js/main.js"></script>

      <!-- Page JS -->
      <script src="../../assets/js/pages-auth.js"></script>
  </body>
</html>