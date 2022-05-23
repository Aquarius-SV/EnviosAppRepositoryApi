<div>
    <form>
        @error('error-all') <span class="text-danger">{{ $message }}</span> @enderror
        <br>
        <label for="">Datos personales </label>
        <br> 
        <div class="form-outline mb-4">
            <input type="text"  class="form-control @error('name') is-invalid @enderror" 
                placeholder="Nombre completo" wire:model="name" />
                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="email"  class="form-control @error('email') is-invalid @enderror"
                placeholder="Correo electrónico" wire:model="email"/>
                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="password"  class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña" wire:model="password" />
                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-outline mb-4">
            <input type="password" class="form-control @error('confirm_password') is-invalid @enderror"
                placeholder="Confirmación de contraseña" wire:model="confirm_password" />
                @error('confirm_password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4 ">
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="DUI" class="form-control @error('dui') is-invalid @enderror" wire:model="dui">
                    @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col">
                    <input type="text" placeholder="NIT" class="form-control @error('nit') is-invalid @enderror" wire:model="nit">
                    @error('nit') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>                          
        </div>
        <div class="form-outline mb-4 ">
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Telefono" class="form-control @error('phone') is-invalid @enderror" wire:model="phone">
                    @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col">
                    <input type="text" placeholder="Licencia de conducir" class="form-control @error('license') is-invalid @enderror" wire:model="license">
                    @error('license') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>            
        </div>
        
        <label for="">Datos del Vehiculo</label>  
        <div class="form-outline mb-4 ">
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Tipo de vehiculo" class="form-control @error('vehicle') is-invalid @enderror" wire:model="vehicle">
                    @error('vehicle') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col">
                    <input type="text" placeholder="Placa" class="form-control @error('placa') is-invalid @enderror" wire:model="placa">
                    @error('placa') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>            
        </div>
        <div class="form-outline mb-4 ">
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Modelo del vehiculo" class="form-control @error('vehicle_model') is-invalid @enderror" wire:model="vehicle_model">
                    @error('vehicle_model') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                
              </div>            
        </div>
        <div class="form-outline mb-4 ">
            <div class="row">
                <div class="col">
                    <input type="text" placeholder="Color del vehiculo" class="form-control @error('color') is-invalid @enderror" wire:model="color">
                    @error('color') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col">
                    <input type="text" placeholder="Marca del vehiculo" class="form-control @error('brand') is-invalid @enderror" wire:model="brand">
                    @error('brand') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
              </div>            
        </div>
        <br>
        <div class="form-outline mb-4 ">
            
              
            <label for="">Areas de trabajo </label>                      
            <br>
            <p class="text-white badge bg-primary"><i class="fas fa-info-square"></i> Puedes seleccionar multiples zonas</p>
            <select class="form-select @error('zones') is-invalid @enderror" aria-label="Areas de trabajo" multiple style="overflow-y: auto" wire:model="zones">    
                @forelse ($zonaList as $z)
                <option value="{{ $z->id_zona }}">{{ $z->nombre }}</option>
                @empty
                <option disabled>No hay opciones</option>
                
                @endforelse                                       
                
                
            </select>
            @error('zones') <span class="text-danger">{{ $message }}</span> @enderror
        </div>





        <div class="text-center pt-1 mb-5 pb-1">

            <div class="d-grid gap-2 mb-3">
                <button class="btn btn-primary" type="button" wire:click="store">Registrarme</button>

            </div>


        </div>

        <div class="d-flex align-items-center justify-content-center pb-4">
            <p class="mb-0 me-2">¿Ya tienes una cuenta?</p>
            <a href="{{ url('/inicio-sesion') }}" type="button"
                class="btn btn-outline-danger">Iniciar Sesión</a>
        </div>

    </form>
</div>
