<div>
    <div class="modal fade" id="puntoModal" tabindex="-1" aria-labelledby="puntoModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="puntoModalLabel">
                @if ($punto)
                Actualización de punto de reparto
                @else
                Nuevo punto de reparto
                @endif
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             
                <form>
                    <div class="mb-3">
                      <label for="nombre" class="form-label">Nombre <span class="text-danger">*</span></label>
                      <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" wire:model="nombre">   
                      @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror                  
                    </div>
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Dirección<span class="text-danger">*</span></label>
                        <div class="form-floating">
                            <textarea class="form-control @error('direccion') is-invalid @enderror" placeholder="Digite la dirección" 
                            id="direccion" style="height: 100px" wire:model="direccion"></textarea>                            
                        </div>
                        @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                      <label for="telefono" class="form-label">Teléfono<span class="text-danger">*</span></label>
                      <input type="text" class="form-control  @error('telefono') is-invalid @enderror" id="telefono" wire:model="telefono">
                      @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="telefono" class="form-label">Departamento<span class="text-danger">*</span></label>
                            <select class="form-select @error('departamento') is-invalid @enderror" aria-label="Selecciona" wire:model="departamento">
                                <option selected style="display: none;">Selecciona</option>
                                @forelse ($departamentos as $dps)
                                <option value="{{ $dps->id }}">{{ $dps->nombre }}</option>
                                @empty
                                <option>No hay datos disponible</option>
                                @endforelse
                              </select>
                              @error('departamento') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
    
                        <div class="mb-3 col-6">
                            <label for="municipio" class="form-label">Municipio<span class="text-danger">*</span></label>
                            <select class="form-select  @error('municipio') is-invalid @enderror" aria-label="Selecciona" wire:model="municipio">
                                <option selected style="display: none;">Selecciona</option>
                                @forelse ($municipios as $mns)
                                <option value="{{ $mns->id }}">{{ $mns->nombre }}</option>
                                @empty
                                <option>No hay datos disponible</option>
                                @endforelse                                
                              </select>
                              @error('municipio') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                      <label for="empresa" class="form-label">Nombre empresa(opcional)</label>
                      <input type="text" class="form-control @error('empresa') is-invalid @enderror" id="empresa" wire:model="empresa">
                      @error('empresa') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                      <label for="correo" class="form-label">Correo empresarial(opcional)</label>
                      <input type="text" class="form-control @error('correo_empresarial') is-invalid @enderror" id="correo" wire:model="correo_empresa">
                      @error('correo_empresarial') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                      <label for="correoE" class="form-label">Nombre encargado(opcional)</label>
                      <input type="text" class="form-control @error('nombre_propietario') is-invalid @enderror" id="correoE" wire:model="nombre_propietario">

                      @error('nombre_propietario') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    
                    
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" @if($punto) wire:click="updatePunto" @else wire:click="savePunto" @endif >
                @if ($punto)
                    Actualizar
                @else
                    Guardar
                @endif
              </button>
            </div>
          </div>
        </div>
      </div>


      <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center col-11" id="detalleModalLabel">Detalle de punto de reparto</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" wire:model="nombre" disabled>   
                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror                  
              </div>
              <div class="mb-3">
                  <label for="nombre" class="form-label">Dirección</label>
                  <div class="form-floating">
                      <textarea class="form-control @error('direccion') is-invalid @enderror" placeholder="Digite la dirección" 
                      id="direccion" style="height: 100px" wire:model="direccion" disabled></textarea>                            
                  </div>
                  @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
              <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control  @error('telefono') is-invalid @enderror" id="telefono" wire:model="telefono" disabled>
                @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
              </div>


              <div class="row">
                <div class="mb-3 col-6">
                  <label for="nombre" class="form-label">Departamento </label>
                  <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" wire:model="dep_nombre" disabled>   
                  @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror                  
                </div>

                <div class="mb-3 col-6">
                  <label for="nombre" class="form-label">Municipio</label>
                  <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" wire:model="mun_nombre" disabled>   
                  @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror                  
                </div>
              </div>

              <div class="mb-3">
                <label for="empresa" class="form-label">Nombre empresa</label>
                <input type="text" class="form-control @error('empresa') is-invalid @enderror" id="empresa" value="{{ ($empresa) ? $empresa : 'Sin datos'  }}" disabled>
                @error('empresa') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
              
              <div class="mb-3">
                <label for="correo" class="form-label">Correo empresarial</label>
                <input type="text" class="form-control @error('correo_empresarial') is-invalid @enderror" id="correo" value="{{ ($correo_empresa) ? $correo_empresa : 'Sin datos'  }}" disabled>
                @error('correo_empresarial') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class="mb-3">
                <label for="correoE" class="form-label">Nombre encargado</label>
                <input type="text" class="form-control @error('nombre_propietario') is-invalid @enderror" id="correoE" value="{{ ($nombre_propietario) ? $nombre_propietario : 'Sin datos'  }}" disabled>

                @error('nombre_propietario') <span class="text-danger">{{ $message }}</span> @enderror
              </div>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>





</div>


@push('scripts')
  <script type="text/javascript">
  var puntoModal = document.getElementById('puntoModal')
  puntoModal.addEventListener('hidden.bs.modal', function (event) {
    Livewire.emit('resetPuntoVars');
  }); 
  </script>
@endpush
