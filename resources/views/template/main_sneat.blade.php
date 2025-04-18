<!DOCTYPE html>
	<html 
		lang="en"
		<?php
	  	if (Auth::user()->is_mode == 1) {
	  		echo 'class="dark-style layout-navbar-fixed layout-menu-fixed layout-compact"';
	  	}else{
	  		echo 'class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"';
	  	}
	  ?>
	  dir="ltr"
	  data-theme="theme-default"
	  data-assets-path="../../assets/"
	  data-template="vertical-menu-template"
	  <?php
	  	if (Auth::user()->is_mode == 1) {
	  		echo 'data-style="dark"';
	  	}else{
	  		echo 'data-style="light"';
	  	}
	  ?>
	>
	<head>
	<meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
	<title>
		@hasSection('tittle')
			SIMS - @yield('tittle')
		@else
			SIP - SIMS
		@endif
	</title>
	<!-- PWA  -->
	<!-- <link rel="manifest" href="{{ asset('/manifest.json') }}"> -->
	<!-- Hotjar Tracking Code for SIMS App - prod -->
	<!-- Favicon -->
		<style type="text/css">
			/* Default to hide the elements on small screens */
			.page-name-header {
			    visibility: hidden!important;
			}

			.user-name-header {
				display: none!important;
			}

			.user-name {
				white-space: nowrap;overflow: hidden;text-overflow: ellipsis;display: block;max-width: 18ch;
			}

			/* Show the elements on larger screens */
			@media (min-width: 768px) {
			    .user-name-header{
						display: block!important;
			    } 

			    .page-name-header {
			      visibility: visible!important;
			    }

			    .user-name {
						white-space: nowrap;overflow: hidden;text-overflow: ellipsis;display: block;max-width: 25ch;
					}
			}
		</style>
    <link rel="icon" type="image/x-icon" href="{{url('img/siplogooke.webp')}}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<!--     <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet" /> -->

    <!-- Icons -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/boxicons.css')}}" />
    <!-- <link rel="stylesheet" href="{{asset('assets/vendor/fonts/fontawesome.css')}}" /> -->
    <!-- <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'"> -->
    <link rel="stylesheet" href="{{asset('assets/vendor/fonts/flag-icons.css')}}" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{asset('assets/css/demo.css')}}" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/typeahead-js/typeahead.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/apex-charts/apex-charts.css')}}" />

    <!--spink block UI-->
    <link rel="stylesheet" href="{{asset('assets/vendor/libs/spinkit/spinkit.css')}}" />

    <!-- Helpers -->
    <script src="{{asset('assets/vendor/js/helpers.js')}}"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{asset('assets/vendor/js/template-customizer.js')}}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{asset('assets/js/config.js')}}"></script>

		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
    <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>

