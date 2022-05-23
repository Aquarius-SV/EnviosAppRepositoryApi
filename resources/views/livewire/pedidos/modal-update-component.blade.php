<div>
    <div class="card-description">
      <div class="modal fade" id="UpdateModal" tabindex="-1" aria-labelledby="UpdateModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center text-black" id="UpdateModalLabel">Actualización de Pedido</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close" ></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Direccion de recogida</label>
                  <input type="text" class="form-control @error('direccion_recogida') is-invalid  @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" wire:model="direccion_recogida">
                  <div id="emailHelp" class="form-text">Dirección donde el repartidor recogerá el paquete <br>
                    @error('direccion_recogida') <span class="text-danger">{{ $message }}</span> @enderror
                   </div>
                </div>
                <div class="mb-3">
                  <label for="exampleInputEmail1" class="form-label">Direccion de entrega</label>
                  <input type="text" class="form-control @error('direccion_entrega') is-invalid @enderror" id="exampleInputEmail1" aria-describedby="emailHelp" wire:model="direccion_entrega">
                  <div id="emailHelp" class="form-text">Dirección donde el repartidor entregará el paquete
                    <br>
                    @error('direccion_entrega') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>  
                </div>                    
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="PUpdate">Actualizar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @push('scripts')
      <script>         
           window.addEventListener('closeModal', event => {
           $("#UpdateModal").modal('hide');  
           });   
      </script>
  @endpush
  
  
  