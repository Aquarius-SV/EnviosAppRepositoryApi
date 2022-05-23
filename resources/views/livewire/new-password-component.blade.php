<div>
    <form>
        <p class="text-center">Ingresa la nueva contraseña {{ $id_user }}  </p>
        
        <div class="form-outline mb-4">
            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Nueva contraseña" wire:model="password" />            
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-outline mb-4">
            <input type="password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Repita la nueva contraseña" wire:model="confirm_password" />            
            @error('confirm_password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1" onclick="showPassword()">
            <label class="form-check-label" for="exampleCheck1">Mostrar contraseñas</label>
          </div>
          
  
          <div class="text-center pt-1 mb-5 pb-1">
           
              <div class="d-grid gap-2 mb-3">
                  <button class="btn btn-primary" type="button" wire:click="saveNewPassword" >Guardar nueva contraseña</button>
                  
                </div>
            
            
          </div>

    </form>
</div>
