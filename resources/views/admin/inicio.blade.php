@extends('admin.blank')


@section('content')

<div class="row">
  
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Inicio</h4>        
        
        <div class="row">



          <div class="col-xl-4 col-sm-6 col-12 "> 
            <div class="card shadow-sm p-3 mb-5 bg-body rounded">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <i class="fa fa-check-square primary font-large-2 float-left text-success" style="font-size: 60px"></i>
                    </div>
                    <div class="media-body text-right">
                      @php
                          $completado = DB::table('pedidos')->where('estado',6)->count();
                      @endphp
                      <h3>{{ $completado }}</h3>
                      <span>Pedidos completados</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-xl-4 col-sm-6 col-12 "> 
            <div class="card shadow-sm p-3 mb-5 bg-body rounded">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <i class="fa fa-truck primary font-large-2 float-left text-info" style="font-size: 60px"></i>
                    </div>
                    <div class="media-body text-right">
                      @php
                          $transito = DB::table('pedidos')->where('estado',5)->count();
                      @endphp
                      <h3>{{ $transito }}</h3>
                      <span>Pedidos en trancito</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="col-xl-4 col-sm-6 col-12 "> 
            <div class="card shadow-sm p-3 mb-5 bg-body rounded">
              <div class="card-content">
                <div class="card-body">
                  <div class="media d-flex">
                    <div class="align-self-center">
                      <i class="fa fa-building primary font-large-2 float-left text-primary" style="font-size: 60px"></i>
                    </div>
                    <div class="media-body text-right">
                      @php
                      $comercios = DB::table('comercios')->count();
                      @endphp
                      <h3>{{ $comercios }}</h3>
                      <span>Comercios registrados</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          


        </div>


        <div class="row mt-3">

          <h4 class="mb-4">Lista de movimientos de todos los paquetes</h4>
          @php
            $logs = DB::table('change_log_pedido')->join('pedidos','pedidos.id','=','change_log_pedido.id_pedido')->select('pedidos.sku','change_log_pedido.*')->get();
          @endphp
          <div class="table-responsive">
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th scope="col">SKU</th>
                <th scope="col">Acción</th>
                <th scope="col">Fecha</th>
                
              </tr>
            </thead>
            <tbody>
                @foreach ($logs as $lg)
                    <tr>
                      <td>{{ $lg->sku }}</td>
                      <td>{{ $lg->accion }}</td>
                      <td>{{ date('d/m/Y h:i:s a', strtotime($lg->created_at))}}</td>
                    </tr>
                @endforeach
            </tbody>
          </table>
          </div>
          
        </div>

      </div>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>

  $(document).ready( function () {
    $('#myTable').DataTable({
      "language": {"url":"https://cdn.datatables.net/plug-ins/1.12.1/i18n/es-ES.json"},
      "order" : [[ 2, 'desc' ]],
      "responsive": true,
      "rowReorder": {"selector": "td:nth-child(0)"},
    });
} );
</script>
@endpush