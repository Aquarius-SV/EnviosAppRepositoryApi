@extends('login.auth')


@section('title','Registro de intermediario de punto de reparto')
    
@section('content')
<section class="h-100 gradient-form-login" style="background-color: #eee;margin-bottom:45px;">
    <div class="container  h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">             
              <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                <div class="text-white px-3 py-4 p-md-5 mx-md-4">
                  <h1 class="mb-4 text-white text-center">Registro de intermediario de punto de reparto</h1>                  
                </div>
              </div>
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">
                                 
                  <div class="text-center">
                    <img src="{{ asset('assets/img/gallery/intermediario.png') }}" style="width: 185px;" alt="logo" class="mb-3">
                    <h4 class="mt-1 mb-5 pb-1">{{ env('APP_NAME') }}</h4>
                  </div>    
                  
                  
                  @livewire('intermediario-registro',['punto' => $punto])
                 
  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection


