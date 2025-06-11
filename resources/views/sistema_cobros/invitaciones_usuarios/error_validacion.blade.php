@extends('sistema_cobros.invitaciones_usuarios.layouts.landing_page')
@section("content")
<div class="main">
  <section class="tp-breadcrumb__area pt-180 pb-140 p-relative z-index-1 fix">
      <div class="tp-breadcrumb__bg" data-background="{{ asset("centro_estudios/assets/img/breadcrumb/personalizados/error-background.jpg")}}" style="background-image: url(&quot;assets/img/breadcrumb/campus-breadcrumb.jpg&quot;);"></div>
      <div class="container">
         <div class="row align-items-center">
            <div class="col-sm-12">
               <div class="tp-breadcrumb__content pt-5">
                  <div class="tp-breadcrumb__list inner-after">
                     <span class="white"><a href="index.html"><svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.07207 0C8.19331 0 8.31107 0.0404348 8.40664 0.114882L16.1539 6.14233L15.4847 6.98713L14.5385 6.25079V12.8994C14.538 13.1843 14.4243 13.4574 14.2225 13.6589C14.0206 13.8604 13.747 13.9738 13.4616 13.9743H2.69231C2.40688 13.9737 2.13329 13.8603 1.93146 13.6588C1.72962 13.4573 1.61597 13.1843 1.61539 12.8994V6.2459L0.669148 6.98235L0 6.1376L7.7375 0.114882C7.83308 0.0404348 7.95083 0 8.07207 0ZM8.07694 1.22084L2.69231 5.40777V12.8994H13.4616V5.41341L8.07694 1.22084Z" fill="currentColor"></path>
                     </svg></a></span>
                     <span class="white pt-5 mt-5">Inicio</span>
                  </div>
                  <h3 class="tp-breadcrumb__title color">Lo sentimos hubo un error</h3>
               </div>
            </div>
         </div>
      </div>
      </section>



    <section class="cta-area tp-cta-bg grey-bg" data-background="{{ asset("centro_estudios/assets/img/cta/cta-bg-1.jpg");}}">
            <div class="container">
               <div class="row align-items-center wow fadeInUp" data-wow-delay=".2s">
                  <div class="col-xxl-10 col-lg-9">
                     <div class="tp-cta-wrapper d-flex align-items-center">
                     
                        <div class="tp-cta-content">
                           <span>Lo sentimos la petición no se pudo completar.</span>
                           <h3 class="tp-cta-title">Hubo un error, solicita al administrador otro link.</h3>
                        </div>
                     </div>
                  </div>
                  
               </div>
            </div>
         </section>
</div>
 
@endsection