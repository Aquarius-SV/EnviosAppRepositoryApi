<div>
    <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
        id="notificationDropdown" href="#" data-toggle="dropdown">
        <i class="typcn typcn-bell mr-0"></i>
        <span class="count bg-primary">
            {{ sizeof($notificaciones) }}
        </span>
    </a>

    <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
        <p class="mb-0 font-weight-normal float-left dropdown-header">Notificaciones</p>
        @forelse ($notificaciones as $noti)
        <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
                <div class="preview-icon bg-info">
                    <i class="typcn typcn-info-large mx-0"></i>
                </div>
            </div>
            <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">{{ $noti->data['concepto'] }} </h6>
               
            </div>
        </a>
        @empty
        <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
                <div class="preview-icon bg-success">
                    <i class="typcn typcn-info-large mx-0"></i>
                </div>
            </div>
            <div class="preview-item-content">
                <h6 class="preview-subject font-weight-normal">No hay datos disponibles </h6>

            </div>
        </a>

        @endforelse


    </div>
</div>