<div>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#direccionRecogidaModal">
        <i class="typcn typcn-plus"></i> Nueva
    </button>



    <div class="modal fade" id="direccionRecogidaModal" tabindex="-1" aria-labelledby="direccionRecogidaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="direccionRecogidaModalLabel">Dirección de recogida</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <div class="mb-3">
                <label for="">Nombre</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
             </div>
             <div class="mb-3">
                <label for="floatingTextarea2">Dirección</label>
                <textarea class="form-control @error('direccion') is-invalid @enderror" placeholder="Ingresa la dirección" id="floatingTextarea2" style="height: 100px" wire:model="direccion"></textarea>    
                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                                 
             </div>

             @if ($id_direccion)
             <div class="mb-3">
              <label for="">Estado</label>
              <select class="form-select" wire:model="estado">    
                @switch($old_estado)
                  @case(1)
                  <option value="1">Activa </option>
                  <option value="0">Desactivar</option> 
                    @break                
                    @case(0)
                    <option value="1">Activar </option>
                    <option value="0">Desactivada</option> 
                    @break
                    
                @endswitch            
                              
              </select>
             </div>
             @endif


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" @if($id_direccion) wire:click="updateDireccion" @else wire:click="createDireccion" @endif >{{ ($id_direccion) ? 'Actualizar' : 'Guardar' ; }}</button>
            </div>
          </div>
        </div>
      </div>
</div>
@push('scripts')
  <script>
    var direccionRecogidaModal = document.getElementById('direccionRecogidaModal')
    direccionRecogidaModal.addEventListener('hidden.bs.modal', function (event) {
        Livewire.emit('resetDataDireccionRecogida');
    });
  </script>
@endpush