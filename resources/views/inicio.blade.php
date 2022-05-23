@extends('blank')



@section('content')
<section id="home">
    <div class="bg-holder" style="background-image:url(assets/img/gallery/header-delivery-final-hd.png);background-position:center;background-size:cover;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
      <div class="row align-items-center min-vh-50 min-vh-sm-100">
        <div class="col-md-7 col-lg-6 text-md-start text-center">
          <h1 class="text-black fs-3 fs-xl-8 mb-5">Nosotros llevamos tus paquetes
             a cuarlquier parte de Chalatenango.</h1>
          <a class="btn btn-primary" href="{{ url('inicio-sesion') }}" role="button">Empieza hora!
            
        </a>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section id="aboutUs">

    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center mb-6 mb-md-0 order-0 order-md-1">
            <img class="img-fluid" src="assets/img/gallery/about-delivery.png" alt="..." />
        </div>
        <div class="col-md-6 text-center text-md-start mb-6">
          <h4 class="text-danger">Envios</h4>
          <p class="my-5 fs-1 pe-xl-8">No pierdas lo oportunidad de progresar en el comercio electrónico, envia tus productos a cualquier parte de Chalatenango.
               Tambien puedes incluir a tu web nuestros servicios de paqueteria. </p>
          <div class="card card-span bg-soft-primary border-start border-primary border-5 mt-3">
            <div class="card-body">
              <h4 class="lh-base px-lg-5 py-3">
               Registrate para se parte de nuestros servicios, como repartidor o comerciante.
              </h4>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->




  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section id="services">

    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center mb-6 mb-md-0"><img class="w-100" src="assets/img/gallery/apply-delivery.png" alt="..." /></div>
        <div class="col-md-6 text-center text-md-start mb-6 px-4">
          <h4 class="text-danger text-uppercase">Como aplicar a nuestros servicios</h4>
          <p class="my-5 fs-1 pe-xl-7">
            Puedes registrarte como conductor para poder optar a los envios de los negociantes,
            tambien puedes registrarte como negociante, registrar tu negocio y listo empieza a distribuir tus productos.
            Puedes ponerte en contacto con nosotros si deseas incluir nuestros servicios de paqueteria en tu sitio web.</p>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->


  <section class="bg-primary-gradient" id="faq">
    <div class="bg-holder" style="background-image:url(assets/img/gallery/faq-bg.png);background-position:right;background-size:contain;">
    </div>
    <!--/.bg-holder-->

    <div class="container">
      <div class="row flex-center">
        <div class="col-md-6">
          <h4 class="text-danger text-uppercase">faq</h4>
          <h1 class="font-cursive fw-normal mb-5">Questions and Answers <br class="d-none d-lg-block" />on Professional Traffic<br class="d-none d-lg-block" />Permits:</h1>
        </div>
        <div class="col-md-6"><img class="w-100" src="assets/img/gallery/faq.png" alt="..." /></div>
      </div>
      <div class="row flex-center py-4">
        <div class="col-md-6">
          <div class="accordion" id="accordionExample1">
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading1">
                <button class="accordion-button px-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1"><span class="mb-0 text-start fs-0 text-900 fw-medium">What is a professional traffic permit?</span></button>
              </h2>
              <div class="accordion-collapse collapse show" id="collapse1" aria-labelledby="heading1" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">Traffic permits are a requirement for conducting professional traffic.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading2">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="true" aria-controls="collapse2"><span class="mb-0 text-start fs-0 text-900 fw-medium">How to check the traffic condition?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse2" aria-labelledby="heading2" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">You can issue either partial or full refunds. There are no fees to refund a charge, but the fees from the original charge are not returned.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading3">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="true" aria-controls="collapse3"><span class="mb-0 text-start fs-0 text-900 fw-medium">What are the requirements for a professional traffic permit?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse3" aria-labelledby="heading3" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">Disputed payments (also known as chargebacks) incur a $15.00 fee. If the customer’s bank resolves the dispute in your favor, the fee is fully refunded.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading4">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="true" aria-controls="collapse4"><span class="mb-0 text-start fs-0 text-900 fw-medium">Are there professional traffic permit training courses at a distance?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse4" aria-labelledby="heading4" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading5">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="true" aria-controls="collapse5"><span class="mb-0 text-start fs-0 text-900 fw-medium">When is a professional traffic permit needed?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse5" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="accordion" id="accordionExample2">
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading6">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="true" aria-controls="collapse6"><span class="mb-0 text-start fs-0 text-900 fw-medium">Where to look for a traffic permit?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse6" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading7">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="true" aria-controls="collapse7"><span class="mb-0 text-start fs-0 text-900 fw-medium">Are there differences between a traffic permit and a professional traffic permit?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse7" aria-labelledby="heading7" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading8">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="true" aria-controls="collapse8"><span class="mb-0 text-start fs-0 text-900 fw-medium">How much does a commercial traffic permit cost for goods?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse8" aria-labelledby="heading8" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading9">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse9" aria-expanded="true" aria-controls="collapse9"><span class="mb-0 text-start fs-0 text-900 fw-medium">How to plug in for the traffic permit test?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse9" aria-labelledby="heading9" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading10">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse10" aria-expanded="true" aria-controls="collapse10"><span class="mb-0 text-start fs-0 text-900 fw-medium">How is the sample for a professional traffic permit booked?</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse10" aria-labelledby="heading10" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
            <div class="accordion-item mb-2 rounded overflow-hidden">
              <h2 class="accordion-header" id="heading11">
                <button class="accordion-button px-4 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse11" aria-expanded="true" aria-controls="collapse11"><span class="mb-0 text-start fs-0 text-900 fw-medium">LOAD MORE</span></button>
              </h2>
              <div class="accordion-collapse collapse" id="collapse11" aria-labelledby="heading11" data-bs-parent="#accordionExample">
                <div class="accordion-body bg-primary-gradient px-4">There are no additional fees for using our mobile SDKs or to accept payments using consumer wallets like Apple Pay or Google Pay.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!-- ============================================-->
  <!-- <section> begin ============================-->
  <section id="clients">

    <div class="container">
      <div class="row">
        <div class="col-md-11 col-lg-6 col-xl-4 col-xxl-3">
          <h4 class="text-danger text-uppercase">Testimonial</h4>
          <h1 class="font-cursive fw-normal mb-5">Our Awesome <br />Clients </h1>
        </div>
        <div class="col-xxl-9">
          <div class="position-relative offset-9 offset-sm-10 offset-lg-11 mb-3"><a class="carousel-control-prev carousel-icon z-index-2" href="#carouselExampleDark" role="button" data-bs-slide="prev"><span class="carousel-control-prev-icon" aria-hidden="true"></span><span class="visually-hidden">Previous</span></a><a class="carousel-control-next carousel-icon z-index-2" href="#carouselExampleDark" role="button" data-bs-slide="next"><span class="carousel-control-next-icon" aria-hidden="true"></span><span class="visually-hidden">Next</span></a></div>
          <div class="carousel slide" id="carouselExampleDark" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active" data-bs-interval="10000">
                <div class="row h-100 mx-1 mb-5 mt-3 gx-md-2 gx-lg-4">
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">Yes, you will need to have the land owner sign the permit application as the Permittee, and you sign the permit as the Applicant or Agent for the Permittee.</p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/isak.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Isak Pettersson</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">From most barricade or traffic control companies located in the phone book. They employ certified Traffic Control Supervisors (TCS) who can generate and certify the traffic control plan. </p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/simon.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Simon Sandberg</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">An A-Line, or access restriction deed is a property right that has been obtained by CDOT for the sole purpose of prohibiting direct</p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/petter.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Pettersson</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item" data-bs-interval="2000">
                <div class="row h-100 mx-1 mb-5 mt-3 gx-md-2 gx-lg-4">
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">Yes, you will need to have the land owner sign the permit application as the Permittee, and you sign the permit as the Applicant or Agent for the Permittee.</p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/isak.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Isak Pettersson</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">From most barricade or traffic control companies located in the phone book. They employ certified Traffic Control Supervisors (TCS) who can generate and certify the traffic control plan. </p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/simon.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Simon Sandberg</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">An A-Line, or access restriction deed is a property right that has been obtained by CDOT for the sole purpose of prohibiting direct</p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/petter.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Pettersson</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="carousel-item">
                <div class="row h-100 mx-1 mb-5 mt-3 gx-md-2 gx-lg-4">
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">Yes, you will need to have the land owner sign the permit application as the Permittee, and you sign the permit as the Applicant or Agent for the Permittee.</p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/isak.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Isak Pettersson</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">From most barricade or traffic control companies located in the phone book. They employ certified Traffic Control Supervisors (TCS) who can generate and certify the traffic control plan. </p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/simon.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Simon Sandberg</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-4 mb-5 mb-md-0">
                    <div class="card card-span h-100 shadow-primary">
                      <div class="card-body my-3">
                        <p class="mb-0 px-3 px-md-2 px-xxl-3">An A-Line, or access restriction deed is a property right that has been obtained by CDOT for the sole purpose of prohibiting direct</p>
                        <div class="align-items-xl-center d-block d-xl-flex px-3 mt-3 align-self-end"><img class="img-fluid me-3 me-md-2 me-lg-3" src="assets/img/gallery/petter.png" width="50" alt="" />
                          <div class="flex-1 align-items-center pt-2">
                            <h6 class="mb-0">Pettersson</h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- end of .container-->

  </section>
  <!-- <section> close ============================-->
  <!-- ============================================-->
@endsection