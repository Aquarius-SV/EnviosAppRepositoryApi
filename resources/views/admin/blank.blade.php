<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ env('APP_NAME') }}| Envios en Chalatenango</title>
  <link rel="stylesheet" href="{{ asset('admin/vendors/typicons.font/font/typicons.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/vendors/css/vendor.bundle.base.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css"
   integrity="sha512-+EoPw+Fiwh6eSeRK7zwIKG2MA8i3rV/DGa3tdttQGgWyatG/SkncT53KHQaS5Jh9MNOT3dmFL0FjTY08And/Cw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
    integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
  
  @livewireStyles
  <link rel="stylesheet" href="{{ asset('admin/css/vertical-layout-light/style.css') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('admin/images/favicons/apple-touch-icon.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('admin/images/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/images/favicons/favicon-16x16.png') }}">
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/images/favicons/favicon.ico') }}">
  <link rel="manifest" href="{{ asset('admin/images/favicons/manifest.json') }}">
  
</head>
<body>
  <div class="container-scroller">
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

              @switch(Auth::user()->id_tipo_usuario)
                  @case(3)
                    <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#deliveryModal" onclick="Livewire.emit('asignRepartidor',@js(Auth::user()->id))">               
                      <i class="typcn typcn-user text-primary" ></i>
                      Perfil
                    </a>
                      @break
                  @case(2)
                      <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#profileModal" onclick="Livewire.emit('asignName',@js(Auth::user()->name))">               
                        <i class="typcn typcn-user text-primary" ></i>
                        Perfil
                      </a>
                      <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#direccionesListModal">               
                        <i class="typcn typcn-bookmark text-primary" ></i>
                        Direcciones
                      </a>
                      @break
                  @case(1)
                  @case(5)
                  <a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#profileModal" onclick="Livewire.emit('asignName',@js(Auth::user()->name))">               
                    <i class="typcn typcn-user text-primary" ></i>
                    Perfil
                  </a>
                  @break
                      
              @endswitch



              @if (Auth::user()->id_tipo_usuario == 3)
               
              @else
               
              @endif
             
              <hr>
              <a class="dropdown-item" href="{{ url('/logout') }}">
                <i class="typcn typcn-arrow-back text-primary"></i>
                Cerrar sesión
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
    @livewire('perfil.perfil-component')
    @if (Auth::user()->id_tipo_usuario == 3)
        
    @livewire('perfil.delivery-component',['usuario'=>Auth::user()->id])
        
    @endif
   
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item">
            <div class="d-flex sidebar-profile">
              <div class="sidebar-profile-image">
                <img src="{{ asset('admin/images/faces/profile.png') }}" alt="image">
                <span class="sidebar-status-indicator"></span>
              </div>
              <div class="sidebar-profile-name ">
                
                <p class="sidebar-designation">
                  Bienvenido
                </p>
                <p class="sidebar-name text-black">
                  {{ Auth::user()->name }}
                </p>
              </div>
            </div>
            <p class="sidebar-menu-title">Menú</p>
          </li>

          @switch(Auth::user()->id_tipo_usuario)
              @case(2)
              <li class="nav-item" id="inicio">
                <a class="nav-link " href="{{ url('/pedidos') }}">
                  <i class="typcn typcn-home menu-icon"></i>
                  <span class="menu-title">Inicio</span>
                </a>
              </li>
              
               {{--  <li class="nav-item" id="pendientes">
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
                  <span class="menu-title">Pedidos rechazados</span>
                </a>
              </li> --}}
              <li class="nav-item" id="devoluciones">
                <a class="nav-link" href="{{ url('/pedidos/devoluciones') }}">
                  <i class="typcn typcn-arrow-loop menu-icon"></i>
                  <span class="menu-title">Devoluciones</span>
                </a>
              </li>

              <li class="nav-item" id="direcciones-clientes">
                <a class="nav-link" href="{{ url('/pedidos/direcciones-clientes') }}">
                  <i class="typcn typcn-contacts menu-icon"></i>
                  <span class="menu-title">Direcciones de clientes</span>
                </a>
              </li>

              <li class="nav-item" id="mis-direcciones">
                <a class="nav-link" href="{{ url('/pedidos/mis-direcciones') }}">
                  <i class="typcn typcn-bookmark menu-icon"></i>
                  <span class="menu-title">Mis direcciones</span>
                </a>
              </li>



                  @break
              @case(3)
              <li class="nav-item" id="mis-Rpedidios">
                <a class="nav-link" href="{{ url('/mis-pedidos') }}">
                  <i class="typcn typcn-clipboard menu-icon"></i>
                  <span class="menu-title">Mis pedidos</span>
                </a>
              </li>
                  @break
                  @case(1)

                  <li class="nav-item" id="menu-administracion-li">
                    <a class="nav-link" data-toggle="collapse" href="#administracion-menu-div" aria-expanded="false" aria-controls="administracion-menu-div">
                      <i class="typcn typcn-briefcase menu-icon"></i>
                      <span class="menu-title">Administración</span>
                      <i class="typcn typcn-chevron-right menu-arrow"></i>
                    </a>
                    <div class="collapse" id="administracion-menu-div">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item" id="admin-inicio">
                          <a class="nav-link" href="{{ url('administracion/') }}">
                            <i class="typcn typcn-home menu-icon"></i>
                            <span class="menu-title">Inicio</span>
                          </a>
                        </li>
                        <li class="nav-item" id="admin-repartidores">
                          <a class="nav-link" href="{{ url('administracion/repartidores') }}">
                            <i class="typcn typcn-user menu-icon"></i>
                            <span class="menu-title">Repartidores</span>
                          </a>
                        </li>
                        <li class="nav-item" id="admin-pedidos">
                          <a class="nav-link" href="{{ url('administracion/pedidos') }}">
                            <i class="typcn typcn-clipboard menu-icon"></i>
                            <span class="menu-title">Pedidos</span>
                          </a>
                        </li>
                        <li class="nav-item" id="admin-comercios">
                          <a class="nav-link" href="{{ url('administracion/comercios') }}">
                            <i class="typcn typcn-briefcase menu-icon"></i>
                            <span class="menu-title">Comercios</span>
                          </a>
                        </li>
      
                        <li class="nav-item" id="admin-repartos">
                          <a class="nav-link" href="{{ url('administracion/puntos-de-reparto') }}">
                            <i class="typcn typcn-compass menu-icon"></i>
                            <span class="menu-title">Puntos de departo</span>
                          </a>
                        </li>
      
                        <li class="nav-item" id="admin-users-repartos">
                          <a class="nav-link" href="{{ url('administracion/administradores-puntos-reparto') }}">
                            <i class="typcn typcn-user menu-icon"></i>
                            <span class="menu-title">Administradores de puntos</span>
                          </a>
                        </li>

                      </ul>
                    </div>
                  </li>

                  <li class="nav-item" id="menu-pedidos-li">
                    <a class="nav-link" data-toggle="collapse" href="#pedidos-menu-div" aria-expanded="false" aria-controls="pedidos-menu-div">
                      <i class="typcn typcn-clipboard menu-icon"></i>
                      <span class="menu-title">Pedidos</span>
                      <i class="typcn typcn-chevron-right menu-arrow"></i>
                    </a>
                    <div class="collapse" id="pedidos-menu-div">
                      <ul class="nav flex-column sub-menu">
                        <li class="nav-item" id="creacion-pedidos-admin">
                          <a class="nav-link" href="{{ url('/administracion/creacion-pedidos') }}">
                            <i class="typcn typcn-clipboard menu-icon"></i>
                            <span class="menu-title">Lista de pedido</span>
                          </a>
                        </li>
                        <li class="nav-item" id="direcciones-recogida-admin">
                          <a class="nav-link" href="{{ url('/administracion/direcciones-recogida') }}">
                            <i class="typcn typcn-filter menu-icon"></i>
                            <span class="menu-title">Direcciones de recogida</span>
                          </a>
                        </li>
                        <li class="nav-item" id="datos-cliente-admin">
                          <a class="nav-link" href="{{ url('/administracion/datos-cliente') }}">
                            <i class="typcn typcn-business-card menu-icon"></i>
                            <span class="menu-title">Datos del comercio</span>
                          </a>
                        </li>

                        <li class="nav-item" id="direccion-cliente-final-admin">
                          <a class="nav-link" href="{{ url('/administracion/direcciones-clientes-finales') }}">
                            <i class="typcn typcn-flag menu-icon"></i>
                            <span class="menu-title">Direcciones de clientes</span>
                          </a>
                        </li>

                        <li class="nav-item" id="pedidos-puntos-admin">
                          <a class="nav-link" href="{{ url('/administracion/pedidos-puntos-repartos') }}">
                            <i class="typcn typcn-briefcase menu-icon"></i>
                            <span class="menu-title">Pedidos de punto</span>
                          </a>
                        </li>

                      
                      </ul>
                    </div>
                  </li>

                  @break
                  @case(5)
                  <li class="nav-item" id="puntos">
                    <a class="nav-link" href="{{ url('puntos-repartos/') }}">
                      <i class="typcn typcn-clipboard menu-icon"></i>
                      <span class="menu-title">En movimiento</span>
                    </a>
                  </li>

                  <li class="nav-item" id="asignacion">
                    <a class="nav-link" href="{{ url('puntos-repartos/asignacion') }}">
                      <i class="typcn typcn-arrow-minimise menu-icon"></i>
                      <span class="menu-title">Asignación de pedido</span>
                    </a>
                  </li>
                  <li class="nav-item" id="puntos-completados">
                    <a class="nav-link" href="{{ url('puntos-repartos/completados') }}">
                      <i class="typcn typcn-input-checked menu-icon"></i>
                      <span class="menu-title">Completados</span>
                    </a>
                  </li>

                 
                  @break                                
          @endswitch        
        </ul>
      </nav>
      
      <div class="main-panel">
        <div class="content-wrapper">
          @yield('content')
        </div>
        <footer class="footer">
          <div class="d-sm-flex justify-content-center justify-content-sm-between">
          </div>
        </footer>
      </div>
    </div>
  </div>
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
 
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"
  integrity="sha512-IsNh5E3eYy3tr/JiX2Yx4vsCujtkhwl7SLqgnwLNgf04Hrt9BT9SXlLlZlWx+OK4ndzAoALhsMNcCmkggjZB1w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>  
  <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script> 
  <script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
    })



   


  </script>
  @stack('scripts')
</body>

</html>