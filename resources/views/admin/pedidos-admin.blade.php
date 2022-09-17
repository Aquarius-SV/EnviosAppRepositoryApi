@extends('admin.blank')


@section('content')
<div class="row">
  
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Pedidos</h4>                
       
        @livewire('admin.pedidos-list')
        @livewire('admin.detalle-historial')
      </div>
    </div>
  </div>
</div>


@endsection


@push('scripts')
<script>
  $(document).ready( function () {
  $('#myTable').DataTable({
    "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
                },
                "order" : [[ 0, 'desc' ]],
  });
  } );

  

  /* $.fn.modal.Constructor.prototype._enforceFocus = function() {}; */


  
</script>
@endpush