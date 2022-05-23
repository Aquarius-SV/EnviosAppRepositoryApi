@extends('admin.blank')


@section('content')

<div class="row">
  
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Mis Pedidos</h4>        
        @livewire('repartidores.pedidos-component')
        @livewire('repartidores.estados-component')
        <div class="table-responsive">
          <table class="table" id="myTable">
            <thead>
              <tr>
                <th>Comerciante</th>
                <th>Dirección de recogida</th>
                <th>Dirección de entrega</th>
                <th>Estado</th>
                <th class="text-center" >Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($allp as $pedido)
              <tr>
                @php
                    $cliente = DB::table('users')->select('name')->where('id',$pedido->id_usuario)->first();
                @endphp
                <td>
                  {{ $cliente->name }}
                </td>
                <td>{{ $pedido->direccion_recogida }}</td>
                <td>{{ $pedido->direccion_entrega }}</td>
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
                    <label class="badge badge-info">Pedido recogido</label>
                    @break
                    @case(5)
                    <label class="badge badge-info">En transito</label>
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
                <td class="text-center"> 
                  @if ($pedido->estado === 0)
                  <button type="button" class="btn" onclick="Livewire.emit('acceptQuestion',@js($pedido->id_pedido) )" >
                    <span class="iconify" data-icon="typcn:input-checked" style="color: #2b80ff;" data-width="30"></span>
                  </button>
                  <button type="button" class="btn" onclick="Livewire.emit('rejectQuestion',@js($pedido->id_pedido) )" >
                    <span class="iconify" data-icon="typcn:delete" style="color: red;" data-width="30"></span>
                  </button>
                  @else
                  <button type="button" @if($pedido->estado === 6 || $pedido->estado === 7  ) disabled @else  @endif class="btn"  @if($pedido->estado === 6 || $pedido->estado === 7  )  @else data-toggle="modal" data-target="#PedidoRModal" onclick="Livewire.emit('asingId',@js($pedido) )"  @endif >
                    <span class="iconify" data-icon="typcn:clipboard" style="color: #2b80ff;" data-width="30" ></span>
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
  $('#myTable').DataTable({
    "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
  });
  } );

  

  $.fn.modal.Constructor.prototype._enforceFocus = function() {};


  
</script>
@endpush