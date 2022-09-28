@extends('admin.blank')


@section('content')

<div class="row">
  
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Repartidores</h4>        
        @livewire('admin.repartidores-component')
        @livewire('delete-user')
        <div class="table-responsive">
          <table class="display nowrap table responsive" style="width:100%" id="myTable">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Vehículo</th>
                <th>Placa</th>
                <th>Estado</th>
                <th>Fecha de registro</th>
                <th class="text-center" >Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($repartidores as $rp)
              <tr>               
                <td>
                  {{ $rp->name }}
                </td>
                <td>{{ $rp->email }}</td>
                <td>{{ $rp->telefono }}</td>
                <td>
                  {{ $rp->modelo}}       
                </td>
                <td>
                  {{ $rp->placa}}       
                </td>
                <td>
                  @if ($rp->estado == 0)
                      No activo
                  @else
                      Activo
                  @endif
                </td>
                <td> {{ date('d/m/Y h:i:s a', strtotime($rp->created_at)) }}</td>
                <td class="text-center"> 
                  <button type="button" class="btn"  data-bs-toggle="modal" data-bs-target="#detalleRepartidor" onclick="Livewire.emit('assingRepartidor',@js($rp))">
                    <span class="iconify" data-icon="typcn:document-text" style="color: 2b80ff;" data-width="30"></span>
                  </button>

                  @if ($rp->estado == 1)
                  <button type="button" class="btn"  data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="Livewire.emit('assingUser',@js($rp->id_user))">
                    <span class="iconify" data-icon="typcn:delete" style="color: #ff0000;" data-width="30"></span>
                  </button>
                  @endif
                  
                  {{-- @if ($pedido->estado === 0)
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
                  @endif --}}                                  
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
                "order" : [[ 6, 'desc' ]],
                "rowReorder": {
                "selector": "td:nth-child(0)",
                
            },
         "responsive": true

  });
  } );

  

  $.fn.modal.Constructor.prototype._enforceFocus = function() {};


  
</script>
@endpush