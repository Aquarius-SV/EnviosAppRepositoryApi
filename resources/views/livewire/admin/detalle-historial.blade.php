<div>
    <div class="modal fade" id="detalleHistorialModal" tabindex="-1" aria-labelledby="detalleHistorialModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="detalleHistorialModalLabel">Historial de pedido</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Acción</th>
                    <th scope="col">Repartidor</th>
                    <th scope="col">Zona</th>
                    <th scope="col">Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($detalle as $dt)
                    @php
                      $zona = DB::table('zonas')->where('id',$dt->id_zona)->value('nombre');

                      $repartidor = DB::table('users')->join('repartidores','repartidores.id_usuario','=','users.id')
                      ->where('repartidores.id',$dt->id_repartidor)->value('users.name');
                    @endphp
                    
                    <tr>
                      <td ><b>{{ $dt->accion }}</b></td>
                      <td>{{ $repartidor}}</td>
                      <td>{{ ($zona) ? $zona : 'No disponible'}}</td>
                      <td>{{ date('d/m/Y h:i:s a', strtotime($dt->created_at)) }}</td>
                    </tr>
                   
                    @empty
                      <h4 class="text-center">No hay datos disponibles</h4>                                   
                    @endforelse  
                 
                 
                </tbody>
              </table>              
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>
</div>
