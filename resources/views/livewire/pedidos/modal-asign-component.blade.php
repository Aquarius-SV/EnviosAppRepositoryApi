<div>
    <div class="modal fade" id="AsignModal" tabindex="-1" aria-labelledby="AsignModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="AsignModalLabel">Reasignamiento de repartidor</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Zonas de entrega</label>
                    <select class="form-select @error('zoneSelected') is-invalid  @enderror" wire:model="zoneSelected">
                      <option style="display:none;">Selecione la zona</option>
                      @foreach ($zones as $zone)
                      <option value="{{ $zone->id_zone }}">{{ $zone->nombre }}</option>
                      @endforeach
                    </select>    
                    @error('zoneSelected') <span class="text-danger text-center">{{ $message }}</span> @enderror
                  </div>            
                  <h3 class="mb-2 text-center text-black">Repartidores</h3>
                  @error('repartidor') <span class="text-danger">{{ $message }}</span> @enderror
                  @if ($zoneSelected <> null)
                    <div class="mb-3">
                      <div class="row">
                        @forelse ($deliveries as $deli)
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
              <button type="button" class="btn btn-primary" wire:click="reasignPedido">Actualizar</button>
            </div>
          </div>
        </div>
      </div>
</div>
@push('scripts')
    <script>
       $('#AsignModal').on('hidden.bs.modal', function (e) {
             Livewire.emit('resetInputAsign');
         })
         window.addEventListener('closeModalReasign', event => {
         $("#AsignModal").modal('hide');  
           
           
         });   
    </script>
@endpush