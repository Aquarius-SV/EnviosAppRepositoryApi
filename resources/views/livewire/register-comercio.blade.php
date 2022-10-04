<div>
    <form>
        <h4 class="text-center">Datos del encargado</h4>
        <hr>
        <div class="form-outline mb-3">
            <input type="text" class="form-control mb-1   @error('name') is-invalid @enderror" placeholder="Nombre" wire:model="name" />
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-3">
            <input type="email" class="form-control mb-1 @error('email') is-invalid @enderror" placeholder="Correo electrónico" wire:model="email" />
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-3">
            <input type="text" class="form-control mb-1   @error('telefono') is-invalid @enderror" placeholder="Teléfono del encargado" wire:model="telefono" />
            @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-3">
            <input type="text" class="form-control mb-1   @error('dui') is-invalid @enderror" placeholder="DUI" wire:model="dui" />
            @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <hr>
        <h4 class="text-centers">Datos del comercio</h4>
        <hr>
        <div class="form-outline mb-3">
            <input type="text" class="form-control mb-1   @error('comercio') is-invalid @enderror" placeholder="Nombre del comercio" wire:model="comercio" />
            @error('comercio') <span class="text-danger">{{ $message }}</span> @enderror
        </div>   
        
        <div class="form-outline mb-3">                     
            <textarea class="form-control @error('direccion') is-invalid @enderror" placeholder="Dirección del comercio" id="floatingTextarea2" style="height: 100px" wire:model="direccion"></textarea>   
            @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                      
        </div>

        <div class="form-outline mb-3">
            <input type="text" class="form-control mb-1   @error('telefono_comercio') is-invalid @enderror" placeholder="Teléfono del comercio" wire:model="telefono_comercio" />
            @error('telefono_comercio') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" wire:click="sameTel">
            <label class="form-check-label" for="exampleCheck1">utilizar el mismo teléfono del encargado</label>
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



        <div class="form-outline mb-3">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i id="eye" class="fas fa-eye-slash" type="button" onclick="showPasswordRegister()"></i>
                </span>
                
                <input type="password" id="password"  class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña" wire:model="password" aria-describedby="basic-addon1"/>
                
              </div>
              @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-outline mb-3">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">
                    <i id="eye2" class="fas fa-eye-slash" type="button" onclick="showPasswordRegister()"></i>
                    
                </span>
                
                <input type="password" id="confirm_password" class="form-control @error('password_confirmation') is-invalid @enderror"
                placeholder="Confirmación de contraseña" wire:model="password_confirmation" aria-describedby="basic-addon2"/>
                
            </div>
            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
            
        </div>

        







        


        <!---<div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="showPassword()">
            <label class="form-check-label" for="exampleCheck1" >Mostrar contraseña</label>
          </div>-->
        <div class="text-center pt-1 mb-5 pb-1">

            <div class="d-grid gap-2 mb-3">
                <button class="btn btn-primary" type="button" wire:click="store">Registrarme</button>

            </div>


        </div>

      {{--   <div class="d-flex align-items-center justify-content-center pb-4">
            <p class="mb-0 me-2">Ya tienes una cuenta?</p>
            <a href="{{ url('/inicio-sesion') }}" type="button" class="btn btn-outline-danger">Iniciar sesión</a>
        </div> --}}

    </form>
</div>