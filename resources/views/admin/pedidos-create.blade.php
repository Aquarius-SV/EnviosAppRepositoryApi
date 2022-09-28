@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">       
        <h4 class="card-title">Todos los pedidos</h4>
                  
        @livewire('pedidos.qr-pedido')
        @livewire('admin.pedido-component')
        @livewire('admin.detalle-pedido')
        <div class="table-responsive">
          <table  id="myTable" class="display nowrap table responsive" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">SKU</th>
                <th class="text-start">Comercio</th>
                <th>Repartidor</th>               
                <th class="text-start">Cliente</th>
                <th class="text-start">WhatsApp</th>                                              
                <th>Estado</th>
                <th class="text-center">QR cliente</th>
                <th class="text-center">QR repartidor</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>                         
              @foreach ($allp as $pedido)
              <tr>
                @php
                $repartidor = DB::table('users')->join('repartidores','repartidores.id_usuario','=','users.id')->where('repartidores.id',$pedido->id_repartidor)->value('users.name');
                @endphp
                <td class="text-center">
                  {{ $pedido->sku }}
                </td>
                <td>{{ $pedido->comercio }}</td>
                <td>
                  {{ $repartidor }}
                </td>
                <td class="text-start">
                  {{ $pedido->nombre }}
                 </td>
                <td class="text-start">{{ $pedido->numero_whatsapp }}</td>                               
                <td>
                  @switch($pedido->pedido_estado)
                  @case(0)
                  <label class="badge badge-info">Pendiente de aceptación</label>
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
                  @case(9)
                  <label class="badge badge-info">Rumbo al punto de reparto</label>
                  @break
                  @case(10)
                  <label class="badge badge-success">Entregado al punto de reparto</label>
                  @break

                  @case(11)
                  <label class="badge badge-warning text-white">Pendiente de devolución</label>
                  @break
                  @case(12)
                  <label class="badge badge-success">Devolución a punto de reparto</label>
                  @break

                  @case(13)
                  <label class="badge badge-success">Devolución a comercio</label>
                  @break
                  @endswitch
                </td>
                <td class="text-center">
                  <div data-bs-toggle="tooltip" data-bs-placement="top"
                  title="Click para descargar" >
                    <a class="btn" href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate(json_encode(['id' =>  $pedido->pedido_id ]))); !!} " download="qr-pedido-{{ $pedido->pedido_id }}">
                      
                      <i class="typcn typcn-download mx-0 text-info" ></i>
                    </a>
                    
                  </div>
                </td>
                <td class="text-center">
                  <div data-bs-toggle="tooltip" data-bs-placement="top"
                  title="Click para ver" >
                    <a class="btn" type="button" data-bs-toggle="modal" data-bs-target="#imagenQR" onclick="Livewire.emit('assignPedidoID',@js($pedido->pedido_id))">                      
                      <i class="typcn typcn-eye mx-0 text-success" ></i>
                    </a>

                    
                    
                  </div>
                </td>
                <td class="text-center">
                  <div class="dropdown dropstart" >
                    <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false" >
                      <i class="typcn typcn-th-menu mx-0"></i>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1" >
                      @if($pedido->pedido_estado == 0 || $pedido->pedido_estado == 5 || $pedido->pedido_estado == 9) 
                      <li><a class="dropdown-item"  type="button"  data-toggle="modal"
                        data-target="#UpdateModal" onclick="Livewire.emit('assingpedido',@js($pedido))">Editar</a></li>
                      @else 
                      
                      @endif
                     

                      <li><a class="dropdown-item" type="button" data-toggle="modal" data-target="#detalleModal"
                         onclick="Livewire.emit('assignDetalle',@js($pedido), @js($pedido->id_repartidor))">Detalle</a></li>
                        @if ($pedido->pago == 0)
                        <li><a class="dropdown-item" type="button" onclick="Livewire.emit('pagoQuestion',@js($pedido->pedido_id))">Marcar como pagado</a></li>
                        @endif
                      
                    </ul>
                  </div>
                  {{-- <button type="button" @if($pedido->pedido_estado === 6 || $pedido->pedido_estado === 7) disabled @else @endif   class="btn" 
                    data-toggle="modal" data-target="#UpdateModal" onclick="Livewire.emit('assingpedido',@js($pedido))">
                    <i class="typcn typcn-edit mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title=" @if($pedido->pedido_estado === 6 || $pedido->pedido_estado === 7) Acción deshabilitada @else Editar pedido @endif"></i>
                  </button>

                  <button type="button" class="btn" data-toggle="modal" data-target="#detalleModal" onclick="Livewire.emit('assignDetalle',@js($pedido), @js($pedido->id_repartidor))">
                    <i class="typcn typcn-clipboard mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Detalle de pedido"></i>
                  </button>

                  @if ($pedido->pedido_estado === 1 || $pedido->pedido_estado === 2 )
                  @livewire('pedidos.modal-estados-component')
                  <button type="button" class="btn" data-toggle="modal" data-target="#stateModal" onclick="Livewire.emit('asingId',@js($pedido))">
                    <i class="typcn typcn-info-large-outline mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Estados del pedido"></i>
                  </button>
                  @elseif ($pedido->pedido_estado === 7)
                  @livewire('pedidos.modal-asign-component')
                  <button type="button" class="btn" data-toggle="modal" data-target="#AsignModal" onclick="Livewire.emit('asingIdPedido',@js($pedido->id))">
                    <i class="typcn typcn-arrow-repeat mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Reasignar repartidor"></i>
                  </button>
                  @endif --}}
                 {{--  <button type="button" class="btn" @if($pedido->pedido_estado === 6 || $pedido->pedido_estado === 7) disabled @else @endif>
                    <i class="typcn typcn-cancel mx-0 text-danger" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="@if($pedido->pedido_estado === 0 ||$pedido->pedido_estado === 1 ) Cancelar pedido  @else Acción deshabilitada  @endif "></i>
                  </button> --}}
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
@livewire('admin.update-pedido')   
@endsection


@push('scripts')
<script>
  $(document).ready( function () {
    $('.image-link').magnificPopup({type:'image'});
      $('#myTable').DataTable({
        "order" : [[ 0, 'desc' ]],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
          },
          "rowReorder": {
                "selector": "td:nth-child(0)",
                
            },
            
            "responsive": true
      });
  } );

  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
  })
  
</script>    
@endpush