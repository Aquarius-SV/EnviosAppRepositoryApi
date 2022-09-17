<div>
    <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="profileModalLabel">
              Edición de perfil
              </h5>              
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
                      <input type="text" class="form-control pl-1 @error('name') is-invalid @enderror"  wire:model="name" @if($edit == 1)  @else disabled @endif >
                      @error('name') <span class="text-danger text-center">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                      <label for="name" class="form-label">Correo</label>
                      <input type="text" class="form-control pl-1" wire:model="email" disabled>
                      
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

      <div class="modal fade" id="direccionesModal" tabindex="-1" aria-labelledby="direccionesModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="direccionesModalLabel">
                @if ($id_direccion)
                Edición dirección
                @else
                Nueva dirección
                @endif
              </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="nombre" class="form-label">Nombre</label>
                  <input type="text" class="form-control @error('nombre_direccion') is-invalid @enderror" id="nombre" wire:model="nombre_direccion">  
                  @error('nombre_direccion') <span class="text-danger">{{ $message }}</span> @enderror                
                </div>
                <div class="mb-3">
                  <div class="form-floating">
                    <label for="floatingTextarea2">Dirección</label>
                    <textarea class="form-control  @error('direccion') is-invalid @enderror" placeholder="Ingresa tu dirección" id="floatingTextarea2" style="height: 100px" wire:model="direccion">
                    </textarea>  
                    @error('direccion') <span class="text-danger">{{ $message }}</span> @enderror                  
                  </div>
                </div>                              
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" @if($id_direccion) wire:click="updateDireccion" @else wire:click="createAddress" @endif>
                @if ($id_direccion)
                Actualización
                @else
                Guardar
                @endif
              </button>
            </div>
          </div>
        </div>
      </div>




      <div class="modal fade" id="direccionesListModal" tabindex="-1" aria-labelledby="direccionesListModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="direccionesListModalLabel">Mis direcciones</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#direccionesModal"  data-bs-dismiss="modal"> <i class="typcn typcn-plus"></i>agregar</button>
              <div class="table-responsive">
                <table id="myTableDirecciones" class="table" style="width:100%">
                  <thead>
                    <tr>                    
                      <th scope="col">Nombre</th>
                      <th scope="col">Dirección</th>
                      <th scope="col">Acciones</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($direcciones as $dr)
                      <tr>                    
                        <td>{{ $dr->nombre }}</td>
                        <td>{{ $dr->direccion }}</td>
                        <td>
                          <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#direccionesModal" 
                          onclick="Livewire.emit('assignDireccion',@js($dr))"><i class="typcn typcn-edit text-success"></i></button>
                          <button type="button" class="btn" wire:click="deleteQuestion(@js($dr->id))"
                          ><i class="typcn typcn-delete-outline text-danger"></i></button>
                        </td>
                      </tr>
                    @endforeach                                   
                  </tbody>
                </table>
              </div>
             
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>              
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
      
      $('#myTableDirecciones').DataTable({
        "order": [[0, 'desc']],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
          },
          "rowReorder": {
                "selector": "td:nth-child(0)",
                
            },
            
            "responsive": true
      });


 </script>
@endpush
