@extends('admin.blank')


@section('content')
<div class="row">
    <div class="col-lg-12 d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Listado de puntos de reparto</h4>
                <button type="button" class="btn btn-primary mb-3"  data-bs-toggle="modal" data-bs-target="#puntoModal"><i class="typcn typcn-plus"></i>Nuevo</button>
                @livewire('admin.punto-reparto-component')
                <div class="table-responsive">
                    <table id="puntosTable" class="display nowrap table responsive" style="width:100%">
                        <thead>
                          <tr>                            
                            <th>Nombre</th>
                            <th>Código</th>
                            <th>Dirección</th>
                            <th>Telefono</th>
                            <th>Departamento</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          @forelse ($puntos as $pt)
                              <tr>
                                <td>{{ $pt->nombre }}</td>
                                <td>{{ $pt->codigo }}</td>                                
                                <td>{{ $pt->direccion }}</td>
                                <td>{{ $pt->telefono }}</td>
                                <td>{{ $pt->departamento }}</td>                                
                                <td>{{ $pt->municipio }}</td>
                                <td>
                                  @if($pt->estado == 0)
                                    Desactivado
                                  @else
                                    Activo
                                  @endif
                                </td>
                                <td>                                 
                                  <div class="dropdown">
                                    <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                                      <i class="typcn typcn-th-menu mx-0 text-prymary"></i>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                      <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#detalleModal" onclick="Livewire.emit('assignReparto',@js($pt))">Detalle</a></li>
                                      <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#puntoModal" onclick="Livewire.emit('assignReparto',@js($pt))">Editar</a></li>
                                      <li><a class="dropdown-item" href="#" onclick="Livewire.emit('questionDeletePunto',@js($pt->id))">Eliminar</a></li>
                                      @if ($pt->estado == 0)
                                      <li><a class="dropdown-item" href="#" onclick="Livewire.emit('activePunto',@js($pt->id))">Activar</a></li>
                                      @else
                                      <li><a class="dropdown-item" href="#" onclick="Livewire.emit('questionDisablePunto',@js($pt->id))">Desactivar</a></li>
                                      @endif
                                      
                                    </ul>
                                  </div>
                                </td>
                              </tr>
                          @empty
                              
                          @endforelse
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
      $('#puntosTable').DataTable({
        "order" : [[1, 'desc' ]],
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