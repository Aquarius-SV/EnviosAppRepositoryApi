<div>

  <form>


    <div class="form-outline mb-4">
      <label for="">El codigo de verificación se enviara a: <span class="bold text-decoration-underline">{{
          Auth::user()->email }}</span> </label>
      @error('all') <h5 class="text-danger">{{ $message }}</h5> @enderror
      
    </div>
    <div class="text-center pt-1 mb-5 pb-1">

      <div class="d-grid gap-2 mb-3">
        <button class="btn btn-primary" type="button" wire:click="codeGenerator">Enviar codigo de verificación</button>

      </div>
    </div>
  </form>


</div>