<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>CelestialUI Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="{{ asset('admin/vendors/typicons.font/font/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

  @livewireStyles
  <link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('admin/images/favicon.png') }}" />

</head>

<body>

  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo" href="{{ url("/pedidos") }}"><img src="{{ asset('admin/images/logo.svg') }}"
            alt="logo" /></a>
        <a class="navbar-brand brand-logo-mini" href="{{ url("/pedidos") }}"><img
            src="{{ asset('admin/images/logo-mini.svg') }}" alt="logo" /></a>
        <button class="navbar-toggler navbar-toggler align-self-center d-none d-lg-flex" type="button"
          data-toggle="minimize">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">

        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item dropdown d-flex">

          <li class="nav-item dropdown  d-flex">
             @livewire('notificacion.notificacion-component')
          </li>
        
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle  pl-0 pr-0" href="#" data-toggle="dropdown" id="profileDropdown">
              <i class="typcn typcn-user-outline mr-0"></i>

            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">

              <a class="dropdown-item" href="{{ url('/logout') }}">
                <i class="typcn typcn-power text-primary"></i>
                Cerrar Sesion
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="typcn typcn-th-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_settings-panel.html -->

      <!-- partial -->
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <div class="d-flex sidebar-profile">
              <div class="sidebar-profile-image">
                <img src="{{ asset('admin/images/faces/profile.png') }}" alt="image">
                <span class="sidebar-status-indicator"></span>
              </div>
              <div class="sidebar-profile-name ">
                <p class="sidebar-name text-black">
                  {{ Auth::user()->name }}
                </p>
                <p class="sidebar-designation">
                  Bienvenido
                </p>
              </div>
            </div>

            <p class="sidebar-menu-title">Menú</p>
          </li>
          @if (Auth::user()->id_tipo_usuario == 2)
          <li class="nav-item" id="inicio">
            <a class="nav-link " href="{{ url('/pedidos') }}">
              <i class="typcn typcn-home menu-icon"></i>
              <span class="menu-title">Inicio</span>
            </a>
          </li>
          <li class="nav-item" id="pendientes">
            <a class="nav-link" href="{{ url('/pedidos/pendientes') }}">
              <i class="typcn typcn-download menu-icon"></i>
              <span class="menu-title">Pedidos pendientes</span>
            </a>
          </li>
          <li class="nav-item" id="completados">
            <a class="nav-link" href="{{ url('/pedidos/completados') }}">
              <i class="typcn typcn-tick menu-icon"></i>
              <span class="menu-title">Pedidos completados</span>
            </a>
          </li>
          <li class="nav-item" id="rechazados">
            <a class="nav-link" href="{{ url('/pedidos/rechazados') }}">
              <i class="typcn typcn-times menu-icon"></i>
              <span class="menu-title">Pedidos Rechazados</span>
            </a>
          </li>
          @else
          <li class="nav-item" id="mis-Rpedidios">
            <a class="nav-link" href="{{ url('/mis-pedidos') }}">
              <i class="typcn typcn-clipboard menu-icon"></i>
              <span class="menu-title">Mis Pedidos</span>
            </a>
          </li>
          @endif




        </ul>

      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">


          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  @livewireScripts
  <script src="https://code.iconify.design/2/2.2.1/iconify.min.js"></script>
  <script src="{{ asset('admin/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <x-livewire-alert::scripts />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
  </script>
  <script src="{{ asset('admin/js/off-canvas.js') }}"></script>
  <script src="{{ asset('admin/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('admin/js/template.js') }}"></script>
  <script src="{{ asset('admin/js/settings.js') }}"></script>
  <script src="{{ asset('admin/js/active.js') }}"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
  <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })
  </script>
  @stack('scripts')
</body>

</html>