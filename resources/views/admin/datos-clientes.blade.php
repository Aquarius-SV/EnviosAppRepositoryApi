@extends('admin.blank')


@section('content')

<div class="row">
 
  <div class="col-lg-12 d-flex grid-margin stretch-card">
    <div class="card">
      <div class="card-body">       
        <h4 class="card-title">Datos comercios</h4>    
        @livewire('admin.dato-cliente')        
        <div class="table-responsive">
          <table  id="myTable" class="display nowrap table responsive" style="width:100%">
            <thead>
              <tr>
                <th>Cod</th>
                <th class="text-center">Nombre</th>
                <th>Telefono</th>               
                <th class="text-start">Direccion</th>   
                <th>Accion</th>             
              </tr>
            </thead>
            <tbody>                         
              @foreach ($comercios as $com)
                  <tr>
                    <td>{{ $com->cod }}</td>
                    <td>{{ $com->nombre }}</td>
                    <td>{{ $com->telefono }}</td>
                    <td>{{ $com->direccion }}</td>
                    <td>
                      <button class="btn" data-bs-toggle="modal" data-bs-target="#datoClienteModal" onclick="Livewire.emit('assignComercio',@js($com))">
                        <i class="typcn typcn-edit mx-0 text-success"></i>
                      </button>
                      
                      <button class="btn"  onclick="Livewire.emit('deteleQuestion',@js($com->id))">
                        <i class="typcn typcn-trash mx-0 text-danger"></i>
                      </button>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection


@push('scripts')
<script>
  $(document).ready( function () {
    $('.image-link').magnificPopup({type:'image'});
      $('#myTable').DataTable({
        "order" : [[ 0, 'desc' ]],
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.3/i18n/es_es.json"
          },
          "rowReorder": {
                "selector": "td:nth-child(0)",
                
            },
            
            "responsive": true
      });
  } );

  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
  })
  
</script>    
@endpush