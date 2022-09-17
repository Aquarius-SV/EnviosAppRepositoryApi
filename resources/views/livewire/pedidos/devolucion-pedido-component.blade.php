<div>
    <div class="modal fade" id="devolucionModal" tabindex="-1" aria-labelledby="devolucionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="devolucionModalLabel">Devolución</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código de devolución</label>
                    <input type="text" class="form-control mb-1" id="codigo" placeholder="Digita el código" wire:model="code">
                  </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="validateCode">Validar</button>
            </div>
          </div>
        </div>
      </div>
</div>
