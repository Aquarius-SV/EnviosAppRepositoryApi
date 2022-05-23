<div>
    <div class="modal fade" id="PedidoRModal" tabindex="-1" aria-labelledby="PedidoRModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="modal-title  col-11 text-center" id="PedidoRModalLabel">Estado del pedido</h2>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
              <div class="row">
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                        <button class="btn" @if($estado === 3 ) @else disabled @endif data-bs-toggle="tooltip" data-bs-placement="top" title="Pedido recogido" wire:click="recogerQuestion">
                          <i class="far fa-box-check   @if($estado > 4 ) text-success @else  @endif" style="font-size:45px;"></i>                      
                        </button>                                         
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">

                            <button class="btn" @if($estado === 4 ) @else disabled @endif data-bs-toggle="tooltip" data-bs-placement="top" title="Pedido en transito" wire:click="transitoQuestion">                      
                            <i class="fas fa-shipping-timed @if($estado >= 5 ) text-success @else  @endif" style="font-size:45px;"></i>
                           </button>       
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                       
                        <button class="btn" @if($estado === 5 ) @else disabled @endif  data-bs-toggle="tooltip" data-bs-placement="top" title="Pedido entregado" wire:click="entregadoQuestion">
                            <i class="fas fa-home @if($estado === 6 ) text-success @else  @endif" style="font-size:45px;"></i> 
                        </button>                                           
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="card">
                    <div class="card-body">
                     <button class="btn" @if($estado === 5 ) @else disabled @endif  data-bs-toggle="tooltip" data-bs-placement="top" title="Pedido no entregado" wire:click="noEntregadoQuestion">
                         
                      <i class="fal fa-user-times @if($estado === 8 ) text-success @else  @endif" style="font-size:45px;"></i>                                        
                     </button>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>

</div>
