<div>    
  <div class="modal fade" id="detalleComercioModal" tabindex="-1" aria-labelledby="detalleComercioModalLabel" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title col-11 text-center" id="detalleComercioModalLabel">Comercio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            
            @if ($encargado <> null)
            <div class="mb-3">
                <label for="">Encargado</label>
                <input type="text" class="form-control" wire:model="encargado">
            </div>
            <div class="mb-3">
                <label for="">Correo encargado</label>
                <input type="text" class="form-control" wire:model="correo">
            </div>
            <div class="mb-3">
                <label for="">DUI</label>
                <input type="text" class="form-control" wire:model="dui">
            </div>
            <div class="mb-3">
                <label for="">Telefono encargado</label>
                <input type="text" class="form-control" wire:model="telefono_encargado">
            </div>
            @endif

            <div class="mb-3">
                <label for="">Nombre del comercio</label>
                <input type="text" class="form-control" wire:model="comercio">
            </div>
            <div class="mb-3">
                <label for="">Telefono del comercio</label>
                <input type="text" class="form-control" wire:model="telefono">
            </div>

            <div class="mb-3">
                <label for="">Direccion del comercio</label>
                <textarea class="form-control" wire:model="direccion" style="height: 100px"></textarea>                
            </div>


        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          
        </div>
      </div>
    </div>
  </div>
</div>
