<div>
   
    <form>
                    
  
        <div class="form-outline mb-4">
          <input type="email" id="form2Example11" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electrónico" wire:model="email" />            
          @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
          <input type="password" id="form2Example22" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" wire:model="password" wire:keydown.enter="logIn" />
          @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="text-center pt-1 mb-5 pb-1">
         
            <div class="d-grid gap-2 mb-3">
                <button class="btn btn-primary" type="button" wire:click="logIn" >Iniciar sesion</button>
                
              </div>
          
          <a class="text-black" href="{{ url('/restablecer-contreseña') }}">¿Olvidaste tu contraseña?</a>
        </div>



        <div class="text-center pt-1 mb-5 pb-1">
            <p class="">¿No tienes cuenta aún?</p>
            
            <p class="">Registrate</p>
            <a href="{{ url('/registro') }}" type="button" class="btn btn-outline-danger me-3">Comerciante</a>
          
            <a href="{{ url('/registro-repartidor') }}" type="button" class="btn btn-outline-danger">Repartidor</a>
          
              
        </div>

       

      </form>


</div>
