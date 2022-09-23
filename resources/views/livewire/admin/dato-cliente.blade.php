<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#datoClienteModal">
        <i class="typcn typcn-plus mx-0"></i> Nuevo
    </button>
    
    <!-- Modal -->
    <div class="modal fade" id="datoClienteModal" tabindex="-1" aria-labelledby="datoClienteModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title col-11 text-center" id="datoClienteModalLabel">Comercio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                      <label class="form-label">Nombre del comercio</label>
                      <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                      @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                      <label  class="form-label">Teléfono</label>
                      <input type="text" class="form-control @error('telefono') is-invalid @enderror" wire:model="telefono">
                      @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <label>Dirección del comercio</label>
                        <textarea class="form-control  @error('direccion') is-invalid @enderror" placeholder="Digita la dirección" style="height: 100px" wire:model="direccion"></textarea> 
                        @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                                                     
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nombre del encargado</label>
                        <input type="text" class="form-control @error('encargado') is-invalid @enderror" wire:model="encargado">
                        @error('encargado') <span class="text-danger">{{ $message }}</span> @enderror
                      </div>
                      <div class="mb-3">
                        <label  class="form-label">Teléfono del encargado</label>
                        <input type="text" class="form-control @error('tel_encargado') is-invalid @enderror" wire:model="tel_encargado">
                        @error('tel_encargado') <span class="text-danger">{{ $message }}</span> @enderror
                      </div>

                        <div class="mb-3">
                        <label  class="form-label">DUI</label>
                        <input type="text" class="form-control @error('dui') is-invalid @enderror" wire:model="dui">
                        @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
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




    <div class="modal fade" id="direccionRecogidaModal" tabindex="-1" aria-labelledby="listaDireccionesModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="listaDireccionesModalLabel">Dirección de recogida</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <div class="mb-3">
                    <label for="">Nombre de la dirección</label>
                    <input type="text" class="form-control @error('nombre_direccion_recogida') is-invalid @enderror" wire:model="nombre_direccion_recogida"> 
                    @error('nombre_direccion_recogida') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="mb-3">
                    <label for="">Dirección</label>
                    <textarea style="height: 100px" class="form-control @error('direccion_recogida') is-invalid @enderror" wire:model="direccion_recogida"></textarea>
                    @error('direccion_recogida') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="DireccioneRecogida">{{ ($id_direccion_comercio) ? 'Actualizar' : 'Guardar' ; }}</button>
            </div>
          </div>
        </div>
      </div>



      <div class="modal fade" id="listaDireccionesModal" tabindex="-1" aria-labelledby="listaDireccionesModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="listaDireccionesModalLabel">Direcciones del comercio: {{ $nombre_comercio }}</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <button class="btn btn-primary" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#direccionRecogidaModal">
                    <i class="typcn typcn-plus mx-0 "></i>
                </button>
                <table id="listTable" class="display nowrap table responsive" style="width:100%" wire:ignore.self>
                    <thead>
                      <tr>
                        <th scope="col">Nombre</th>
                        <th scope="col">Dirección</th>
                        <th scope="col">Acciones</th>                        
                      </tr>
                    </thead>
                    <tbody>
                        @forelse ($direcciones_comercios as $dr)
                        <tr>
                            <td class="text-break">{{ $dr->nombre }}</td>
                            <td class="text-break">{{ $dr->direccion }}</td>
                            <td>
                                <button class="btn" wire:click="assignDireccionComercio(@js($dr))" data-bs-toggle="modal" data-bs-target="#direccionRecogidaModal">
                                    <i class="typcn typcn-edit mx-0 text-success"></i>
                                </button>


                                {{-- <button class="btn">
                                    <i class="typcn typcn-trash mx-0 text-danger"></i>
                                </button> --}}
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
      </div>

</div>



@push('scripts')
<script>
  var datoClienteModal = document.getElementById('datoClienteModal')
  datoClienteModal.addEventListener('hidden.bs.modal', function (event) {
    Livewire.emit('resetDatosComercio');
  });

  var direccionRecogidaModal = document.getElementById('direccionRecogidaModal')
  direccionRecogidaModal.addEventListener('hidden.bs.modal', function (event) {
    Livewire.emit('resetDataDirecciones');
  });

  
</script>    
@endpush










