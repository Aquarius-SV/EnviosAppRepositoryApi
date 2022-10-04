@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">       
        <h4 class="card-title">Pedidos de los comercios</h4>
        <div class="table-responsive">
          <table  id="myTable" class="display nowrap table responsive" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">SKU</th>                        
                <th class="text-start">Comercio</th>
                <th class="text-start">Cliente</th>
                <th class="text-start">Teléfono del cliente</th>                                              
                <th>Estado</th>     
                <th>Fecha</th>       
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>                         
              @foreach ($pedidos as $pedido)
              <tr>
              
                <td class="text-center">
                  {{ $pedido->sku }}
                </td>
                <td class="text-start">
                    {{ $pedido->comercio }}
                   </td>
                <td class="text-start">
                  {{ $pedido->nombre }}
                 </td>
                <td class="text-start">{{ $pedido->telefono }}</td>                               
                <td>
                  @switch($pedido->estado)
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
                
                  <td>{{ $pedido->created_at->format('d/m/Y h:i:s a') }}</td>
                
                
                <td class="text-center">

                  @if ($pedido->estado == 0 && $pedido->id_repartidor == null)
                 
                  <button type="button" class="btn" data-toggle="modal" data-target="#AsignModal" onclick="Livewire.emit('asingIdPedido',@js($pedido->id))">
                    <i class="typcn typcn-arrow-repeat mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Asignar repartidor"></i>
                  </button>
                  @endif
                  @if ($pedido->estado == 10)
                  <button type="button" class="btn"  onclick="Livewire.emit('questionEntregado',@js($pedido->id))">
                    <i class="typcn typcn-input-checked mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Marcar como entregado"></i>
                  </button>
                  @endif

                  @if ($pedido->pago == 0)
                  <button type="button" class="btn"  onclick="Livewire.emit('questionPagado',@js($pedido->id))">
                    <i class="typcn typcn-calculator mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Marcar como pagado"></i>
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
@livewire('pedidos.modal-asign-component')
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