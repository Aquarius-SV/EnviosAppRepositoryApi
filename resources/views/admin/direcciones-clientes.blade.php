@extends('admin.blank')


@section('content')
<div class="row">
    <div class="col-lg-12 d-flex grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Direcciones de clientes</h4>
                
                @livewire('direccion-cliente')
                <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#direccionClienteModal"><i class="typcn typcn-plus"></i>Nueva</button>
                <div class="table-responsive">
                    <table id="myTable" class="display nowrap table responsive" style="width:100%">
                        <thead>
                          <tr>
                            <th >Nombre</th>
                            <th >DUI</th>
                            <th >Teléfono</th>
                            <th >Dirección</th>
                            <th >Referencia</th>
                            <th >Departamento</th>
                            <th >Municipio</th>
                            <th class="text-center">Acciones</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($direcciones as $dr)
                            <tr>
                                <td>{{ $dr->nombre }}</td>
                                <td>{{ $dr->dui }}</td>
                                <td>{{ $dr->telefono }}</td>
                                <td>{{ $dr->direccion }}</td>
                                <td>{{ ($dr->referencia) ? $dr->referencia : 'Sin referencia'}}</td>
                                <td>{{ $dr->departamento }}</td>
                                <td>{{ $dr->municipio }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn text-success" data-bs-toggle="modal" data-bs-target="#direccionClienteModal"
                                     onclick="Livewire.emit('assingDireccion',@js($dr))"><i class="typcn typcn-edit" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar"></i></button>
                                    <button type="button" class="btn text-danger"
                                    onclick="Livewire.emit('questionDelete',@js($dr))"><i class="typcn typcn-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar"></i></button>
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