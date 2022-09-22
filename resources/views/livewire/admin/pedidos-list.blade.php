<div >
    <div class="table-responsive" wire:ignore>
        <table class="table" id="myTable">
          <thead>
            <tr>
              <th>SKU</th>
              <th>Repartidor</th>
              <th>Nombre del cliente</th>
              <th>Fragil</th>
              <th>Embalaje</th>
              
              <th>Fecha de registro</th>
              <th class="text-center" >Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($pedidos as $pd)

            @php
                $repartidor = DB::table('users')->join('repartidores','repartidores.id_usuario','=','users.id')->where('repartidores.id',$pd->id_repartidor)->value('users.name');
            @endphp

            <tr>               
              <td>{{ $pd->sku }}</td>
              <td>{{ $repartidor }}</td>
              <td>{{ $pd->nombre }}</td>
              <td>{{ ($pd->fragil == 0) ? 'No' : 'Si' ; }}</td>
              <td>{{ $pd->tipo_embalaje }}</td>
              
              <td>{{ $pd->created_at->format('d/m/Y h:i:s a') }}</td>
              
             
              <td class="text-center"> 
                <button type="button" class="btn"   data-bs-toggle="modal" data-bs-target="#detalleHistorialModal" onclick="Livewire.emit('historialPedido',@js($pd->id_pedido))">
                  <span class="iconify" data-icon="typcn:document-text" style="color: 2b80ff;" data-width="30"></span>
                </button>
                {{-- @if ($pedido->estado === 0)
                <button type="button" class="btn" onclick="Livewire.emit('acceptQuestion',@js($pedido->id_pedido) )" >
                  <span class="iconify" data-icon="typcn:input-checked" style="color: #2b80ff;" data-width="30"></span>
                </button>
                <button type="button" class="btn" onclick="Livewire.emit('rejectQuestion',@js($pedido->id_pedido) )" >
                  <span class="iconify" data-icon="typcn:delete" style="color: red;" data-width="30"></span>
                </button>
                @else
                <button type="button" @if($pedido->estado === 6 || $pedido->estado === 7  ) disabled @else  @endif class="btn"  @if($pedido->estado === 6 || $pedido->estado === 7  )  @else data-toggle="modal" data-target="#PedidoRModal" onclick="Livewire.emit('asingId',@js($pedido) )"  @endif >
                  <span class="iconify" data-icon="typcn:clipboard" style="color: #2b80ff;" data-width="30" ></span>
                </button>
                @endif --}}                                  
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
</div>
