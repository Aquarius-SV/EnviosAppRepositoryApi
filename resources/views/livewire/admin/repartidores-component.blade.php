<div>
    <div class="modal fade" id="detalleRepartidor" tabindex="-1" aria-labelledby="detalleRepartidorLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="detalleRepartidorLabel">Datos del repartidor</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form>
                    <h4 class="text-center">Datos personales</h4>
                    <hr>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Nombre</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" wire:model="nombre">                      
                    </div>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="exampleInputPassword1" class="form-label">Correo</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" wire:model="correo">
                          </div>
                          <div class="mb-3 col-6">
                              <label for="exampleInputPassword1" class="form-label">Telefono</label>
                              <input type="text" class="form-control" id="exampleInputPassword1" wire:model="telefono">
                          </div>
                    </div>  
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="exampleInputPassword1" class="form-label">DUI</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" wire:model="dui">
                          </div>
                          <div class="mb-3 col-6">
                              <label for="exampleInputPassword1" class="form-label">NIT</label>
                              <input type="text" class="form-control" id="exampleInputPassword1" wire:model="nit">
                          </div>
                    </div> 
                    <div class="mb-3 ">
                        <label for="exampleInputPassword1" class="form-label">Licencia</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" wire:model="licencia">
                    </div>
                    <hr>
                    <h4 class="text-center">Datos del vehiculo</h4>
                    <hr>
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="exampleInputPassword1" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" wire:model="modelo">
                          </div>
                          <div class="mb-3 col-6">
                              <label for="exampleInputPassword1" class="form-label">Marca</label>
                              <input type="text" class="form-control" id="exampleInputPassword1" wire:model="marca">
                          </div>
                    </div> 
                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="exampleInputPassword1" class="form-label">Tipo</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" wire:model="tipo">
                          </div>
                          <div class="mb-3 col-6">
                              <label for="exampleInputPassword1" class="form-label">Placa</label>
                              <input type="text" class="form-control" id="exampleInputPassword1" wire:model="placa">
                          </div>
                    </div> 

                    <div class="row">
                        <div class="mb-3 col-6">
                            <label for="exampleInputPassword1" class="form-label">Color</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" wire:model="color">
                          </div>
                          <div class="mb-3 col-6">
                              <label for="exampleInputPassword1" class="form-label">Peso maximo</label>
                              <input type="text" class="form-control" id="exampleInputPassword1" wire:model="peso">
                          </div>
                    </div> 
                    <div class="mb-3 ">
                        <label for="exampleInputPassword1" class="form-label">Dimenciones</label>
                        <input type="text" class="form-control" id="exampleInputPassword1" wire:model="demencion">
                    </div>
                    <hr>
                    <h4 class="text-center">Envios</h4>
                    <hr>
                    <ol class="list-group list-group-numbered">
                        @foreach ($zonas as $z)
                        <li class="list-group-item">{{ $z->zona }}</li>
                        @endforeach                                                
                      </ol>
                  </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>
</div>
