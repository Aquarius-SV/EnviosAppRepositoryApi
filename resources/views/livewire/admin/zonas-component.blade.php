<div>

    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#zonaModal">
        Nueva <span class="iconify" data-icon="typcn:plus" ></span>
    </button>



    <div class="modal fade" id="zonaModal" tabindex="-1" aria-labelledby="zonaModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title col-11 text-center" id="zonaModalLabel">Zonas de entrega</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="">Nombre</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" wire:model="nombre">
                    @error('nombre') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="">Departamento</label>
                    <select class="form-select @error('departamento') is-invalid @enderror" aria-label="Selecciona" wire:model="departamento">
                        <option selected>Selecciona</option>
                        @forelse ($departamentos as $dt)
                        <option value="{{ $dt->id }}">{{ $dt->nombre }}</option>
                        @empty
                        <option >No hay datos disponibles</option>
                        @endforelse                                                                      
                      </select>
                      @error('departamento') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                <div class="mb-3">
                    <label for="">Municipio</label>
                    <select class="form-select @error('municipio') is-invalid @enderror" aria-label="Selecciona" wire:model="municipio">
                        <option selected>Selecciona</option>
                        @forelse ($municipios as $mc)
                        <option value="{{ $mc->id }}">{{ $mc->nombre }}</option>
                        @empty
                        <option >No hay datos disponibles</option>
                        @endforelse      
                      </select>
                      @error('municipio') <span class="text-danger">{{ $message }}</span> @enderror
                </div>

                @if ($estado <> null)
                    <div class="mb-3">
                        <label for="">Estado</label>
                        <select class="form-select"  wire:model="estado">
                            
                            <option value="1">{{ ($old_estado == 0) ? 'Activar' : 'Activa' ; }}</option>
                            <option value="0">{{ ($old_estado == 0) ? 'Desactivada' : 'Desactivar' ; }}</option>
                            
                          </select>
                    </div>
                @endif


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <button type="button" class="btn btn-primary" @if($zona) wire:click="updateZonaReparto" @else wire:click="saveZonaReparto" @endif>{{ ($zona) ? 'Actualizar' : 'Guardar' ; }}</button>
            </div>
          </div>
        </div>
      </div>
</div>


@push('scripts')
    <script>
        var zonaModal = document.getElementById('zonaModal')
        zonaModal.addEventListener('hidden.bs.modal', function (event) {
            Livewire.emit('resetData');
        })
    </script>
@endpush
