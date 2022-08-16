@extends('blank')

@section('content')
<section id="delete-account">
    <div class="container">
        <div class="row justify-content-center mt-4 mt-md-0">
            <div class="col-12">
                <div class="card mt-5 mt-md-0">
                    <div class="card-header bg-white border-0">
                        <div class="card-title">
                            <div class="row p-2">
                                <div class="col-12 col-md-6 text-start">
                                    <h2 class="title" style="color: #111111">Petición Para Eliminar Mi Cuenta</h2>
                                </div>
                                <div class="d-none d-md-block col-md-6 text-end">
                                    <h3 class="title" style="color: #111111">{{ env('APP_NAME') }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @livewire('eliminar-cuenta')                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection