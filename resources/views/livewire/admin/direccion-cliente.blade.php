<div>
    
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#direccionEntregaModal">
      <i class="typcn typcn-plus"></i>Nuevo
    </button>
  


    {{-- <div class="modal fade" id="listDireccionEntregaModal" tabindex="-1" aria-labelledby="listDireccionEntregaModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title col-11 text-center" id="listDireccionEntregaModalLabel">Direcciones de los clientes del comercio: {{ $comercio_nombre }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <button type="button" class="btn btn-primary mb-3" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#direccionEntregaModal">
              <i class="typcn typcn-plus"></i> Nueva
          </button>
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">Cod</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">DUI</th>  
                    <th>Acciones</th>                  
                  </tr>
                </thead>
                <tbody>
                  @forelse ($direcciones as $drs)
                  <tr>
                    <td>{{ $drs->cod }}</td>
                    <td>{{ $drs->nombre }}</td>
                    <td>{{ $drs->dui }}</td>  
                    <td>
                      <div class="dropdown">
                        <button class="btn" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                          <i class="typcn typcn-th-menu"></i>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">

                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('assigDireccionRecogida',@js($drs))" data-bs-toggle="modal" data-bs-target="#detalleDireccionClienteModal">Detalle</a></li>

                          <li><a class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#direccionEntregaModal"
                             onclick="Livewire.emit('assigDireccionRecogida',@js($drs))">Editar</a></li>
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('deleteQuestionDireccionRecogida',@js($drs->id))">Eliminar</a></li>
                          @if ($drs->estado == 1)
                          <li><a class="dropdown-item" type="button" onclick="Livewire.emit('disableQuestionDireccion',@js($drs->id))">Desactivar</a></li>
                          @endif
                          
                        </ul>
                      </div>
                    </td>                  
                  </tr>
                  @empty
                      
                  @endforelse
                  
                 
                </tbody>
              </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            
          </div>
        </div>
      </div>
    </div> --}}






















    <div class="modal fade" id="direccionEntregaModal" tabindex="-1" aria-labelledby="direccionEntregaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="direccionEntregaModalLabel">Dirección del cliente</h5>
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








      
    <div class="modal fade" id="detalleDireccionClienteModal" tabindex="-1" aria-labelledby="detalleDireccionClienteModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title col-11 text-center" id="detalleDireccionClienteModalLabel">Dirección del cliente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
           <div class="mb-3">
              <label for="">Nombre</label>
              <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre" disabled>
              @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
           </div>

           <div class="mb-3">
            <label for="">DUI</label>
            <input type="text" class="form-control @error('dui') is-invalid @enderror" wire:model="dui" disabled>
            @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
          </div>

          <div class="mb-3">
            <label for="">Teléfono</label>
            <input type="text" class="form-control @error('telefono') is-invalid @enderror" wire:model="telefono" disabled>
            @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
         </div>

       


          <div class="mb-3">
            <label for="">Teléfono whatsapp</label>
            <input type="text" class="form-control @error('whatsapp') is-invalid @enderror" wire:model="whatsapp" disabled>
            @error('whatsapp') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
          
          <div class="mb-3">
            <label for="">Correo</label>
            <input type="email" class="form-control @error('correo') is-invalid @enderror" wire:model="correo" disabled>
            @error('correo') <span class="text-danger">{{ $message }}</span> @enderror
          </div>     

           <div class="mb-3">
              <label for="floatingTextarea2">Dirección</label>
              <textarea class="form-control @error('direccion') is-invalid @enderror" placeholder="Ingresa la dirección" id="floatingTextarea2" style="height: 100px" wire:model="direccion" disabled></textarea>    
              @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                                 
           </div>

            <div class="mb-3">
              <label for="floatingTextarea2">Referencia</label>
              <textarea class="form-control @error('referencia') is-invalid @enderror" placeholder="Ingresa la referencia" id="floatingTextarea2" style="height: 100px" wire:model="referencia" disabled></textarea>    
              @error('referencia') <span class="text-danger">{{ $message }}</span> @enderror                                 
            </div>


            <div class="row">
              <div class="col-6 mb-3">
                <label for="">Departamento</label>
                <select class="form-select  @error('departamento') is-invalid @enderror" aria-label="Seleciona" wire:model="departamento" disabled>
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
                <select class="form-select @error('municipio') is-invalid @enderror" aria-label="Seleciona" wire:model="municipio" disabled>
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
            <select class="form-select" wire:model="estado" disabled>    
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
            
          </div>
        </div>
      </div>
    </div>












</div>
