<div>

  <form>


    <div class="form-outline mb-4">
      <input type="text" id="form2Example22" class="form-control @error('codigo_validator') is-invalid @enderror" placeholder="Codigo de verificación" 
      maxlength="6" wire:model="codigo_validator" wire:keydown.enter="codeVerification" />
      @error('codigo_validator') <span class="text-danger">{{ $message }}</span> @enderror
      @error('all') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
      <div class="text-center pt-1 mb-5 pb-1">
       
          <div class="d-grid gap-2 mb-3">
              <button class="btn btn-primary" type="button" wire:click="codeVerification">Verificar</button>
              
            </div>                    
      </div>




    <div class="form-outline mb-4 text-center">
      <label for="">El codigo de verificación enviado a : <span class="bold text-decoration-underline">{{
          Auth::user()->email }}</span> </label>            
    </div>
    <div class="text-center pt-1 mb-5 pb-1">
      <a wire:click="reassingCode" href="#" class="text-black">Reenviar código</a>
      
    </div>
  </form>


</div>

@push('script')
  <script>
    window.onload = function() {
   Livewire.emit('codeGenerator')
  };

  </script>
@endpush