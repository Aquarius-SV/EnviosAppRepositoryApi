<div>
    <div class="col-12">
        <form class="form-horizontal" wire:submit.prevent="trash" id="delete-form">
            <div class="row">
                <div class="col-12">
                    <span class="text-danger">
                        Los campos con un * son obligatorios
                    </span>
                </div>
                <div class="col-12 col-md-6">
                    <label for="motivo" class="form-label">Motivo por el cual desea eliminar su cuenta *</label>
                    <input type="text" class="form-control @error('motivo') is-invalid @enderror" id="motivo" wire:model="motivo">
                    @error('motivo') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-12 col-md-6">
                    <label for="descripcion" class="form-label">Descripción *</label>
                    <span class="d-none d-md-block d-lg-none">
                        <br>
                    </span>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" wire:model="descripcion">
                    @error('descripcion') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col-12">
                    <label for="areatext" class="form-label">Sugerencias</label>
                    <textarea class="form-control @error('sugerencia') is-invalid @enderror" id="areatext" rows="3" wire:model="sugerencia"></textarea>
                    @error('sugerencia') <span class="error text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
        </form>
    </div>
    <div class="col-12">
        <p>
            Al eliminar tú cuenta no podras registrarte haciendo uso del mismo correo. Un enlace de confirmación será enviado por
            nuestro equipo a tú correo eléctronico, para confirmar tú identidad y la autorización que aceptas eliminar tú
            cuenta. Como {{ env('APP_NAME') }} lamentamos que te vayas, esperamos mejorar cada dia más por la sastifación de nuestros clientes,
            esperamos que vuelvas.
            <br>
            ATT: El equipo de {{ env('APP_NAME') }}
        </p>
    </div>
    <div class="col-12 text-center mx-auto">
        <button type="submit" form="delete-form" class="btn btn-primary" wire:loading.attr="disabled" wire:target="trash">
            <span wire:loading.class="d-none" wire:target="trash">
                Enviar
            </span>
            <div wire:loading wire:target="trash">
                Enviando...
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>       
            </div>
        </button>
    </div>
</div>
