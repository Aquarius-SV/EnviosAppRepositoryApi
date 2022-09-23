@extends('admin.blank')


@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Administradores de puntos de reparto</h4> 
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#interModal">
                      <i class="typcn typcn-plus"></i>Nuevo
                    </button>
                    @livewire('admin.intermediario-punto')
                    
                    <div class="table-responsive">
                        <table id="usersAdmin" class="display nowrap table responsive" style="width:100%">
                            <thead>
                              <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">DUI</th>
                                <th scope="col">Dirección de residencia</th>
                                <th scope="col">Teléfono</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse ($admins as $adm)
                                    <tr>
                                      <td>{{ $adm->nombre }}</td>
                                      <td>{{ $adm->dui }}</td>
                                      <td>{{ $adm->direccion }}</td>
                                      <td>{{ $adm->telefono }}</td>
                                      <td>{{ ($adm->cargo) ? $adm->cargo : 'Cargo no especificado'}}</td>
                                      <td>
                                        <button class="btn" data-bs-toggle="modal" data-bs-target="#detalleModal" onclick="Livewire.emit('assignInter',@js($adm))">
                                          <i class="typcn typcn-document-text text-info"></i>
                                        </button>
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
      $('#usersAdmin').DataTable({
        "order" : [[0, 'desc' ]],
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