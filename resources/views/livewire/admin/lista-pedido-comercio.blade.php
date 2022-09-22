<div>
    <div class="modal fade" id="fechasModal" tabindex="-1" aria-labelledby="fechasModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="fechasModalLabel">Listado de pedidos del comercio</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
              <div class="mb-3">
                
                <label for="">Fecha inicio</label>
                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" wire:model="fecha_inicio">
                @error('fecha_inicio') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class="mb-3">
                
                <label for="">Fecha fin</label>
                <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror" wire:model="fecha_fin">
                @error('fecha_fin') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary"  wire:click="showList">Ver listado</button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="tablaModal" tabindex="-1" aria-labelledby="tablaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable @if($pedidos) modal-lg @else @endif">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="tablaModalLabel">Lista de pedidos</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @if ($pedidos)
                <table class="table pedidosTable" id="pedidosTable" >
                    <thead>
                      <tr>
                        <th scope="col">SKU</th>
                        <th scope="col">Peso</th>
                        <th scope="col">Alto</th>
                        <th scope="col">Ancho</th>
                        <th scope="col">Profundidad</th>
                        <th scope="col">Pagado</th>
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($pedidos as $pd)
                        <tr>
                            <td>{{ $pd->sku }}</td>
                            <td>{{ $pd->peso }}</td>
                            <td>{{ $pd->alto }}</td>
                            <td>{{ $pd->ancho }}</td>
                            <td>{{ $pd->profundidad }}</td>
                            <td>
                                @if ($pd->pago == 0)
                                <span class="badge bg-danger text-white">No pagado</span>
                                @else
                                <span class="badge bg-success text-white">Pagado</span>
                                @endif
    
                            </td>
                          </tr>
                        @empty
                            
                        @endforelse                                         
                    </tbody>
                    
                  </table>
                @else
                <h2 class="text-center">No hay pedidos relacionados con este pedido</h2>
                @endif
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>

</div>


@push('scripts')
<script>
  $(document).ready( function () {
      $('.pedidosTable').DataTable({
        
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
          },      
      });
  } );

  

  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  var fechasModal = document.getElementById('fechasModal')
  var tablaModal = document.getElementById('tablaModal')

  window.addEventListener('close_up', event => {
    $("#fechasModal").modal('hide');
    $("#tablaModal").modal('show');
    /* fechasModal.hide();
    tablaModal.show(); */
  });

 
</script>    
@endpush
