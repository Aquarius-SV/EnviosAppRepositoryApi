@extends('admin.blank')


@section('content')

<div class="row">
  
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Zonas de reparto</h4>        
        @livewire('admin.zonas-component')
        <div class="table-responsive">
          <table class="display nowrap table responsive" style="width:100%" id="myTable">
            <thead>
              <tr>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Municipio</th>
                <th>Estado</th>                                
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($zonas as $zn)
              <tr>               
                <td>
                  {{ $zn->nombre }}
                </td>
                <td>{{ $zn->departamento }}</td>
                <td>{{ $zn->municipio }}</td>
                <td>
                  {{ ($zn->estado == 1) ? 'Activa' : 'Desactivada' ; }}       
                </td>
              
               
                <td class="text-center"> 

                    <div class="dropdown">
                        <button class="btn btn-secondary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="iconify" data-icon="typcn:th-menu"  ></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                          <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#zonaModal" onclick="Livewire.emit('assignZonaReparto',@js($zn))">Editar</a></li>
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('questionDeleteOrDisable',@js($zn->id),'delete')">Eliminar</a></li>
                          @if ($zn->estado == 1)
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('questionDeleteOrDisable',@js($zn->id),'disable')">Desactivar</a></li>
                          @endif
                          
                        </ul>
                      </div>


{{-- 
                  <button type="button" class="btn"  >
                    <span class="iconify" data-icon="typcn:edit" style="color: #198754;" ></span>
                  </button>


                  <button type="button" class="btn"  >
                    <span class="iconify" data-icon="typcn:edit" style="color: #198754;" ></span>
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
  $('#myTable').DataTable({
    "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
                "order" : [[ 0, 'desc' ]],
                "rowReorder": {
                "selector": "td:nth-child(0)",
                
            },
         "responsive": true

  });
  } );

  

  


  
</script>
@endpush