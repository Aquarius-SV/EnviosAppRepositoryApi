@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Todos los pedidos</h4>
        @livewire('pedidos.modal-update-component')
        @livewire('pedidos.modal-pedido-component')
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
                <th>Estado</th>
                <th>QR</th>
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
                  @switch($pedido->estado)
                  @case(0)
                  <label class="badge badge-secondary">Pendiente de aceptación</label>
                  @break
                  @case(1)
                  <label class="badge badge-info">Pedido aceptado</label>
                  @break
                  @case(2)
                    <label class="badge badge-secondary">Pedido en preparación</label>
                  @break
                  @case(3)
                  <label class="badge badge-secondary">Pendiente de recogida</label>
                  @break
                  @case(4)
                  <label class="badge badge-info">Paquete recogido</label>
                  @break
                  @case(5)
                  <label class="badge badge-info">En trancito</label>
                  @break
                  @case(6)
                  <label class="badge badge-success">Entregado</label>
                  @break
                  @case(7)
                  <label class="badge badge-danger">Rechazado</label>
                  @break
                  @case(8)
                  <label class="badge badge-danger">No entregado</label>
                  @break
                  @endswitch
                </td>
                <td>
                  <div data-bs-toggle="tooltip" data-bs-placement="top"
                  title="Click para descargar" >
                    <a href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate(json_encode(['id' =>  $pedido->id ]))); !!} " download="qr-pedido-{{ $pedido->id }}">
                      <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate(json_encode(['id' =>  $pedido->id ]))); !!} ">
                    </a>
                    
                  </div>
                </td>
                <td class="text-center">
                  
                  <button type="button" @if($pedido->estado === 6 || $pedido->estado === 7) disabled @else @endif   class="btn" data-toggle="modal" data-target="#UpdateModal" onclick="Livewire.emit('asingPedido',@js($pedido))">
                    <i class="typcn typcn-edit mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title=" @if($pedido->estado === 6 || $pedido->estado === 7) Acción deshabilitada @else Editar pedido @endif"></i>
                  </button>

                  <button type="button" class="btn" data-toggle="modal" data-target="#detalleModal" onclick="Livewire.emit('assignDetalle',@js($pedido), @js($pedido->id_usuario))">
                    <i class="typcn typcn-clipboard mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Detalle de pedido"></i>
                  </button>

                  @if ($pedido->estado === 1 || $pedido->estado === 2 )
                  @livewire('pedidos.modal-estados-component')
                  <button type="button" class="btn" data-toggle="modal" data-target="#stateModal" onclick="Livewire.emit('asingId',@js($pedido))">
                    <i class="typcn typcn-info-large-outline mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Estados del pedido"></i>
                  </button>
                  @elseif ($pedido->estado === 7)
                  @livewire('pedidos.modal-asign-component')
                  <button type="button" class="btn" data-toggle="modal" data-target="#AsignModal" onclick="Livewire.emit('asingIdPedido',@js($pedido->id))">
                    <i class="typcn typcn-arrow-repeat mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Reasignar repartidor"></i>
                  </button>
                  @endif
                  <button type="button" class="btn" @if($pedido->estado === 6 || $pedido->estado === 7) disabled @else @endif>
                    <i class="typcn typcn-cancel mx-0 text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="@if($pedido->estado === 0 ||$pedido->estado === 1 ) Cancelar pedido  @else Acción deshabilitada  @endif "></i>
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

  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
  })

 
</script>

    

@endpush