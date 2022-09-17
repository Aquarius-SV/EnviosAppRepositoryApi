<div>
    <form>
        <div class="mb-1">
          <label for="exampleInputEmail1" class="form-label">Nombre<span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
          @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-1">
          <label for="exampleInputPassword1" class="form-label">DUI<span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('dui') is-invalid @enderror" wire:model="dui">
          @error('dui') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-1">
            <label for="exampleInputPassword1" class="form-label">Teléfono<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('telefono') is-invalid @enderror" wire:model="telefono">
            @error('telefono') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-1">
            <label for="exampleInputPassword1" class="form-label">Dirección<span class="text-danger">*</span></label>
            <textarea class="form-control @error('direccion') is-invalid @enderror" wire:model="direccion"></textarea>
            @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-1">
            <label for="exampleInputPassword1" class="form-label">Cargo</label>
            <input type="text" class="form-control @error('cargo') is-invalid @enderror" wire:model="cargo">
            @error('cargo') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Correo electrónico<span class="text-danger">*</span></label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model="email">
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-1">
            <label for="">Contraseña<span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon1">
                    <i id="eye" class="fas fa-eye-slash" type="button" onclick="showPasswordRegister()"></i>
                </span>
                
                <input type="password" id="password"  class="form-control @error('password') is-invalid @enderror"
                placeholder="Contraseña" wire:model="password" aria-describedby="basic-addon1"/>
                
              </div>
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="mb-1">
            <label for="">Confirmación de contraseña<span class="text-danger">*</span></label>
            <div class="input-group mb-3">
                <span class="input-group-text" id="basic-addon2">
                    <i id="eye2" class="fas fa-eye-slash" type="button" onclick="showPasswordRegister()"></i>
                    
                </span>
                
                <input type="password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror"
                placeholder="Confirmación de contraseña" wire:model="confirm_password" aria-describedby="basic-addon2"/>
                
            </div>
        
            @error('confirm_password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        
        <div class="mt-3">
            <a class="btn btn-outline-danger" type="button" href="{{ url('/') }}" >Regresar</a>
            <button type="button" class="btn btn-primary" wire:click="store">Registrarme</button>
        </div>
        
      </form>
      
</div>
