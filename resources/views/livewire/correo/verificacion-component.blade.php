<div>
   
    <form>
                    
      
      <div class="form-outline mb-4">
        <input type="text" id="form2Example22" class="form-control @error('codigo') is-invalid @enderror" placeholder="Codigo de verificación" maxlength="6" wire:model="codigo" wire:keydown.enter="codeVerification" />
        @error('codigo') <span class="text-danger">{{ $message }}</span> @enderror
        @error('all') <span class="text-danger">{{ $message }}</span> @enderror
      </div>
        <div class="text-center pt-1 mb-5 pb-1">
         
            <div class="d-grid gap-2 mb-3">
                <button class="btn btn-primary" type="button" wire:click="codeVerification">Verificar</button>
                
              </div>                    
        </div>
      </form>


</div>
