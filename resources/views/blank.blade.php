<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">


  <!-- ===============================================-->
  <!--    Document Title-->
  <!-- ===============================================-->
  <title>traffico | Envios en Chalatenango</title>


  <!-- ===============================================-->
  <!--    Favicons-->
  <!-- ===============================================-->
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicons/favicon.ico') }}">
  <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
  <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/mstile-150x150.png') }}">
  <meta name="theme-color" content="#ffffff">


  <!-- ===============================================-->
  <!--    Stylesheets-->
  <!-- ===============================================-->
  <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" />

</head>


<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-4 d-block"
      data-navbar-on-scroll="data-navbar-on-scroll">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('assets/img/gallery/logo.png') }}" height="24" alt="..." />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
            class="navbar-toggler-icon"> </span></button>
        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base">
            <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link fw-medium active" aria-current="page"
                href="#home">Inicio</a></li>
            <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link" href="#aboutUs">Envios</a></li>
            <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link" href="#services">Aplicaciones</a>
            </li>
            <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link" href="#faq">Faq</a></li>
          </ul>
          <form class="ps-lg-5">
            @if (Auth::check())
            
            <a class="btn btn-primary order-1 order-lg-0" href="{{ url('/logout') }}">Cerrar Sesion</a>

            <a class="btn btn-primary order-1 order-lg-0" href="{{ url('/pedidos') }}">Pedidos</a>
            
            @else
            <a class="btn btn-primary order-1 order-lg-0" href="{{ url('/inicio-sesion') }}">Iniciar Sesion</a>
            @endif

          </form>
        </div>
      </div>
    </nav>

    @yield('content')





    <!-- ============================================-->
    <!-- <section> begin ============================-->
    <section class="py-5">

      <div class="container">
        <div class="row flex-center">
          <div class="col-md-6 col-xl-8 order-0">
            <p class="text-center text-md-start">Todos los derechos reservados &copy; AquariusIT, 2021-2022</p>
          </div>
          <div class="col-md-6 col-xl-3 order-1">
            <p class="text-center text-md-end text-xl-start">Hecho por
              <a class="text-1000 fw-bold" href="https://themewagon.com/" target="_blank">AquariusIT </a>
            </p>

          </div>
        </div>
      </div>
      <!-- end of .container-->

    </section>
    <!-- <section> close ============================-->
    <!-- ============================================-->


  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->




  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
  <script src="{{ asset('vendors/@popperjs/popper.min.js') }}"></script>
  <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('vendors/is/is.min.js') }}"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>

  <link
    href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&amp;family=Rubik:wght@300;400;500;600;700;800&amp;display=swap"
    rel="stylesheet">
</body>

</html>