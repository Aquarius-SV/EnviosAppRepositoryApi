<div>
    <form>
        <div class="form-outline mb-4">
            <input type="text" class="form-control mb-1   @error('name') is-invalid @enderror" placeholder="Nombre" wire:model="name" />
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="email" class="form-control mb-1 @error('email') is-invalid @enderror" placeholder="Correo electrónico" wire:model="email" />
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i id="eye" class="fas fa-eye-slash" type="button" onclick="showPasswordRegister()"></i>
                </span>
                
                <input type="password" id="password"  class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña" wire:model="password" aria-describedby="basic-addon1"/>
                
              </div>
              @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-outline mb-4">
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

        <div class="d-flex align-items-center justify-content-center pb-4">
            <p class="mb-0 me-2">Ya tienes una cuenta?</p>
            <a href="{{ url('/inicio-sesion') }}" type="button" class="btn btn-outline-danger">Iniciar sesión</a>
        </div>

    </form>
</div>