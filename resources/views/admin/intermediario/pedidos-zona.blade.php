@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Todos los pedidos en movimiento de: {{ $zona}}</h4>        
        @livewire('pedidos.detalle-modal-component') 
        @livewire('intermediario.aceptar-pedido')
        <div class="table-responsive">
          <table  id="myTable" class="display nowrap table responsive" style="width:100%">
            <thead>
              <tr>
                <th class="text-center">SKU</th>
                <th>Repartidor</th>               
                <th class="text-start">Cliente</th>
                <th class="text-start">Teléfono del cliente</th>                                            
                <th>Estado</th>
                {{-- <th>QR</th> --}}
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($allp as $pedido)
              <tr>
                @php
                $repartidor = DB::table('users')->join('repartidores','repartidores.id_usuario','=','users.id')->select('users.name')->where('repartidores.id',$pedido->id_repartidor)->first();
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
                  @switch($pedido->estado_detalle)
                  @case(0)
                  <label class="badge badge-info">En transito</label>
                  @break
                  @case(1)
                  <label class="badge badge-success">Recibido</label>
                  @break                       
                  @case(2)
                  <label class="badge badge-success">Entregado</label>
                  @break  
                  @case(3)
                  <label class="badge badge-info">Pendiente de aceptacion</label>
                  @break  
                  @endswitch
                </td>              
                <td class="text-center">                                   
                  <button type="button" class="btn" data-toggle="modal" data-target="#detalleModal" onclick="Livewire.emit('assignDetalle',@js($pedido), @js($pedido->id_repartidor),@js($pedido->id_repartidor_pedido_punto))">
                    <i class="typcn typcn-clipboard mx-0 text-info" data-bs-toggle="tooltip" data-bs-placement="top"
                      title="Detalle de pedido"></i>
                  </button>
                  @if ($pedido->estado_detalle == 0)
                  <a  type="button" class="btn image-link" href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate(json_encode(['id' =>  $pedido->id,'estado' =>'1' ]))); !!}">
                    <i class="typcn typcn-arrow-minimise mx-0 text-success" data-bs-toggle="tooltip" data-bs-placement="top"
                    title="Recepción de pedido"></i>
                  </a>
                  @else
                      
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
        "order": [[0, 'desc']],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
          },
          "rowReorder": {
                "selector": "td:nth-child(2)",
                
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