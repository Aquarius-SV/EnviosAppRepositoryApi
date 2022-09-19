@extends('blank')

@section('content')
    @livewire('agendar-cita-livewire', ['id_pedido' => $id_pedido])
@endsection