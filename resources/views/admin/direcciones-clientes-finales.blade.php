@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">       
        <h4 class="card-title">Direcciones de clientes finales</h4> 
        @livewire('admin.direccion-cliente')           
        <div class="table-responsive">
          <table  id="myTable" class="display nowrap table responsive" style="width:100%">
            <thead>
              <tr>
                <th>Cod</th>
                <th class="text-start">Nombre</th>
                <th>DUI</th>               
                <th class="text-start">Teléfono</th>
                <th class="text-start">Dirección</th>                                              
                
                <th class="text-start">Whatsapp</th>
                <th class="text-start">Correo</th>
                <th class="text-center">Estado</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>                         
              @foreach ($direcciones as $dr) 
                  <tr>
                    <td>{{ $dr->cod }}</td>
                    <td>{{ $dr->nombre }}</td>
                    <td>{{ $dr->dui }}</td>
                    <td>{{ $dr->telefono }}</td>
                    <td>{{ $dr->direccion }}</td>                    
                    <td>{{ $dr->numero_whatsapp }}</td>
                    <td>{{ $dr->correo }}</td>
                    <td class="text-center">{{ ($dr->estado == 0 ) ? 'Desactivada' : 'Activa' ; }}</td>
                    <td class="text-center">
                      <div class="dropdown">
                        <button class="btn" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                          <i class="typcn typcn-th-menu"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('assigDireccionRecogida',@js($dr))" data-bs-toggle="modal" data-bs-target="#detalleDireccionClienteModal">Detalle</a></li>
                          <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#direccionRecogidaModal"
                             onclick="Livewire.emit('assigDireccionRecogida',@js($dr))">Editar</a></li>
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('deleteQuestionDireccionRecogida',@js($dr->id))">Eliminar</a></li>
                          @if ($dr->estado == 1)
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('disableQuestionDireccion',@js($dr->id))">Desactivar</a></li>
                          @endif
                          
                        </ul>
                      </div>
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