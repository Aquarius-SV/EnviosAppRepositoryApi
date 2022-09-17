<div>
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#direccionRecogidaModal">
        <i class="typcn typcn-plus"></i> Nueva
    </button>



    <div class="modal fade" id="direccionRecogidaModal" tabindex="-1" aria-labelledby="direccionRecogidaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="direccionRecogidaModalLabel">Dirección del cliente</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             <div class="mb-3">
                <label for="">Nombre</label>
                <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
             </div>

             <div class="mb-3">
              <label for="">DUI</label>
              <input type="text" class="form-control @error('dui') is-invalid @enderror" wire:model="dui">
              @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
              <label for="">Teléfono</label>
              <input type="text" class="form-control @error('telefono') is-invalid @enderror" wire:model="telefono">
              @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
           </div>

           <div class="form-check mb-3">
            <input id="flexCheckDefault" type="checkbox" wire:click="samePhone"> Usar el mismo número          
          </div>


            <div class="mb-3">
              <label for="">Teléfono whatsapp</label>
              <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" wire:model="whatsapp">
              @error('whatsapp') <span class="text-danger">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-3">
              <label for="">Correo</label>
              <input type="email" class="form-control @error('correo') is-invalid @enderror" wire:model="correo">
              @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
            </div>     

             <div class="mb-3">
                <label for="floatingTextarea2">Dirección</label>
                <textarea class="form-control @error('direccion') is-invalid @enderror" placeholder="Ingresa la dirección" id="floatingTextarea2" style="height: 100px" wire:model="direccion"></textarea>    
                @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                                 
             </div>

              <div class="mb-3">
                <label for="floatingTextarea2">Referencia</label>
                <textarea class="form-control @error('referencia') is-invalid @enderror" placeholder="Ingresa la referencia" id="floatingTextarea2" style="height: 100px" wire:model="referencia"></textarea>    
                @error('referencia') <span class="text-danger">{{ $message }}</span> @enderror                                 
              </div>


              <div class="row">
                <div class="col-6 mb-3">
                  <label for="">Departamento</label>
                  <select class="form-select  @error('departamento') is-invalid @enderror" aria-label="Seleciona" wire:model="departamento">
                    <option selected style="display: none">Seleciona</option>
                    @forelse ($departamentos as $dp)
                    <option value="{{ $dp->id }}">{{ $dp->nombre }}</option>
                    @empty
                    <option >No hay opciones disponibles</option>
                    @endforelse                                                           
                  </select>
                  @error('departamento') <span class="text-danger">{{ $message }}</span> @enderror  
                </div>

                <div class="col-6 mb-3">
                  <label for="">Municipio</label>
                  <select class="form-select @error('municipio') is-invalid @enderror" aria-label="Seleciona" wire:model="municipio">
                    <option selected style="display: none">Seleciona</option>
                    @forelse ($municipios as $mc)
                    <option value="{{ $mc->id }}">{{ $mc->nombre }}</option>
                    @empty
                    <option >No hay opciones disponibles</option>
                    @endforelse   
                  </select>
                  @error('municipio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
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
