<div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="deleteModalLabel">Eliminación de usuario</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
              <div class="">
                <label for="">Razón</label>
                
                <textarea class="form-control @error('razon') is-invalid @enderror" placeholder="Razón" id="floatingTextarea2" style="height: 100px" wire:model="razon"></textarea>
                
                @error('razon') <span class="text-danger">{{ $message }}</span> @enderror
                    
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="deleteUser">Eliminar</button>
            </div>
          </div>
        </div>
      </div>
</div>
