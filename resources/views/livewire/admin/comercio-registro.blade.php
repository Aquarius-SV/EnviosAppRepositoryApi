<div>
   

  
    
    <div class="modal fade" id="registroComercioModal" tabindex="-1" aria-labelledby="registroComercioModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title col-11 text-center" id="registroComercioModalLabel">Registro de comercio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Enlace</label>
                    <input type="text" class="form-control" wire:model="enlace">
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" wire:click="generateUrl">Generar enlace</button>
            </div>
        </div>
        </div>
    </div>

</div>
