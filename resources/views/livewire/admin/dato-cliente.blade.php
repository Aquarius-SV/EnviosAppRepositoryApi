<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#datoClienteModal">
        <i class="typcn typcn-plus mx-0"></i> Nuevo
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="datoClienteModal" tabindex="-1" aria-labelledby="datoClienteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title col-11 text-center" id="datoClienteModalLabel">Datos clientes</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                      <label class="form-label">Nombre</label>
                      <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                      @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Telefono</label>
                      <input type="text" class="form-control @error('telefono') is-invalid @enderror" wire:model="telefono">
                      @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Dirección</label>
                        <textarea class="form-control  @error('direccion') is-invalid @enderror" placeholder="Digita la dirección" style="height: 100px" wire:model="direccion"></textarea> 
                        @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                                                     
                    </div>

                    <div class="mb-3">
                        <label for="">Departamento</label>
                        <select class="form-select  @error('departamento') is-invalid @enderror" aria-label="Seleciona" wire:model="departamento">
                            <option selected style="display: none">Seleciona</option>
                            @forelse ($departamentos as $dp)
                            <option value="{{ $dp->id }}">{{ $dp->nombre }}</option>
                            @empty
                            <option>No hay opciones disponibles</option>
                            @endforelse                                                        
                          </select>
                          @error('departamento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="">Municipio</label>
                        <select class="form-select @error('municipio') is-invalid @enderror" aria-label="Seleciona" wire:model="municipio">
                            <option selected style="display: none">Seleciona</option>
                            @forelse ($municipios as $mc)
                            <option value="{{ $mc->id }}">{{ $mc->nombre }}</option>
                            @empty
                            <option>No hay opciones disponibles</option>
                            @endforelse                                                        
                          </select>
                          @error('municipio') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                   
                  </form>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" @if($id_comercio) wire:click="updateComercio" @else wire:click="createDatoCliente" @endif>{{ ($id_comercio) ? 'Actualizar' : 'Guardar' ; }}</button>
            </div>
        </div>
        </div>
    </div>
</div>
