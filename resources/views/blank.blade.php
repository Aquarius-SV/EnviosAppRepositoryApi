<!DOCTYPE html>
<html lang="es" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ env('APP_NAME') }} | Envíos en Chalatenango</title>
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/img/favicons/favicon.ico') }}">
  <link rel="manifest" href="{{ asset('assets/img/favicons/manifest.json') }}">
  <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/mstile-150x150.png') }}">
  <meta name="theme-color" content="#ffffff">
  <link href="{{ asset('assets/css/theme.css') }}" rel="stylesheet" />
  
  @livewireStyles

</head>
<body>
  <main class="main" id="top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-4 d-block navbar-light-on-scroll"
      data-navbar-on-scroll="data-navbar-on-scroll">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="{{ asset('assets/img/gallery/logo.png') }}" height="60" alt="..." />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span
            class="navbar-toggler-icon"> </span></button>
        <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto pt-2 pt-lg-0 font-base">
            <li class="nav-item px-2 " data-anchor="data-anchor"><a class="nav-link fw-medium text-black" aria-current="page"
                href="#home">Inicio</a></li>
              <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link text-black" href="#envios">Envíos</a></li>
              <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link text-black" href="#aplicaciones">Aplicaciones</a>                                 
              <li class="nav-item px-2" ><a class="nav-link text-black" href="app/GPSTracker-new.apk" download="AQ-paqueteria.apk" rel="noopener noreferrer" target="_blank">Aplicación móvil</a>
            </li>
            
          </ul>
          <form class="ps-lg-5">
            @if (Auth::check())
            <a class="btn btn-primary order-1 order-lg-0" href="{{ url('/pedidos') }}">Pedidos</a>
            <a class="btn btn-primary order-1 order-lg-0" href="{{ url('/logout') }}">Cerrar sesión</a>            
            @else
            <a class="btn btn-primary order-1 order-lg-0" href="{{ url('/inicio-sesion') }}">Iniciar sesión</a>
            @endif
          </form>
        </div>
      </div>
    </nav>
    @yield('content')
    

    
      <footer class="text-center text-lg-start bg-light ">
        
        <section
          class="d-flex justify-content-center justify-content-lg-between p-4 border-bottom"
        >
          <!-- Left -->
          <div class="me-5 d-none d-lg-block">
            <span>Siguenos en nuestras redes sociales:</span>
          </div>
          <!-- Left -->
      
          <!-- Right -->
          <div>
            <a href="" class="m-2 text-reset" data-bs-toggle="tooltip" data-bs-placement="top" title="Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>            
            <a href="" class="m-2 text-reset" data-bs-toggle="tooltip" data-bs-placement="top" title="Instagram">
              <i class="fab fa-instagram"></i>
            </a>          
            <a href="" class="m-2 text-reset" data-bs-toggle="tooltip" data-bs-placement="top" title="Youtube">
              <i class="fab fa-youtube"></i>              
            </a>
          </div>
          <!-- Right -->
        </section>
        <!-- Section: Social media -->
      
        <!-- Section: Links  -->
        <section class="">
          <div class="container text-center text-md-start mt-5">
            <!-- Grid row -->
            <div class="row mt-3">
              <!-- Grid column -->
              <!--<div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
                
                <h6 class="text-uppercase fw-bold mb-4">
                  Por qué usar nuestros servicios
                </h6>
                <p>
                  Podemos apoyarte en el comercio electrónico, llevamos los paquetes del comercio al cliente final. 
                </p>
              </div>-->
              <!-- Grid column -->
      
              <!-- Grid column -->
              <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
                <!-- Links -->
                <h6 class="text-uppercase fw-bold mb-4">
                  Por qué usar nuestros servicios
                </h6>
                <p>
                  <a href="#!" class="text-reset">Como enviar un paquete</a>
                </p>
                <p>
                  <a href="#!" class="text-reset">Formas de pago</a>
                </p>
                <p>
                  <a href="#!" class="text-reset">Tarifas</a>
                </p>
               
              </div>
              <!-- Grid column -->
      
              <!-- Grid column -->
              <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
                <!-- Links -->
                <h6 class="text-uppercase fw-bold mb-4">
                  Quiénes somos
                </h6>
                <p>
                  <a href="#!" class="text-reset">Conócenos</a>
                </p>
                <p>
                  <a href="#!" class="text-reset">Aviso de privacidad</a>
                </p>
                <p>
                  <a href="#!" class="text-reset">Condiciones de uso</a>
                </p>
                <p>
                  <a href="#!" class="text-reset">Nuestros servicios</a>
                </p>
              </div>
              <!-- Grid column -->
      
              <!-- Grid column -->
              <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <!-- Links -->
                <h6 class="text-uppercase fw-bold mb-4">
                  Contactar
                </h6>
                <p>
                  <a href="#!" class="text-reset">Centro de soporte</a>
                </p>
                <p>
                  <a href="#!" class="text-reset">Contacto</a>
                </p>
              </div>

              <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
                <!-- Links -->
                <h6 class="text-uppercase fw-bold mb-4">
                  Comunidad 
                </h6>
                <p>
                  <a href="#!" class="text-reset">Facebook</a>
                </p>
                <p>
                  <a href="#!" class="text-reset">Youtube</a>
                </p>
              </div>
              <!-- Grid column -->
            </div>
            <!-- Grid row -->
          </div>
        </section>
        <!-- Section: Links  -->
      
        <!-- Copyright -->
        <div class="text-center p-4" style="background-color: rgba(0, 0, 0, 0.05);">
          Todos los derechos reservados &copy; <a class="text-reset fw-bold" href="https://aquariusit-sv.com">AquariusIT</a>, <span id="year-span"></span> 
          
        </div>
        <!-- Copyright -->
      </footer>
    
  </main>
  @livewireScripts

  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  <x-livewire-alert::scripts />
  
     
  <script src="{{ asset('vendors/@popperjs/popper.min.js') }}"></script>
  <script src="{{ asset('vendors/bootstrap/bootstrap.min.js') }}"></script>
  <script src="{{ asset('vendors/is/is.min.js') }}"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="{{ asset('vendors/fontawesome/all.min.js') }}"></script>
  <script src="{{ asset('assets/js/theme.js') }}"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&amp;family=Rubik:wght@300;400;500;600;700;800&amp;display=swap"
    rel="stylesheet">

    <script>
      var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
      var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
      });

      const d = new Date();
      let year = d.getFullYear();
      document.getElementById("year-span").innerHTML = year;
      
    </script>


</body>
</html>