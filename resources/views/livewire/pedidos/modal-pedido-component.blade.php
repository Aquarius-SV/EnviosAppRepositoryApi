<div>
  <div class=" card-description">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#PedidoModal"><i
        class="typcn typcn-plus mx-0"></i> Nuevo pedido</button>
    <div class="modal fade" id="PedidoModal" tabindex="-1" aria-labelledby="PedidoModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable ">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title col-11 text-center text-black" id="PedidoModalLabel">Nuevo pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
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



            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <button type="button" class="btn btn-primary" wire:click="store">Guardar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

</div>

@push('scripts')
    <script>
       $('#PedidoModal').on('hidden.bs.modal', function (e) {
             Livewire.emit('reset');
         })
         window.addEventListener('closeModal', event => {
         $("#PedidoModal").modal('hide');  
           
           
         });    
         $('#UpdateModal').on('hidden.bs.modal', function (e) {
          Livewire.emit('resetUp');
          });
          window.addEventListener('closeModalUpd', event => {
          $("#UpdateModal").modal('hide');  
          });   
    </script>
@endpush


