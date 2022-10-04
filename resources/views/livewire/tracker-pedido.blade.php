<div>
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5 ">
        <div class="col-10 col-sm-8 col-lg-6">
          <img src="{{ asset('assets/img/gallery/tracker.webp') }}" class="d-block mx-lg-auto img-fluid" alt="Bootstrap Themes" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
          <h1 class="display-5 fw-bold lh-1 mb-3">Rastreo de mi paquete</h1>
          <p class="lead">
            Introduce el sku que anteriormente se te fue proporcionado por parte del administrador, en este apartado podrás visualizar los movimientos de tu pedido.
          </p>
          <div class="d-grid gap-2 d-md-flex justify-content-md-start">
  
             <input type="text" class="form-control @error('sku') is-invalid @enderror" placeholder="SKU" wire:model="sku">
             
             @error('sku') <span class="text-danger text-center">{{ $message }}</span> @enderror
             
            <button type="button" class="btn btn-primary btn-lg px-4 me-md-2" wire:click="getTracker">Buscar</button>
            
          </div>
        </div>
      </div>
            @if ($trackers)                
            <ul class="timeline">  
                @forelse ($trackers as $tk)
                  @if($loop->iteration % 2 == 0)
                  <li>
                      <div class="direction-l">
                          <div class="flag-wrapper">
                              <span class="flag">{{ date('d/m/Y h:i:s a', strtotime($tk->created_at))}}</span>
                              {{-- <span class="time-wrapper"><span class="time">{{ date('d/m/Y h:i:s a', strtotime($tk->created_at))}}</span></span> --}}
                          </div>
                          <div class="desc">{{ $tk->accion }}</div>
                      </div>
                  </li>
                  @else
                  <li>
                      <div class="direction-r">
                          <div class="flag-wrapper">
                              <span class="flag">{{ date('d/m/Y h:i:s a', strtotime($tk->created_at))}}</span>
                              {{-- <span class="time-wrapper"><span class="time">{{ date('d/m/Y h:i:s a', strtotime($tk->created_at))}}</span></span> --}}
                          </div>
                          <div class="desc">{{ $tk->accion }}</div>
                      </div>
                  </li>
                  @endif
              
          
                @empty
                
                @endforelse
            
            </ul>                        
            @endif

            @if ($alert == true)
                <div class="alert alert-primary alert-dismissible fade show" role="alert">
                    <strong>No se encontraron resultado.</strong> El sku introducido no coincidió con ningún registro en nuestro sistema.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>   
            @endif
          
</div>
