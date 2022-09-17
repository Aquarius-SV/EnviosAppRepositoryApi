<div>
    <div class="modal fade" id="aceptarModal" tabindex="-1" aria-labelledby="aceptarModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="aceptarModalLabel">Recepción de pedido</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <div class="mb-3">
                
                <label for="">Código</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" wire:model="codigo">
                @error('codigo') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="CodeValidate">Recibir</button>

              {{-- <button type="button" class="btn btn-primary" wire:click="createPedidoPunto">CREAR PEDIDO TEST</button> --}}


            </div>
          </div>
        </div>
      </div>
</div>
