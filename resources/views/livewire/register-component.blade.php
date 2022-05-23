<div>
    <form>
        <div class="form-outline mb-4">
            <input type="text" class="form-control mb-1   @error('name') is-invalid @enderror" placeholder="Nombre completo" wire:model="name" />
            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="email" class="form-control mb-1 @error('email') is-invalid @enderror" placeholder="Correo electrónico" wire:model="email" />
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-outline mb-4">
            <input type="password" class="form-control mb-1 @error('password') is-invalid @enderror"  placeholder="Contraseña" wire:model="password" />
            @error('password') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="form-outline mb-4">
            <input type="password" class="form-control mb-3 @error('password_confirmation') is-invalid @enderror" placeholder="Confirmación de contraseña" wire:model="password_confirmation" />
            @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="text-center pt-1 mb-5 pb-1">

            <div class="d-grid gap-2 mb-3">
                <button class="btn btn-primary" type="button" wire:click="store">Registrarme</button>

            </div>


        </div>

        <div class="d-flex align-items-center justify-content-center pb-4">
            <p class="mb-0 me-2">Ya tienes una cuenta?</p>
            <a href="{{ url('/inicio-sesion') }}" type="button" class="btn btn-outline-danger">Iniciar Sesión</a>
        </div>

    </form>
</div>