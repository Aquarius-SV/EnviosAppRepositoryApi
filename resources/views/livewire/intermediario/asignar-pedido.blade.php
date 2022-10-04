<div>
    <div class="modal fade" id="reasignarModal" tabindex="-1" aria-labelledby="reasignarModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="reasignarModalLabel">Asignación de pedido</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
             {{--  @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif --}}
                
              <div class="mb-3">
                <label for="">Punto de entrega</label>
                <select class="form-select @error('entrega') is-invalid @enderror" aria-label="Seleciona" wire:model="entrega">
                  <option selected style="display: none">Seleciona</option>
                  <option value="Cliente">Cliente final</option>
                  <option value="Punto">Punto de reparto</option>                  
                </select>
                @error('entrega') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              @if ($entrega == "Punto")
                <div class="mb-3">
                  <div class="row">
                    <div class="col-6">
                      <label for="">Departamento</label>
                      <select class="form-select @error('departamento_punto') is-invalid @enderror" aria-label="Seleciona" wire:model="departamento_punto">
                        <option style="display: none" selected>Seleciona</option>
                        @forelse ($departamentos as $dp)
                        <option value="{{ $dp->id }}">{{ $dp->nombre }}</option>
                        @empty
                        <option>No hay datos disponibles</option>
                        @endforelse                                                                    
                      </select>
                      @error('departamento_punto') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                      <label for="">Municipio</label>
                      <select class="form-select @error('municipio_punto') is-invalid @enderror" aria-label="Seleciona" wire:model="municipio_punto">
                        <option style="display: none" selected>Seleciona</option>
                        @forelse ($municipios_puntos as $mc)
                        <option value="{{ $mc->id }}">{{ $mc->nombre }}</option>
                        @empty
                        <option>No hay datos disponibles</option>
                        @endforelse                                                                    
                      </select>
                      @error('municipio_punto') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                  </div>                 
                </div>

                <div class="mb-3">
                  <label for="">Punto de reparto</label>
                  <select class="form-select @error('punto') is-invalid @enderror" aria-label="Seleciona" wire:model="punto">
                    <option selected style="display: none">Seleciona</option>
                    @forelse ($zonaPuntos as $zp)
                    <option value="{{ $zp->id }}">{{ $zp->nombre }}</option>
                    @empty
                    <option >No hay datos disponibles</option>
                    @endforelse                                                           
                  </select>
                  @error('punto') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              <hr>
              <h3 class="mb-2 text-center">Envío</h3>
              <hr>
              @endif
                <div class="mb-3">
                  <div class="row">
                    <div class="col-6">
                      <label for="">Departamento</label>
                      <select class="form-select @error('departamento') is-invalid @enderror" aria-label="Seleciona" wire:model="departamento">
                        <option style="display: none" selected>Seleciona</option>
                        @forelse ($departamentos as $dp)
                        <option value="{{ $dp->id }}">{{ $dp->nombre }}</option>
                        @empty
                        <option>No hay datos disponibles</option>
                        @endforelse                                                                    
                      </select>
                      @error('departamento') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-6">
                      <label for="">Municipio</label>
                      <select class="form-select @error('municipio') is-invalid @enderror" aria-label="Seleciona" wire:model="municipio">
                        <option style="display: none" selected>Seleciona</option>
                        @forelse ($municipios as $mc)
                        <option value="{{ $mc->id }}">{{ $mc->nombre }}</option>
                        @empty
                        <option>No hay datos disponibles</option>
                        @endforelse                                                                    
                      </select>
                      @error('municipio') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                  </div>                 
                </div>


                <div class="mb-3">
                  <label for="">Zona</label>
                  <select class="form-select @error('zona') is-invalid @enderror" aria-label="Seleciona" wire:model="zona">
                    <option style="display: none" selected>Seleciona</option>
                    @forelse ($zonas as $zn)
                      <option value="{{ $zn->id_zone }}">{{ $zn->nombre }}</option>
                    @empty
                      <option>No hay datos disponibles</option>
                    @endforelse  
                  </select>
                  @error('zona') <span class="text-danger">{{ $message }}</span> @enderror
                </div>


                @if ($zona <> null)
                <div class="mb-3">
                  <div class="row">
                    @error('repartidor') <span class="text-danger">{{ $message }}</span> @enderror
                    @forelse ($repartidores as $deli)
                    <div class="col-sm-6">
                      <div class="card mb-3">
                        <div class="card-body text-center mx-center">
                          <h5 class="card-title">
                            <div class="form-floating mb-3">
                              <input type="radio" value="{{ $deli->id_repartidor }}" wire:model="repartidor">
                              {{ $deli->nombre }}
                            </div>    
                          </h5>
                          <br>
                          <img src="{{ asset('admin/images/faces/profile.png') }}" class=" mb-2" width="125" height="125">
                          <p class="card-text">
                            <li>
                              Vehiculo: {{ $deli->tipo_vehiculo }}
                            </li>
                            <li>
                              Marca: {{ $deli->marca }}
                            </li>
                            <li>
                              Modelo: {{ $deli->modelo }}
                            </li>
                            <li>
                              Peso maximo del paquete: {{ $deli->peso }}
                            </li>
                            <li>
                              Tamaño maximo del paquete: {{ $deli->size }}
                            </li>
                          </p>                              
                        </div>
                      </div>
                    </div>
                    @empty
                    <h2 class="text-center">No hay repartidores disponibles para esta zona</h2>
                    @endforelse                                
                  </div>
                </div>                                   
             @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary"wire:click="reassignPedido" >Asignar</button>
            </div>
          </div>
        </div>
      </div>
</div>