<!-- 	<script>
	    (function(h,o,t,j,a,r){
	        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
	        h._hjSettings={hjid:3568234,hjsv:6};
	        a=o.getElementsByTagName('head')[0];
	        r=o.createElement('script');r.async=1;
	        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
	        a.appendChild(r);
	    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
	</script> --> 
	@yield('head_css')
</head>
@if(isset($sidebar_collapse))
<body>
@else
<body>
@endif
	<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container form-block">
      @section('header')
			@include('template.header_sneat')
			@show

			@section('sidebar')
			@include('template.sidebar_sneat')
			@show
			<div class="layout-page">
				<nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
            <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
              <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                <i class="bx bx-menu bx-md"></i>
              </a>
            </div>

            <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            	<div class="navbar-nav align-items-center page-name-header">
                <div class="nav-item d-flex align-items-center">
                	@hasSection('pageName')
										@yield('pageName')
									@endif
                </div>
              </div>

              <ul class="navbar-nav flex-row align-items-center ms-auto">
              	<!-- Style Switcher -->
                <li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
                  <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <i class="bx bx-md"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                        <span><i class="bx bx-sun bx-md me-3"></i>Light</span>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                        <span><i class="bx bx-moon bx-md me-3"></i>Dark</span>
                      </a>
                    </li>
            <!--         <li>
                      <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                        <span><i class="bx bx-desktop bx-md me-3"></i>System</span>
                      </a>
                    </li> -->
                  </ul>
                </li>
                <!-- / Style Switcher-->

                <!-- Place this tag where you want the button to render. -->
                <li class="nav-item lh-1 me-4 user-name-header">
                    {{ Auth::User()->name }}
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                  <a
                    class="nav-link dropdown-toggle hide-arrow p-0"
                    href="javascript:void(0);"
                    data-bs-toggle="dropdown">
                    <div class="avatar avatar-online">
                    	@if(Auth::User()->avatar != NULL)
				          <img src="{{Auth::User()->avatar}}" class="w-px-40 h-auto rounded-circle">
						        @else
						          @if(Auth::User()->gambar == NULL || Auth::User()->gambar == "-")
						            <img src="{{asset('image/default-user.png')}}" class="w-px-40 h-auto rounded-circle" alt="User Image">
						          @else
						            <img src="{{asset('image') . '/' . Auth::User()->gambar}}" class="w-px-40 h-auto rounded-circle" alt="User Image">
						          @endif
						        @endif
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                      <a class="dropdown-item" href="#">
                        <div class="d-flex">
                          <div class="flex-shrink-0 me-3">
                            <div class="avatar avatar-online">
                            	@if(Auth::User()->avatar != NULL)
						          			<img src="{{Auth::User()->avatar}}" class="w-px-40 h-auto rounded-circle">
										        @else
										          @if(Auth::User()->gambar == NULL || Auth::User()->gambar == "-")
										            <img src="{{asset('image/default-user.png')}}" class="w-px-40 h-auto rounded-circle" alt="User Image">
										          @else
										            <img src="{{asset('image') . '/' . Auth::User()->gambar}}" class="w-px-40 h-auto rounded-circle" alt="User Image">
										          @endif
										        @endif
                            </div>
                          </div>
                          <div class="flex-grow-1">
                            <h6 class="mb-0 user-name" >{{ Auth::User()->name }}</h6>
                            <small class="text-muted">{{$initView['userRole']->name}}</small>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                      <a class="dropdown-item" href="{{url('profile_user')}}">
                        <i class="bx bx-user bx-md me-3"></i><span>My Profile</span>
                      </a>
                    </li>
                    <li>
                      <div class="dropdown-divider my-1"></div>
                    </li>
                    <li>
                  		<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="bx bx-power-off bx-md me-3"></i><span>Log Out</span></a>
											<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
												@csrf
												<input type="hidden" name="nik" value="{{Auth::User()->nik}}">
											</form>
                    </li>
                  </ul>
                </li>
                <!--/ User -->
              </ul>
            </div>
        </nav>
				<div class="content-wrapper">
					@yield('content')

					@section('footer')
						@include('template.footer_sneat')
					@show
          <div class="content-backdrop fade"></div>
				</div>
			</div>
		</div>
	</div>
	@section('scriptNotificationHeader')
	@show
	@section('scriptNotificationSidebar')
	@show
	@yield('scriptImport')
	<!-- <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script> -->
		<!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
    <!-- <script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script> -->
    <script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
    <script src="{{asset('assets/vendor/js/menu.js')}}"></script>

    <!-- Vendors JS -->
    <script src="{{asset('assets/vendor/libs/block-ui/block-ui.js')}}"></script>
    <script src="{{asset('assets/js/extended-ui-blockui.js')}}"></script>

    <!-- Main JS -->
    <script src="{{asset('assets/js/main.js')}}"></script>

    <!-- Page JS -->
		<script>
			$(document).ready(function () {
				$(".activeable_group").has('a[href="' + location.protocol + '//' + location.host + location.pathname + '"]').addClass('active')
				$(".activeable_menu").has('a[href="' + location.protocol + '//' + location.host + location.pathname + '"]').addClass('active')
			})

			// if (window.Helpers.isCollapsed()) {
		  //   document.querySelector('.avatar-lg').classList.remove('avatar-online');
		  // }

		  if ($(".layout-menu-collapsed").is(":visible")) {
		  	document.querySelector('.menu-block').classList.remove('d-flex');
        document.querySelector('.menu-block').style.display = "none";
		  }
		</script>
<!-- 	<script src="{{ asset('/sw.js') }}"></script>
	<script>
	   if ("serviceWorker" in navigator) {
	      // Register a service worker hosted at the root of the
	      // site using the default scope.
	      navigator.serviceWorker.register("/sw.js").then(
	      (registration) => {
	         console.log("Service worker registration succeeded:", registration);
	      },
	      (error) => {
	         console.error(`Service worker registration failed: ${error}`);
	      },
	    );
	  } else {
	     console.error("Service workers are not supported.");
	  }
	</script> -->
	@yield('script')
</body>
</html>
