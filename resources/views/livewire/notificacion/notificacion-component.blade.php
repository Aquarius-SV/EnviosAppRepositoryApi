<div>
    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
        id="notificationDropdown" href="#" data-toggle="dropdown">
        <i class="typcn typcn-bell mr-0"></i>
        <span class="count bg-primary">
            {{ sizeof($notificaciones) }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
        
        <div class="overflow-scroll" @if(sizeof($notificaciones) > 5) style="height: 400px; overflow:scroll" @else   @endif>
            @forelse ($notificaciones as $noti)
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-primary">
                        <i class="typcn typcn-bell mx-0"></i>
                    </div>
                </div>
                <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">{{ $noti->data['concepto'] }} </h6>
                   
                </div>
            </a>
            @empty
            <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                    <div class="preview-icon bg-primary">
                        <i class="typcn typcn-bell mx-0"></i>
                    </div>
                </div>
                <div class="preview-item-content">
                    <h6 class="preview-subject font-weight-normal">No hay datos disponibles </h6>
    
                </div>
            </a>
    
            @endforelse
        </div>
       
       @if (sizeof($notificaciones) > 1)
       <div class="d-grid gap-2 text-center">
        <button class="btn btn-primary" type="button" >Elimar notificaciones</button>            
      </div>
       @endif
        
    </div>
</div>