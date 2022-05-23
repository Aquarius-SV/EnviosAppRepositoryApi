<div>
    <div class="modal fade" id="stateModal" tabindex="-1" aria-labelledby="stateModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="stateModalLabel">Actualización de estado del pedido </h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6">
                      <div class="card">
                        <div class="card-body">                          
                          <button wire:click="preparacionQuestion"  @if($estado === 1) @else disabled @endif  class="btn">
                            <i class="far fa-box-alt @if($estado > 1) text-success @endif" style="font-size:45px;"></i>
                          </button>
                        </div>
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <div class="card">
                        <div class="card-body">                         
                          <button  class="btn" wire:click="recogerQuestion" @if($estado === 2) @else disabled @endif >
                            <i class="far fa-box-check  @if($estado > 2) text-success @endif" style="font-size:45px;"></i>
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
