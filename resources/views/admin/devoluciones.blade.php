@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">       
        <h4 class="card-title">Devolución de pedidos</h4>
        @livewire('pedidos.devolucion-pedido-component')
        @livewire('pedidos.detalle-modal-component')
        @livewire('pedidos.modal-asign-component')
        @livewire('pedidos.qr-pedido')
        <div class="table-responsive">
          <table  id="myTable" class="display nowrap table responsive" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">SKU</th>
                <th>Repartidor</th>               
                <th class="text-start">Cliente</th>
                <th class="text-start">Teléfono del cliente</th>                                              
                <th>Estado</th>
                {{-- <th class="text-center">QR</th> --}}
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
                  {{ $pedido->sku }}
                </td>
                <td>
                  {{ $repartidor->name }}
                </td>
                <td class="text-start">
                  {{ $pedido->nombre }}
                 </td>
                <td class="text-start">{{ $pedido->telefono }}</td>                               
                <td>
                  @switch($pedido->estado_pedido)
                  @case(0)
                  <label class="badge badge-info">Pendiente de aceptación</label>
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
                  <label class="badge badge-success">Devolución completada</label>
                  @break
                  @endswitch
                </td>
              {{--   <td class="text-center">
                  <div data-bs-toggle="tooltip" data-bs-placement="top"
                  title="Click para ver" >
                    <a class="btn" type="button" data-bs-toggle="modal" data-bs-target="#imagenQR" onclick="Livewire.emit('assignPedidoID',@js($pedido->id_pedido))" >                      
                      <i class="typcn typcn-eye mx-0 text-success" ></i>
                    </a>
                    
                  </div>
                </td> --}}
                <td class="text-center">                                   
                  <button type="button" class="btn" data-toggle="modal" data-target="#detalleModal" onclick="Livewire.emit('assignDetalle',@js($pedido), @js($pedido->id_repartidor))">
                    <i class="typcn typcn-clipboard mx-0 text-info" style="font-size: 24px;" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Detalle de pedido"></i>
                  </button>

                  @if ($pedido->estado == 10)
                    <button type="button" class="btn" data-toggle="modal" data-target="#AsignModal" onclick="Livewire.emit('asingIdPedido',@js($pedido->id_pedido))">
                        <i class="typcn typcn-arrow-sync mx-0 text-success" style="font-size: 24px;" data-bs-toggle="tooltip" data-bs-placement="top"
                        title="Reasignación de pedido"></i>
                    </button>
                  @else
                  <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#imagenQR" onclick="Livewire.emit('assignPedidoID',@js($pedido->id_pedido))">
                    <i class="typcn typcn-input-checked mx-0 text-success" style="font-size: 24px;" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Confirmar devolución"></i>
                  </button>
                  @endif
                  
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