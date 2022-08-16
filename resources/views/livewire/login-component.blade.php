<div>
   
    <form>
                    
  
        <div class="form-outline mb-4">
          <input type="email" id="form2Example11" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electrónico" wire:model="email" />            
          @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
          <div class="input-group mb-3">
            <span class="input-group-text" id="icons-eye">
              <i id="eye" class="fas fa-eye-slash" type="button" onclick="showPasswordLogin()"></i>
            </span>
            <input type="password" id="passwordLogin" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña"
             wire:model="password" wire:keydown.enter="logIn"  aria-describedby="icons-eye"/>
            
          </div>         
          @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <!--<div class="mb-3 form-check">
          <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="showPasswordLogin()">
          <label class="form-check-label" for="exampleCheck1" >Mostrar contraseña</label>
        </div>-->
        <div class="text-center pt-1 mb-1 pb-1">
         
            <div class="d-grid gap-2 mb-2">
                <button class="btn btn-primary" type="button" wire:click="logIn" >Iniciar sesión</button>
                
              </div>
          
          <a class="text-black" href="{{ url('/restablecer-contreseña') }}">¿Olvidaste tu contraseña?</a>
        </div>



        <div class="text-center  mb-5 pb-1">
            <p class="">¿No tienes cuenta aún?</p>
            
            <p class="">Registrate</p>
            <a href="{{ url('/registro') }}" type="button" class="btn btn-outline-danger me-3">Comercio</a>
          
            <a href="{{ url('/registro-repartidor') }}" type="button" class="btn btn-outline-danger">Repartidor</a>
          
              
        </div>

       

      </form>


</div>
