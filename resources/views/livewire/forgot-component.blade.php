<div>
    <form>
        <p class="text-center">Ingresa el correo electrónico con que te registraste para enviarte la confirmación</p>
        
        <div class="form-outline mb-4">
            <input type="email" id="form2Example11" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electrónico" wire:model="email" />            
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
          </div>
  
          
  
          <div class="text-center pt-1 mb-5 pb-1">
           
              <div class="d-grid gap-2 mb-3">
                  <button class="btn btn-primary" type="button" wire:click="verifyEmailPassword">Confirmar correo electrónico</button>
                  
                </div>
            
            
          </div>

    </form>
</div>
