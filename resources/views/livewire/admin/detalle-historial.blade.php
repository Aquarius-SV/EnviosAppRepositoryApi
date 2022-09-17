<div>
    <div class="modal fade" id="detalleHistorialModal" tabindex="-1" aria-labelledby="detalleHistorialModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="detalleHistorialModalLabel">Historial de pedido</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @forelse ($detalle as $dt)
                    @php
                      $zona = DB::table('zonas')->where('id',$dt->id_zona)->value('nombre');

                      $repartidor = DB::table('users')->join('repartidores','repartidores.id_usuario','=','users.id')
                      ->where('repartidores.id',$dt->id_repartidor)->value('users.name');
                    @endphp
                  
                    <a type="buttons" class="list-group-item list-group-item-action mb-3" aria-current="true">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><b>{{ $dt->accion }}</b></h5>
                        <small>{{ date('d/m/Y h:i:s a', strtotime($dt->created_at)) }}</small>
                      </div>
                      @if ($dt->id_repartidor <> null)
                      <p class="mb-1"><b>Repartidor</b>: {{ $repartidor}}</p>                     
                      @endif
                      @if ($dt->id_zona <> null)
                      <p class="mb-1"><b>Zona</b>: {{ $zona}}</p>                  
                      @endif
                      
                     
                    </a>
                    @empty
                      <h4 class="text-center">No hay datos disponibles</h4>                                   
                    @endforelse                                        
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>
</div>
