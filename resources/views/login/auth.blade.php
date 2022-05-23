<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>traffico || @yield('title')</title>


    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicons/favicon.ico') }}">
  <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
  <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/mstile-150x150.png') }}">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <meta name="theme-color" content="#ffffff">
    <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" />
    @livewireStyles
    <style>
        .gradient-custom-2 {
         /*fallback for old browsers */
        background: #ffcd49;

         /*Chrome 10-25, Safari 5.1-6 */
        background: -webkit-linear-gradient(to right, #F95C19, #ee7724, #ff9b4f, #ffcd49);

         /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: linear-gradient(to right, #F95C19, #ee7724, #ff9b4f, #ffcd49);
        }

        @media (min-width: 768px) {
        .gradient-form-login {
            height: 100vh !important;
        }
        .gradient-form-register {
            height: 100% !important;
        }
        }
        @media (min-width: 769px) {
        .gradient-custom-2 {
            border-top-right-radius: .3rem;
            border-bottom-right-radius: .3rem;
        }
        }
    </style>
</head>
<body>
    



    @yield('content')
    

    @livewireScripts
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
    <x-livewire-alert::scripts />
    <script src="{{ asset('vendors/@popperjs/popper.min.js') }}"></script>
    <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/theme.js') }}"></script>
    <script>
        function showPassword() {
            var password = document.getElementById("password");
            var confirm_password = document.getElementById("confirm_password");
            if (password.type === "password" && confirm_password.type === "password") {
                password.type = "text";
                confirm_password.type = "text";
            } else {
                password.type = "password";
                confirm_password.type = "password";
            }
        }
    </script>
</body>
</html>