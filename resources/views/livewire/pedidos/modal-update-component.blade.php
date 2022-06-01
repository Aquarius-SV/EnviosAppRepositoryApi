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
                  <label for="direccionR" class="form-label">Dirección de recogida</label>
                  <textarea class="form-control @error('direccion_recogida') is-invalid @enderror"  wire:model="direccion_recogida" rows="5"></textarea>
                  <div id="emailHelp" class="form-text">Dirección donde el repartidor recogerá el paquete
                    <br>
                    @error('direccion_recogida') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <label for="direccionE" class="form-label">Dirección de entrega</label>
                  <textarea class="form-control @error('direccion_entrega') is-invalid @enderror"  wire:model="direccion_entrega" rows="5"></textarea>
                  <div id="emailHelp" class="form-text">Dirección donde el repartidor entregará el paquete
                    <br>
                    @error('direccion_entrega') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Teléfono del cliente</label>
                  <input type="text" class="form-control @error('tel_cliente') is-invalid @enderror" maxlength="8" wire:model="tel_cliente">
                  <div id="emailHelp" class="form-text">Teléfono del cliente a quien se le entregará el paquete
                    <br>
                    @error('tel_cliente') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Peso del paquete</label>
                  <input type="text" class="form-control @error('tel_cliente') is-invalid @enderror"  wire:model="peso">
                  <div id="emailHelp" class="form-text">Especificar el peso del paquete para que el repartidor lo tome en consideración
                    <br>
                    @error('peso') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class="mb-3">
                  <label class="form-label">Tamaño del paquete</label>
                  <input type="text" class="form-control @error('tel_cliente') is-invalid @enderror"  wire:model="size">
                  <div id="emailHelp" class="form-text">Especificar el tamaño del paquete para que el repartidor lo tome en consideración
                    <br>
                    @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                </div>
                <div class=" mb-3">
                  <label class="form-label">Fragil</label>
                  <select class="form-select @error('fragil') is-invalid @enderror" aria-label="Fragil" wire:model="fragil">  
                    <option value="0">No</option>                
                    <option value="1">Si</option>                  
                  </select>
                  @error('fragil') <span class="text-danger">{{ $message }}</span> @enderror
                </div>                    
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="PUpdate">Actualizar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
 
   
  
  
  