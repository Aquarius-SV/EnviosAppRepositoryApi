<div>
    <section id="citas">
        <div class="container">
            <div class="row justify-content-center">                
                <div class="col">
                    <div class="card text-start">
                      {{-- <img class="card-img-top" src="holder.js/100px180/" alt="Title"> --}}
                      <div class="card-body">
                        <h4 class="card-title">Agendar Entrega</h4>
                        <p class="card-text">
                            <div class="row">
                                <div class="col-12 col-md-12 col-lg-6">                                    
                                    <lottie-player 
                                        id="firstLottie" 
                                        src="https://assets2.lottiefiles.com/private_files/lf30_wvnhgcfc.json" 
                                        style="width:400px; height: 400px;"
                                        background="transparent"  
                                        speed="1"
                                        loop
                                        autoplay                                        
                                    >
                                    </lottie-player>                                    
                                </div>
                                <div class="col-12 col-md-12 col-lg-6 d-lg-flex align-items-md-center" {{-- style="display: flex; align-items: center;" --}}>
                                    <form class="form-horizontal" wire:submit.prevent="store">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <label for="fecha" class="form-label">Fecha</label>
                                                <input type="date"
                                                    class="form-control" name="fecha" id="fecha" placeholder="Fecha..." wire:model.lazy="fecha" min="{{ date('Y-m-d', strtotime($date)) }}">                                                    
                                                @error('fecha') <span class="error text-danger">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="turno" class="form-label">Turno de entrega</label>
                                                <select class="form-control custom-select" name="turno" id="turno" {{-- aria-describedby="turnoHelpId" --}} wire:model="turno">
                                                    <option value="" selected>Selecciona una opción</option>
                                                    <option value="mañana">Mañana</option>
                                                    <option value="tarde">Tarde</option>
                                                </select>
                                                @error('turno') <span class="error text-danger">{{ $message }}</span> @enderror
                                                {{-- <small id="turnoHelpId" class="form-text text-muted">Help text</small> --}}
                                            </div>
                                            <div class="mt-2 col-12 mx-auto text-center">
                                                <button type="submit" class="btn btn-primary">Enviar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>                            
                        </p>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            'use strict';

            /* LottieInteractivity.create({
                mode: 'scroll',
                player: '#firstLottie',
                actions: [
                    {
                        visibility: [0,1],
                        type: 'seek',
                        frames: [0, 301],
                    },
                ],
            }); */
        </script>
    @endpush
</div>
