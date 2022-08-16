<div>
    <div class="modal fade" id="detalleModal" tabindex="-1" aria-labelledby="detalleModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="detalleModalLabel">Detalle de pedido</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form>
                <h3 class="text-center text-black">Direcciones y datos del cliente</h3>    
                <hr> 
                <div class="mb-3">
                    <label for="direccionR" class="form-label">Dirección de recogida</label>
                    <textarea class="form-control"  wire:model="direccion_recogida" rows="5" disabled></textarea>                    
                  </div>
              </form>
              <div class="mb-3">
                <label for="direccionE" class="form-label">Dirección de entrega</label>
                <textarea class="form-control"  wire:model="direccion_entrega" rows="5" disabled></textarea>               
              </div>
              <div class="mb-3">
                <label for="referencia" class="form-label">Referencia</label>
                <input type="text" class="form-control" id="referencia" wire:model="referencia" disabled>                
              </div>

              <div class="mb-3">
                <label for="departamento" class="form-label">Departamento</label>
                <input type="text" class="form-control" id="departamento" wire:model="departamento" disabled>                
              </div>

              <div class="mb-3">
                <label for="municipio" class="form-label">Municipio</label>
                <input type="text" class="form-control" id="municipio" wire:model="municipio" disabled>                
              </div>

              <div class="mb-3">
                <label class="form-label">Teléfono del cliente</label>
                <input type="text" class="form-control" maxlength="8" wire:model="tel_cliente" disabled>                
              </div>

              <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del cliente</label>
                <input type="text" class="form-control" id="nombre" wire:model="cliente" disabled>                
              </div>
              
              <div class="mb-3">
                <label for="dui" class="form-label">DUI del cliente</label>
                <input type="text" class="form-control" id="dui" wire:model="dui" disabled>                
              </div>   

              <hr>
              <h3 class="text-center text-black">Datos del paquete</h3> 
              <hr>

              <div class="mb-3">
                <label class="form-label">Peso del paquete</label>
                <input type="text" class="form-control "  wire:model="peso" placeholder="(Libras)" disabled>              
              </div>

              
                <div class="me-3">
                  <div class="row">
                    <div class="col">
                      <label class="form-label">Alto</label>
                    <input type="text" class="form-control"  wire:model="alto" placeholder="(centímetros)" disabled> 
                    </div>
                    <div class="col">
                      <label class="form-label">Ancho</label>
                      <input type="text" class="form-control"  wire:model="ancho" placeholder="(centímetros)" disabled> 
                    </div>

                    <div class="col">
                      <label class="form-label">Profundidad</label>
                      <input type="text" class="form-control"  wire:model="profundidad" placeholder="(centímetros)" disabled> 
                    </div>
                  </div>                   
                </div>
                <div class="mb-3">
                  <label class="form-label">Fragil</label>
                  <input type="text" class="form-control " value="@if($fragil == 0) No @else Si @endif" placeholder="(Libras)" disabled>              
                </div>

                <div class="mb-3">
                  <label class="form-label">Embalaje</label>
                  <input type="text" class="form-control "  wire:model="embalaje" placeholder="(Libras)" disabled>              
                </div>

                 <hr>
                 <h3 class="text-center text-black">Envío</h3>    
                 <hr> 
                 <div class="mb-3">
                  <label class="form-label">Tipo de envío</label>
                  <input type="text" class="form-control "  wire:model="envio" placeholder="(Libras)" disabled>              
                </div>               
                <h3 class="mb-2 text-center text-black">Repartidor</h3>
                <div class="col-sm-12">
                  <div class="card mb-3">
                    <div class="card-body text-center mx-center">                          
                      <div class="overflo-scroll">
                          <h5 class="card-title">
                            <div class="form-floating mb-3">
                              <label for="">{{ $repartidor }}</label>
                            </div>    
                          </h5>
                          <br>
                          <img src="{{ asset('admin/images/faces/profile.png') }}" class=" mb-2" width="125" height="125">                         
                      </div>                          
                    </div>
                  </div>
                </div>
                @switch($estado)
                  @case(0)
                  <div class="alert alert-dark text-center" role="alert">
                    Pendiente de aceptación
                  </div>                  
                  @break
                  @case(1)
                  <div class="alert alert-primary text-center" role="alert">
                    Pedido aceptado
                  </div>                   
                  @break
                  @case(2)
                    <div class="alert alert-dark text-center" role="alert">
                      Pedido en preparación
                    </div> 
                    
                  @break
                  @case(3)
                    <div class="alert alert-dark text-center" role="alert">
                      Pendiente de recogida
                    </div>                   
                  @break
                  @case(4)
                  <div class="alert alert-primary text-center" role="alert">
                    Paquete recogido
                  </div>                     
                  @break
                  @case(5)
                  <div class="alert alert-primary text-center" role="alert">
                    En transito
                  </div> 
                  
                  @break
                  @case(6)
                  <div class="alert alert-success" role="alert">
                    Entregado
                  </div>                  
                  @break
                  @case(7)
                  <div class="alert alert-danger" role="alert">
                    Rechazado
                  </div>                  
                  @break
                  @case(8)
                  <div class="alert alert-danger" role="alert">
                    No entregado
                  </div>                   
                  @break
                  @endswitch
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
              
            </div>
          </div>
        </div>
      </div>
</div>
