<div>
  <div class=" card-description">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#PedidoModal"><i
        class="typcn typcn-plus mx-0"></i> Nuevo pedido</button>
    <div class="modal fade" id="PedidoModal" tabindex="-1" aria-labelledby="PedidoModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title col-11 text-center text-black" id="PedidoModalLabel">Nuevo pedido</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ></button>
          </div>
          <div class="modal-body">
            <form>  
              <h3 class="text-center text-black">Direcciones y datos del cliente</h3>    
              <hr>       
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
                <label for="referencia" class="form-label">Referencia</label>
                <input type="text" class="form-control @error('referencia') is-invalid @enderror" id="referencia" wire:model="referencia">
                @error('referencia') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class="mb-3">
                <label for="">Departamento</label>
                <select class="form-select @error('departamento') is-invalid @enderror" aria-label="Selecione el departamento" wire:model="departamento">
                  <option style="display: none;">Selecione el departamento</option>
                  @forelse ($departamentos as $dp)
                  <option value="{{ $dp->id }}">{{ $dp->nombre }}</option>
                  @empty
                  <option>No hay datos disponibles</option>
                  @endforelse                                          
                </select>
                @error('departamento') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

            
                  <div class="mb-3">
                    <label for="">Municipio</label>
                    <select class="form-select @error('municipio') is-invalid @enderror" aria-label="Selecione el municipio" wire:model="municipio">
                      <option style="display: none;">Selecione el municipio</option>
                      @forelse ($municipios as $mp)
                      <option value="{{ $mp->id }}">{{ $mp->nombre }}</option>
                      @empty
                      <option>No hay datos disponibles</option>
                      @endforelse                                          
                    </select>
                    @error('municipio') <span class="text-danger">{{ $message }}</span> @enderror
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
                <label for="nombre" class="form-label">Nombre del cliente</label>
                <input type="text" class="form-control @error('cliente') is-invalid @enderror" id="nombre" wire:model="cliente">
                @error('cliente') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class="mb-3">
                <label for="dui" class="form-label">DUI del cliente</label>
                <input type="text" class="form-control  @error('dui') is-invalid @enderror" id="dui" wire:model="dui">
                @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
              </div>                            
              <hr>
              <h3 class="text-center text-black">Datos del paquete</h3> 
              <hr>
              <div class="mb-3">
                <label class="form-label">Peso del paquete</label>
                <input type="text" class="form-control @error('peso') is-invalid @enderror"  wire:model="peso" placeholder="(Libras)">
                @error('peso') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
              <div class="mb-3">
                <label class="form-label">Alto</label>
                <input type="text" class="form-control @error('alto') is-invalid @enderror"  wire:model="alto" placeholder="(centímetros)">
                @error('alto') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Ancho</label>
                <input type="text" class="form-control @error('antho') is-invalid @enderror"  wire:model="ancho" placeholder="(centímetros)">
                @error('ancho') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Profundidad</label>
                <input type="text" class="form-control @error('profundidad') is-invalid @enderror"  wire:model="profundidad" placeholder="(centímetros)">
                @error('profundidad') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
              <hr>

              <div class=" mb-3">
                <label class="form-label">¿El paquete es fragil?</label>
                <select class="form-select @error('fragil') is-invalid @enderror" aria-label="Fragil" wire:model="fragil">  
                  <option style="display: none;">Seleciona una opción</option> 
                  <option value="0">No</option>                
                  <option value="1">Si</option>                  
                </select>
                @error('fragil') <span class="text-danger">{{ $message }}</span> @enderror
              </div>

              <div class=" mb-3">
                <label class="form-label">Embalaje</label>
                <select class="form-select @error('embalaje') is-invalid @enderror"  wire:model="embalaje">  
                  <option style="display: none;">Seleciona una opción</option> 
                  <option value="Bolsa">Bolsa</option>                
                  <option value="Caja">Caja</option>
                  <option value="Otros">Otros</option>                  
                </select>
                @error('embalaje') <span class="text-danger">{{ $message }}</span> @enderror
              </div>
              <hr>
              <h3 class="text-center text-black">Envío</h3>    
              <hr> 
              <div class="mb-3">
                <label for="">Tipo de envío</label>
                <select class="form-select @error('envio') is-invalid @enderror" aria-label="Seleciona una opción" wire:model="envio">
                  <option selected>Seleciona una opción</option>
                  <option value="Normal">Normal</option>
                  <option value="Express">Express</option>                  
                </select>
                @error('envio') <span class="text-danger">{{ $message }}</span> @enderror
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
                          <div class="overflo-scroll">
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


