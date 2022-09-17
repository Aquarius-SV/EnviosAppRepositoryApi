<div>
    <div class="modal fade" id="direccionClienteModal" tabindex="-1" aria-labelledby="direccionClienteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="direccionClienteModalLabel">
                @if($cliente)
                Actualización de dirección de cliente
                @else
                Nueva dirección de cliente
                @endif
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Nombre</label>
                      <input type="text" class="form-control @error('nombre') is-invalid @enderror"  wire:model="nombre">
                      @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">DUI</label>
                      <input type="text" class="form-control @error('dui') is-invalid @enderror"  wire:model="dui">
                      @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('telefono') is-invalid @enderror" wire:model="telefono">
                        @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="checkbox mb-3">
                      <label>
                        <input type="checkbox" wire:click="sameTelefono"> Utilizar el mismo
                      </label>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Teléfono con whatsApp</label>
                      <input type="text" class="form-control @error('telefono_wa') is-invalid @enderror" wire:model="telefono_wa">
                      @error('telefono_wa') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>
                  <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                    <input type="text" class="form-control @error('correo') is-invalid @enderror"  wire:model="correo">
                    @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
                  </div>


                      <div class="row">
                        <div class="mb-3 col-6">
                          <label for="">Departamento <span class="text-danger">*</span></label>
                          <select class="form-select @error('departamento') is-invalid @enderror" aria-label="Selecione el departamento" wire:model="departamento" >
                            <option style="display: none;">Selecione el departamento</option>
                            @forelse ($departamentos as $dp)
                            <option value="{{ $dp->id }}">{{ $dp->nombre }}</option>
                            @empty
                            <option>No hay datos disponibles</option>
                            @endforelse                                          
                          </select>
                          @error('departamento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
        
                        <div class="mb-3 col-6">
                          <label for="">Municipio<span class="text-danger">*</span></label>
                          <select class="form-select @error('municipio') is-invalid @enderror" aria-label="Selecione el municipio" wire:model="municipio" >
                            <option style="display: none;">Selecione el municipio</option>
                            @forelse ($municipios as $mp)
                            <option value="{{ $mp->id }}">{{ $mp->nombre }}</option>
                            @empty
                            <option>No hay datos disponibles</option>
                            @endforelse                                          
                          </select>
                          @error('municipio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
        
                      </div>
                    <div class="mb-3">
                        <label>Dirección</label>
                        <textarea class="form-control @error('direccion') is-invalid @enderror" placeholder="Digita la dirección"  style="height: 100px" wire:model="direccion"></textarea>    
                        @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                                               
                    </div>


                    <div class="mb-3">
                      <label>Referencia</label>
                      <textarea class="form-control @error('referencia') is-invalid @enderror" placeholder="Digita la referencia"  style="height: 100px" wire:model="referencia"></textarea>    
                      @error('referencia') <span class="text-danger">{{ $message }}</span> @enderror                                               
                  </div>
                  
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" @if($cliente) wire:click="updateDireccion" @else wire:click="createDireccion" @endif >
                @if($cliente)
                    Actualizar
                @else
                Guardar
                @endif
              </button>
            </div>
          </div>
        </div>
      </div>
</div>
