<!DOCTYPE html>
<html 
    lang="en"
    class="light-style layout-wide customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{asset('assets')}}"
    data-template="vertical-menu-template-free"
    data-style="light">

    <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>App Sinergy</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('img/siplogooke.webp')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" />

    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/pages/page-auth.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>
  </head>

  <body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover">
      <!-- Logo -->
      <a href="index.html" class="app-brand auth-cover-brand gap-2">
        <span class="app-brand-logo demo">
          <!-- <img src="{{url('img/siplogooke.webp')}}" width="25"> -->
        </span>
        <span class="app-brand-text demo text-white fw-bold">SIMS-APP</span>
      </a>
      <!-- /Logo -->
      <div class="authentication-inner row m-0">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 col-xl-8" style="padding-right: 0;padding-left: 0;">
          <!--<div class="w-100 d-flex justify-content-center">
            <img src="https://dewatiket.id/blog/wp-content/uploads/2025/02/Menara-Astra.jpg" class="img-fluid" alt="Login image" style="visibility: visible;  width: 100%;
            height: 100vh; /* atau ukuran lain sesuai kebutuhan */
            background-image: url('gambar.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;">
            <img src="{{ asset('/img/JIT-edited-hd.png') }}" class="img-fluid" alt="Login image" style="visibility: visible;  width: 100%;
            height: 100vh;
            background-image: url('gambar.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            object-fit: fill;">
            <div class="content-text text" style="background-color: #17325e ;opacity: 0.8">
              <h1 class="heading">Sinergy Integrated Management System</h1>
              <p style="font-size: 12px;">This website that was made by the PT Sinergy Informasi Pratama (“SIP” hereinafter) is in the property right of SIP. If you are not a member of registered user or having the authority for the website, you must not connect to this web page.</p>
            </div>
          </div> -->
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

        <!-- Login -->
        <div class="d-flex col-12 col-lg-5 col-xl-4 align-items-center authentication-bg p-sm-12 p-6">
          <div class="w-px-400 mx-auto mt-12 pt-5">
            <div class="logo text-center"><img src="{{asset('/img/siplogin.webp')}}" width="123" height="60" alt="Klorofil Logo"></div>
              <p class="text-center">Sinergy Integrated Management System</p>
              @if ($errors->has('email') || $errors->has('password'))
              <form id="formAuthentication" class="mb-6 needs-validation was-validated" method="POST" action="{{ route('login') }}" novalidate autocomplete="off">
              @else
              <form id="formAuthentication" class="mb-6 needs-validation" method="POST" action="{{ route('login') }}" novalidate autocomplete="off">
              @endif
                  @csrf
                  @if(session()->has('message'))
                      <div class="alert alert-warning notification-bar" id="alert">
                          {{ session()->get('message') }}
                      </div>
                  @endif
                  <div class="mb-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="form-label">Email</label>
                    <input
                      type="text"
                      class="form-control rounded-pill"
                      id="email"
                      name="email"
                      placeholder="Enter your email"
                      autofocus
                      required />
                      @if ($errors->has('email'))
                        <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                      @endif
                  </div>
                  <div class="mb-6 form-password-toggle{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label class="form-label" for="password">Password</label>
                    <div class="input-group input-group-merge rounded-pill">
                      <input
                        aucom
                        type="password"
                        id="password"
                        class="form-control"
                        name="password"
                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                        aria-describedby="password" 
                        required
                        style="border-bottom-left-radius: 50rem !important;border-top-left-radius: 50rem !important;"
                      />
                        <span class="input-group-text cursor-pointer" style="border-bottom-right-radius: 50rem !important;border-top-right-radius: 50rem !important;"><i class="icon-base bx bx-hide"></i></span>
                        @if ($errors->has('password'))
                          <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                        @endif
                    </div>
                  </div>
                  <div class="mb-8">
                    <div class="d-flex justify-content-between mt-8">
                      <a href="{{ route('password.request') }}">
                        <span>Forgot Password?</span>
                      </a>
                    </div>
                  </div>
                  <div class="mb-6">
                    <button class="btn btn-primary rounded-pill d-grid w-100" type="submit">Login</button>
                  </div>
              </form>
              <div class="text-center">
                  <div class="alert alert-danger" role="alert" style="display: {{ $errors->has('email_company') ? 'block' : 'none' }}">
                      {{$errors->first('email_company')}}
                  </div>
                  <div class="divider my-6" style="display: {{ $errors->has('email_company') ? 'none' : 'block' }}">
                    <div class="divider-text">or</div>
                  </div>
                  <!-- <p style="display: {{ $errors->has('email_company') ? 'none' : 'block' }}">- OR -</p> -->
                  <a style="display: {{ $errors->has('email_google_eror') ? 'none' : 'block' }}" href="{{url('redirect')}}" class="btn btn-danger rounded-pill w-100"><i class='bx bxl-google'></i> - Google Workspace</a>
              </div>
          </div>
        </div>
        <!-- /Login -->
      </div>
    </div>
    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->

    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{asset('/assets/js/main.js')}}"></script>

    <!-- Page JS -->

    <!-- Place this tag before closing body tag for github widget button. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>