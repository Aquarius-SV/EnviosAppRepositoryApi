@extends('admin.blank')


@section('content')

<div class="row">

  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pedidos completados y entregados</h4>
        @livewire('pedidos.detalle-modal-component')
        <div class="table-responsive">
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th class="text-center">No</th>
                <th>Repartidor</th>
                <th>Dirección de recogida</th>
                <th>Dirección de entrega</th>
                <th class="text-center">Teléfono del cliente</th>
                <th>Peso</th>                
                <th class="text-center">Fragil</th>          
                <th class="text-center">Acciones</th>
                
                
              </tr>
            </thead>
            <tbody>
              @foreach ($allp as $pedido)
              <tr>
                @php
                    $repartidor = DB::table('users')->select('name')->where('id',$pedido->id_usuario)->first();
                @endphp
                  <td class="text-center">
                    {{ $pedido->id }}
                  </td>
                  <td>
                    {{ $repartidor->name }}
                  </td>
                  <td>{{ $pedido->direccion_recogida }}</td>
                  <td>{{ $pedido->direccion_entrega }}</td>
                  <td class="text-center">{{ $pedido->tel_cliente }}</td>
                  <td>{{ $pedido->peso }}</td>
                  
                  <td class="text-center">
                    @if ($pedido->fragil == 0)
                        No
                    @else
                        Si
                    @endif
                  </td>   
                  <td>
                    <button type="button" class="btn" data-toggle="modal" data-target="#detalleModal" onclick="Livewire.emit('assignDetalle',@js($pedido), @js($pedido->id_usuario))">
                      <i class="typcn typcn-clipboard mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Detalle de pedido"></i>
                    </button>
                  </td>       
               
                
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