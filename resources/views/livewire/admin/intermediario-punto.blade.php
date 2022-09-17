<div>
    <div class="modal fade" id="interModal" tabindex="-1" aria-labelledby="interModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="interModalLabel">Intermediario</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="">Departamento</label>
                        <select class="form-select" aria-label="Selecionar" wire:model="departamento">
                            <option selected>Selecionar</option>
                            @forelse ($departamentos as $dp)
                            <option value="{{ $dp->id }}">{{ $dp->nombre }}</option>
                            @empty
                            <option >No hay datos disponibles</option>
                            @endforelse                                                      
                          </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Municipio</label>
                        <select class="form-select" aria-label="Selecionar" wire:model="municipio">
                            <option selected>Selecionar</option>
                            @forelse ($municipios as $mc)
                            <option value="{{ $mc->id }}">{{ $mc->nombre }}</option>
                            @empty
                            <option >No hay datos disponibles</option>
                            @endforelse   
                          </select>
                    </div>

                    <div class="mb-3">
                        <label for="">Puntos de reparto</label>
                        <select class="form-select" aria-label="Selecionar" wire:model="punto">
                            <option selected>Selecionar</option>
                            @forelse ($puntos as $pt)
                            <option value="{{ $pt->id }}">{{ $pt->nombre }}</option>
                            @empty
                            <option >No hay datos disponibles</option>
                            @endforelse   
                          </select>
                    </div>
                   

                    <div class="mb-3">
                      <label for="">Url</label>
                      <br>
                      {{ $url }}
                    </div>

                  
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="generateUrl">Generar url</button>
            </div>
          </div>
        </div>
      </div>





      <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title text-center col-11" id="detalleModalLabel">Detalle de intermediario</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              
              <form>
                <div class="mb-3">
                  <label  class="form-label">Nombre</label>
                  <input type="nombre" class="form-control" wire:model="nombre" disabled>
                  
                </div>

                <div class="mb-3">
                  <label class="form-label">DUI</label>
                  <input type="text" class="form-control" wire:model="dui" disabled>
                </div>

                <div class="mb-3">
                  <label class="form-label">Correo</label>
                  <input type="text" class="form-control" wire:model="correo" disabled>
                </div>

                <div class="mb-3">
                  <label class="form-label">Teléfono</label>
                  <input type="text" class="form-control" wire:model="telefono" disabled>
                </div>

                <div class="mb-3">
                  <label class="form-label">Cargo</label>
                  <input type="text" class="form-control" value="{{ ($cargo) ? $cargo : 'Cargo no especificado'}}" disabled>
                </div>

                <div class="mb-3">
                  <label class="form-label">Dirección</label>
                  <div class="form-floating">
                    <textarea class="form-control" wire:model="direccion" style="height: 100px" disabled></textarea>
                    
                  </div>
                  
                </div>

               
              
               
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>
</div>
