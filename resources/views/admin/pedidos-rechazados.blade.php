@extends('admin.blank')


@section('content')

<div class="row">

  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pedidos rechazados por los repartidores</h4>
         
        <div class="table-responsive">
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th>Repartidor</th>
                <th>Dirección de recogida</th>
                <th>Dirección de entrega</th>
                
              </tr>
            </thead>
            <tbody>
              @foreach ($allp as $pedido)
              <tr>
                @php
                    $repartidor = DB::table('users')->select('name')->where('id',$pedido->id_usuario)->first();
                @endphp
                <td>
                  {{ $repartidor->name }}
                </td>
                <td>{{ $pedido->direccion_recogida }}</td>
                <td>{{ $pedido->direccion_entrega }}</td>
               
                
              </tr>
              @endforeach
              
            </tbody>
          </table>
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
    "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
  });
  } );
</script>
@endpush