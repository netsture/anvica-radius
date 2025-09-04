   <!DOCTYPE html>

   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <meta http-equiv="X-UA-Compatible" content="ie=edge">
       <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
       <meta name="author" content="NobleUI">
       <meta name="keywords"
           content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

       <title>Anvica Hotspot Login</title>

       <style type="text/css">
           .authlogin-side-wrapper {
               width: 100%;
               height: 100%;
               background-image: url({{ asset('images/admin/login.png') }});
           }
       </style>

       <!-- Fonts -->
       <link rel="preconnect" href="https://fonts.googleapis.com">
       <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
       <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"
           rel="stylesheet">
       <!-- End fonts -->

       <!-- core:css -->
       <link rel="stylesheet" href="{{ asset('vendors/core/core.css') }}">
       <!-- endinject -->

       <!-- Plugin css for this page -->
       <!-- End plugin css for this page -->

       <!-- inject:css -->
       <link rel="stylesheet" href="{{ asset('fonts/feather-font/css/iconfont.css') }}">
       <link rel="stylesheet" href="{{ asset('vendors/flag-icon-css/css/flag-icon.min.css') }}">
       <!-- endinject -->

       <!-- Layout styles -->
       <link rel="stylesheet" href="{{ asset('css/demo1/style.css') }}">
       <!-- End layout styles -->

       <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" />

       <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">




   </head>

   <body>
       <div class="main-wrapper">
           <div class="page-wrapper full-page">
               <div class="page-content d-flex align-items-center justify-content-center">

                   <div class="row w-100 mx-0 auth-page">
                       <div class="col-md-8 col-xl-6 mx-auto">
                           <div class="card">
                               <div class="row">
                                   <div class="col-md-4 pe-md-0">
                                       <div class="authlogin-side-wrapper">

                                       </div>
                                   </div>
                                   <div class="col-md-8 ps-md-0">
                                       <div class="auth-form-wrapper px-4 py-5">
                                           <a href="#" class="noble-ui-logo logo-light d-block mb-2">Anvica <span>Hotspot</span> <span>Login</span></a>
                                           <h5 class="text-muted fw-normal mb-4">Welcome back! Log in to your account.</h5>
                                           <form class="forms-sample" method="POST" action="{{ route('login') }}">
                                               @csrf
                                               <div class="mb-3">
                                                   <label for="login" class="form-label">Username/Email/Phone</label>
                                                   <input type="text" name="login" class="form-control"
                                                       id="login" placeholder="login">
                                               </div>
                                               <div class="mb-3">
                                                   <label for="userPassword" class="form-label">Password</label>
                                                   <input type="password" class="form-control" id="password"
                                                       name="password" autocomplete="current-password"
                                                       placeholder="Password">
                                               </div>
                                               <div class="form-check mb-3">
                                                   <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                                                   <label class="form-check-label" for="remember_me">
                                                       Remember me
                                                   </label>
                                               </div>
                                               <div>
                                                   <button type="submit"
                                                       class="btn btn-outline-primary btn-icon-text mb-2 mb-md-0">
                                                       Login

                                                   </button>
                                               </div>
                                               {{-- <a href="register.html" class="d-block mt-3 text-muted">Not a user? Sign up</a> --}}
                                           </form>


                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>

               </div>
           </div>
       </div>

       <!-- core:js -->
       <script src="{{ asset('vendors/core/core.js') }}"></script>
       <!-- endinject -->

       <!-- Plugin js for this page -->
       <!-- End plugin js for this page -->

       <!-- inject:js -->
       <script src="{{ asset('vendors/feather-icons/feather.min.js') }}"></script>
       <script src="{{ asset('js/template.js') }}"></script>
       <!-- endinject -->

       <!-- Custom js for this page -->
       <!-- End custom js for this page -->

       <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

       <script>
           @if (Session::has('message'))
               var type = "{{ Session::get('alert-type', 'info') }}"
               switch (type) {
                   case 'info':
                       toastr.info(" {{ Session::get('message') }} ");
                       break;

                   case 'success':
                       toastr.success(" {{ Session::get('message') }} ");
                       break;

                   case 'warning':
                       toastr.warning(" {{ Session::get('message') }} ");
                       break;

                   case 'error':
                       toastr.error(" {{ Session::get('message') }} ");
                       break;
               }
           @endif
       </script>

   </body>

   </html>
