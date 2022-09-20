@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">       
        <h4 class="card-title">Datos comercios</h4>    
        @livewire('admin.dato-cliente')  
        
        <div class="table-responsive">
          <table  id="myTable" class="display nowrap table responsive" style="width:100%">
            <thead>
              <tr>
                <th>Cod</th>
                <th>Nombre del comercio</th>
                <th>Telefono del comercio</th>               
                <th class="text-start">Dirección</th>   
                <th class="text-center">Acciones</th>             
              </tr>
            </thead>
            <tbody>                         
              @foreach ($comercios as $com)
                  <tr>
                    <td>{{ $com->cod }}</td>
                    <td>{{ $com->nombre }}</td>
                    <td>{{ $com->telefono }}</td>
                    <td>{{ $com->direccion }}</td>
                    <td class="text-center">
                      <div class="dropdown">
                        <button class="btn btn-secondary " type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="typcn typcn-th-menu mx-0"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="actionsMenu">
                          <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#datoClienteModal" onclick="Livewire.emit('assignComercio',@js($com))">Editar</a></li>
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('deteleQuestion',@js($com->id))">Eliminar</a></li>
                          <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#listaDireccionesModal" onclick="Livewire.emit('assignComercioToDireccion',@js($com))">Direcciones</a></li>
                          {{-- <li><a class="dropdown-item" type="button" onclick="Livewire.emit('assignComercioOwner',@js($com))" data-bs-toggle="modal" data-bs-target="#listDireccionEntregaModal">Clientes</a></li> --}}
                        </ul>
                      </div>

                    {{--   <button class="btn" data-bs-toggle="modal" data-bs-target="#datoClienteModal" onclick="Livewire.emit('assignComercio',@js($com))">
                        <i class="typcn typcn-edit mx-0 text-success"></i>
                      </button>
                      
                      <button class="btn"  onclick="Livewire.emit('deteleQuestion',@js($com->id))">
                        <i class="typcn typcn-trash mx-0 text-danger"></i>
                      </button>

                      <button class="btn"  data-bs-toggle="modal" data-bs-target="#listaDireccionesModal" onclick="Livewire.emit('assignComercioToDireccion',@js($com))">
                        <i class="typcn typcn-location mx-0 text-info"></i>
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

      $('#listTable').DataTable({
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