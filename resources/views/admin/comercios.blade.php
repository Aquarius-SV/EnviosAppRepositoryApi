@extends('admin.blank')


@section('content')
    <div class="row">
        <div class="col-lg-12 d-flex grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Comercios</h4>
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#registroComercioModal">
                        <i class="typcn typcn-plus"></i>Nuevo
                    </button>
                    
                    <div class="table-responsive">
                        <table id="usersAdmin" class="display nowrap table responsive" style="width:100%">
                            <thead>
                              <tr>
                                <th scope="col">Nombre</th>                                
                                <th scope="col">Telefono</th>
                                <th scope="col">Dirección</th>                                
                                <th scope="col">Acciones</th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse ($comercios as $cmc)
                                    <tr>
                                      <td>{{ $cmc->nombre }}</td>                                      
                                      <td>{{ $cmc->telefono }}</td>                                      
                                      <td>{{ $cmc->direccion }}</td>                                                                            
                                      <td>
                                        <button class="btn" data-bs-toggle="modal" data-bs-target="#detalleComercioModal" onclick="Livewire.emit('assignComercio',@js($cmc))">
                                          <i class="typcn typcn-document-text text-info"></i>
                                        </button>

                                        <button class="btn" data-bs-toggle="modal" data-bs-target="#fechasModal" onclick="Livewire.emit('assignComercioDate',@js($cmc->id))">
                                          <i class="typcn typcn-chart-bar text-success"></i>
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
    @livewire('admin.comercio-registro')
    @livewire('admin.detalle-comercio')
    @livewire('admin.lista-pedido-comercio')
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