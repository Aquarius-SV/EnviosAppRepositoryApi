<div>
    <div class="modal fade" id="deliveryModal" tabindex="-1" aria-labelledby="deliveryModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="deliveryModalLabel">Edición de perfil</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @error('all') <span class="text-danger text-center">{{ $message }}</span> @enderror
                    <div class="mb-3">
                      <label for="name" class="form-label">Nombre<button type="button" class="btn" wire:click="enabledEdit" >
                        <i class="typcn typcn-edit text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar edición">
                        </i>
                       </button></label>
                      <input type="text" class="form-control pl-1" id="name" wire:model="name" @if($edit == 1)  @else disabled @endif>
                      
                    </div>
                    <hr>
                    <h5 class="mb-3 mt-3" >Cambiar contraseña</h5>
                    <div class="mb-3">
                      <label for="old_pass" class="form-label">Contraseña anterior</label>
                     
                      <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="fas fa-eye-slash" type="button" id="icon1" onclick="showPassword()" ></i>
                        </span>
                        <input type="password" class="form-control pl-1" id="old_pass" aria-describedby="basic-addon1" wire:model="old_pass" @if($edit == 1)  @else disabled @endif>
                        
                      </div>
                    </div>
                    <div class="mb-3">
                        <label for="new_pass" class="form-label">Contraseña nueva</label>
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon2">
                                <i class="fas fa-eye-slash" type="button" id="icon2" onclick="showPassword()" ></i>
                            </span>
                            <input type="password" class="form-control pl-1" id="new_pass" aria-describedby="basic-addon2" wire:model="new_pass" @if($edit == 1)  @else disabled @endif>
                            
                          </div>
                      </div>
                  
                    <div class="form-outline mb-3 ">
                        <div class="row">
                            <div class="col">
                              <label for="dui" class="form-label">DUI</label>
                                <input type="text" id="dui" placeholder="DUI" class="form-control pl-1 @error('dui') is-invalid @enderror" wire:model="dui" @if($edit == 1)  @else disabled @endif>
                                @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col">
                              <label for="nit" class="form-label">NIT</label>
                                <input type="text" placeholder="NIT" id="nit" class="form-control pl-1 @error('nit') is-invalid @enderror" wire:model="nit" @if($edit == 1)  @else disabled @endif>
                                @error('nit') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                          </div>                          
                    </div>
                    <div class="form-outline mb-3 ">
                        <div class="row">
                            <div class="col">
                              <label for="phone" class="form-label">Telefono</label>
                                <input type="text" placeholder="Telefono" id="phone" class="form-control pl-1 @error('phone') is-invalid @enderror" wire:model="phone" @if($edit == 1)  @else disabled @endif>
                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col">
                              <label for="license" class="form-label">Licencia de conducir</label>
                                <input type="text" placeholder="Licencia de conducir" id="license" class="form-control pl-1 @error('license') is-invalid @enderror" wire:model="license" @if($edit == 1)  @else disabled @endif>
                                @error('license') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                          </div>            
                    </div>
                    
                    <label class="mb-3 mt-3">Datos del Vehiculo</label>  
                    <div class="form-outline mb-3 ">
                        <div class="row">
                            <div class="col">
                              <label for="vehicle" class="form-label">Tipo de vehiculo</label>
                                <input type="text" placeholder="Tipo de vehiculo" id="vehicle" class="form-control pl-1 @error('vehicle') is-invalid @enderror" wire:model="vehicle" @if($edit == 1)  @else disabled @endif>
                                @error('vehicle') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col">
                              <label for="placa" class="form-label">Placa</label>
                                <input type="text" placeholder="Placa" id="placa" class="form-control pl-1 @error('placa') is-invalid @enderror" wire:model="placa" @if($edit == 1)  @else disabled @endif>
                                @error('placa') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                          </div>            
                    </div>
                    <div class="form-outline mb-3 ">
                        <div class="row">
                            <div class="col">
                              <label for="vehicle_model" class="form-label">Modelo del vehiculo</label>
                                <input type="text" placeholder="Modelo del vehiculo" id="vehicle_model" class="form-control pl-1 @error('vehicle_model') is-invalid @enderror" wire:model="vehicle_model" @if($edit == 1)  @else disabled @endif>
                                @error('vehicle_model') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            
                          </div>            
                    </div>
                    <div class="form-outline mb-3 ">
                        <div class="row">
                            <div class="col">
                              <label for="color" class="form-label">Color del vehiculo</label>
                                <input type="text" placeholder="Color del vehiculo" id="color" class="form-control pl-1 @error('color') is-invalid @enderror" wire:model="color" @if($edit == 1)  @else disabled @endif>
                                @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col">
                              <label for="brand" class="form-label">Marca del vehiculo</label>
                                <input type="text" placeholder="Marca del vehiculo" id="brand" class="form-control pl-1 @error('brand') is-invalid @enderror" wire:model="brand" @if($edit == 1)  @else disabled @endif>
                                @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                          </div>            
                    </div>
                    <div class="form-outline mb-3 ">
                        <div class="row">
                            <div class="col">
                              <label for="peso" class="form-label">Peso máximo que tu vehículo soporta</label>
                                <input type="text" placeholder="Peso máximo que tu vehículo soporta" id="peso" class="form-control pl-1 @error('peso') is-invalid @enderror" wire:model="peso" @if($edit == 1)  @else disabled @endif>
                                @error('peso') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>               
                          </div>            
                    </div>
                    <div class="form-outline mb-3 ">
                        <div class="row">
                            <div class="col">
                              <label for="size" class="form-label">Tamaño máximo del paquete que tu vehículo podrá cargar</label>
                                <input type="text" placeholder="Tamaño máximo del paquete que tu vehículo podrá cargar" id="size" class="form-control pl-1 @error('size') is-invalid @enderror" wire:model="size" @if($edit == 1)  @else disabled @endif>
                                @error('size') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>               
                          </div>            
                    </div>
                    <label class="mb-3 mt-3">Zonas de entrega</label>  
                    @foreach ($deliveryManZones as $zoneMan)
                    <ul class="list-group">
                      <li class="list-group-item">{{ $zoneMan->nombre }}</li>                      
                    </ul>
                    @endforeach
                    
                    
                    
                    
                    
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="updateProfileDelivery">Actualizar</button>
            </div>
          </div>
        </div>
      </div>
</div>


@push('scripts')
<script>
    function showPassword() {
      var old_pass = document.getElementById("old_pass");
      var new_pass = document.getElementById("new_pass");
      var icon1 = document.getElementById("icon1");
      var icon2 = document.getElementById("icon2");
      if (old_pass.type === "password") {
          old_pass.type = "text";
          new_pass.type = "text";
          icon1.classList.remove("fa-eye-slash");
          icon2.classList.remove("fa-eye-slash");                
          icon1.classList.add("fa-eye");
          icon2.classList.add("fa-eye");
      } else {
          old_pass.type = "password";
          new_pass.type = "password";

          icon1.classList.remove("fa-eye");
          icon2.classList.remove("fa-eye");
          icon1.classList.add("fa-eye-slash")
          icon2.classList.add("fa-eye-slash")
      }
    }
  </script>
  <script>
    $('#deliveryModal').on('hidden.bs.modal', function (e) {
          Livewire.emit('resetDelivery');
      })       
 </script>
@endpush
