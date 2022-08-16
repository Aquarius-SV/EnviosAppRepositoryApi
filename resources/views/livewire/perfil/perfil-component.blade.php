<div>
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="profileModalLabel">
                
                
                Edición de perfil</h5>
              
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    @error('all') <span class="text-danger text-center">{{ $message }}</span> @enderror                    
                    <div class="mb-3">
                      <label for="name" class="form-label">Nombre
                        <button type="button" class="btn" wire:click="enableEdit" >
                        <i class="typcn typcn-edit text-info" data-bs-toggle="tooltip" data-bs-placement="top" title="Habilitar edición">
                        </i>
                       </button></label>
                      <input type="text" class="form-control pl-1 @error('name') is-invalid @enderror" id="name" wire:model="name" @if($edit == 1)  @else disabled @endif >
                      @error('name') <span class="text-danger text-center">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                      <label for="name" class="form-label">Correo</label>
                      <input type="text" class="form-control pl-1" id="name" wire:model="email" disabled>
                      
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
                  </form>
            </div>
            <div class="modal-footer">                          
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" wire:click="updateProfileUser">Actualizar</button>
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
    $('#profileModal').on('hidden.bs.modal', function (e) {
          Livewire.emit('resetName');
      })       
 </script>
@endpush
