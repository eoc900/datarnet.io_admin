@extends('landing_page.layouts.index')
@section("content")
      

      <main>

         <!-- hero-area-start -->
         <section class="tp-hero-area">
            <div class="swiper tp-slider-active">
               <div class="swiper-wrapper">
                  <div class="swiper-slide">
                     <div class="tp-hero-item">
                        <div class="container">
                           <div class="row">
                              <div class="col-xxl-9 col-lg-11">
                                 <div class="tp-hero-wrapper">
                                 
                                    <h2 class="tp-hero-title">Inscripciones abiertas</h2>
                                    <div class="tp-hero-btn">
                                       <a class="tp-btn" href="#contacto">
                                          Aplicar
                                          <span>
                                             <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path d="M1 7H13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M7 1L13 7L7 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             </svg>
                                          </span>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tp-hero-bg" data-background="{{ asset("centro_estudios/assets/img/hero/slider/centro-de-estudios-de-celaya-graduados.jpg");}}"></div>
                     </div>
                  </div>
                  <div class="swiper-slide">
                     <div class="tp-hero-item">
                        <div class="container">
                           <div class="row">
                              <div class="col-xxl-9 col-lg-11">
                                 <div class="tp-hero-wrapper">
                                    <span class="tp-hero-subtitle"></span>
                                    <h2 class="tp-hero-title">Conoce nuestros programas.</h2>
                                    <div class="tp-hero-btn">
                                       <a class="tp-btn" href="#">
                                          Aplicar
                                          <span>
                                             <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path d="M1 7H13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M7 1L13 7L7 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             </svg>
                                          </span>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tp-hero-bg" data-background="{{ asset("centro_estudios/assets/img/hero/slider/licenciatura-en-derecho-centro-de-estudios.jpg");}}"></div>
                     </div>
                  </div>
                  <div class="swiper-slide">
                     <div class="tp-hero-item">
                        <div class="container">
                           <div class="row">
                              <div class="col-xxl-9 col-lg-11">
                                 <div class="tp-hero-wrapper">
                                    <span class="tp-hero-subtitle">Bachillerato y Universidad</span>
                                    <h2 class="tp-hero-title">Apuesta por tu futuro</h2>
                                    <div class="tp-hero-btn">
                                       <a class="tp-btn" href="#">
                                          Aplicar
                                          <span>
                                             <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                             <path d="M1 7H13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             <path d="M7 1L13 7L7 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                             </svg>
                                          </span>
                                       </a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="tp-hero-bg" data-background="{{ asset("centro_estudios/assets/img/hero/slider/centro-de-estudios-celaya-industrial.jpg");}}"></div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- hero-area-end -->

         <!-- service-area-start -->
         <section class="service-area tp-service-bg" data-background="{{ asset("centro_estudios/assets/img/bg/services-bg.jpg");}}">
            <div class="container">
               <div class="row">
                  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item text-center mb-40 wow fadeInUp" data-wow-delay=".3s">
                        <div class="tp-service-wrap">
                           <div class="tp-service-icon">
                              <span><img src="{{ asset("centro_estudios/assets/img/icon/service/service-icon-1.svg");}}" alt="service-icon"></span>
                           </div>
                           <h4 class="tp-service-title"><a href="#">¿Por qué <br> Centro de estudios?</a></h4>
                           <div class="tp-service-btn">
                              <a href="#"><span><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M1 6H11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M6 1L11 6L6 11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg></span>
                              </a>
                           </div>
                        </div>
                        <div class="tp-service-content">
                           <p>Sea cuál sea tu situación, te ayudamos a concluir tus estudios.  </p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item text-center mb-40 wow fadeInUp" data-wow-delay=".5s">
                        <div class="tp-service-wrap">
                           <div class="tp-service-icon">
                              <span><img src="{{ asset("centro_estudios/assets/img/icon/service/service-icon-2.svg");}}" alt="service-icon"></span>
                           </div>
                           <h4 class="tp-service-title"><a href="#">Calidad <br> Garantizada</a></h4>
                           <div class="tp-service-btn">
                              <a href="#"><span><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M1 6H11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M6 1L11 6L6 11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg></span>
                              </a>
                           </div>
                        </div>
                        <div class="tp-service-content">
                           <p>Estamos comprometidos en ofrecerte la mejor atención posible.</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item text-center mb-40 wow fadeInUp" data-wow-delay=".7s">
                        <div class="tp-service-wrap">
                           <div class="tp-service-icon">
                              <span><img src="{{ asset("centro_estudios/assets/img/icon/service/service-icon-3.svg");}}" alt="service-icon"></span>
                           </div>
                           <h4 class="tp-service-title"><a href="#">Flexibilidad de <br> Horarios</a></h4>
                           <div class="tp-service-btn">
                              <a href="#"><span><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M1 6H11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M6 1L11 6L6 11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg></span>
                              </a>
                           </div>
                        </div>
                        <div class="tp-service-content">
                           <p>Selecciona la opción de horario que más te acomode.</p>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                     <div class="tp-service-item text-center mb-40 wow fadeInUp" data-wow-delay=".9s">
                        <div class="tp-service-wrap">
                           <div class="tp-service-icon">
                              <span><img src="{{ asset("centro_estudios/assets/img/icon/service/service-icon-4.png");}}" alt="service-icon"></span>
                           </div>
                           <h4 class="tp-service-title"><a href="#">Gran cantidad de <br> egresados</a></h4>
                           <div class="tp-service-btn">
                              <a href="#"><span><svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M1 6H11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M6 1L11 6L6 11" stroke="#161613" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg></span>
                              </a>
                           </div>
                        </div>
                        <div class="tp-service-content">
                           <p>Quien nos avala son los miles de egresados que hemos tenido.</p>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-lg-12">
                     <div class="tp-service-all text-center">
                        <span>Ven a conocernos <a href="#">Tu escuela de confianza <svg width="10" height="10" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <path d="M1 6H11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                           <path d="M6 1L11 6L6 11" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                           </svg></a>
                        </span>
                     </div>
                  </div>
               </div>
            </div>
            <div class="tp-service-shape">
               <div class="tp-service-shape-1 wow bounceIn" data-wow-duration="1.5s" data-wow-delay=".4s">
                  <img src="{{ asset("centro_estudios/assets/img/shape/service/services-shape-1.png");}}" alt="service-shape">
               </div>
            </div>
         </section>
         <!-- service-area-end -->

         <!-- about-area-start -->
         <section class="about-area tp-about-bg grey-bg pt-105">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="tp-about-wrap mb-60 wow fadeInLeft" data-wow-delay=".3s">
                        <div class="tp-about-thumb-wrapper">
                           <div class="tp-about-thumb-1">
                              <img src="{{ asset("centro_estudios/assets/img/about/aula-centro-de-estudios.jpg");}}" alt="">
                           </div>
                           <div class="tp-about-thumb-2">
                              <img src="{{ asset("centro_estudios/assets/img/about/centro-de-celaya-bola-de-agua.jpg");}}" alt="">
                           </div>
                        </div>
                        <div class="tp-about-shape">
                           <div class="tp-about-shape-1">
                              <img src="{{ asset("centro_estudios/assets/img/about/about-shape-1.jpg");}}" alt="">
                           </div>
                           <div class="tp-about-shape-2">
                              <img src="{{ asset("centro_estudios/assets/img/about/about-shape-2.jpg");}}" alt="">
                           </div>
                        </div>
                        <div class="tp-about-exprience">
                           <div class="tp-about-exprience-text d-flex">
                              <h3 class="tp-about-exprience-count">
                                 <span data-purecounter-duration="1" data-purecounter-end="30"  class="purecounter">30</span>
                              </h3>
                              <p>Años de <br> Experiencia</p>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-lg-6">
                     <div class="tp-about-wrapper mb-60 wow fadeInRight" data-wow-delay=".3s">
                        <div class="tp-section mb-40">
                           <h5 class="tp-section-subtitle">Conócenos</h5>
                           <h3 class="tp-section-title mb-30">Es tu <br> 
                              <span> Centro de Estudios <svg width="180" height="13" viewBox="0 0 180 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M173.163 12.3756C97.1838 -3.8242 30.6496 5.67799 7.32494 12.2553C5.30414 12.8252 2.43544 12.6722 0.917529 11.9135C-0.600387 11.1549 -0.192718 10.0779 1.82808 9.50807C27.5427 2.25675 98.002 -7.60121 177.683 9.38783C179.881 9.85641 180.65 10.9051 179.402 11.7301C178.154 12.5552 175.361 12.8442 173.163 12.3756Z" fill="currentColor" />
                                 </svg>
                              </span>
                           </h3>
                           <p>Nuestro objetivo principal es proporcionar a los estudiantes<br> las
                                herramientas y el apoyo que necesario para tener <br> éxito académico y
                                personal.  </p>
                        </div>
                        <div class="tp-about-list">
                           <div class="tp-about-list-item d-flex align-items-center mb-35">
                              <div class="tp-about-list-icon">
                                 <span><img src="{{ asset("centro_estudios/assets/img/icon/about/about-icon-1.svg");}}" alt="about-icon"></span>
                              </div>
                              <div class="tp-about-list-content">
                                 <h5 class="tp-about-list-title">Compromiso total</h5>
                                 <p>Responsabilidad total <br> en el avance académico.</p>
                              </div>
                           </div>
                           <div class="tp-about-list-item d-flex align-items-center mb-35">
                              <div class="tp-about-list-icon">
                                 <span><img src="{{ asset("centro_estudios/assets/img/icon/about/about-icon-2.svg");}}" alt="about-icon"></span>
                              </div>
                              <div class="tp-about-list-content">
                                 <h5 class="tp-about-list-title">Logros tangibles</h5>
                                 <p>Egresados han alcanzado sus <br> metas con nuestro sistema. </p>
                              </div>
                           </div>
                           <div class="tp-about-btn pt-10">
                              <a class="tp-btn tp-btn-sm" href="#">Agendar un tour
                                 <span>
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                       <path d="M1 7H13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                       <path d="M7 1L13 7L7 13" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                 </span>
                              </a>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- about-area-end -->




    

         
  

         
         <!-- cta-area-start -->
         <section class="cta-area tp-cta-bg grey-bg" data-background="{{ asset("centro_estudios/assets/img/cta/cta-bg-1.jpg");}}">
            <div class="container">
               <div class="row align-items-center wow fadeInUp" data-wow-delay=".2s">
                  <div class="col-xxl-10 col-lg-9">
                     <div class="tp-cta-wrapper d-flex align-items-center">
                        <div class="tp-cta-logo">
                           <a href="#"><img src="{{ asset("centro_estudios/assets/img/logo/logo-cece-white.png");}}" alt=""></a>
                        </div>
                        <div class="tp-cta-content">
                           <span>Consulta gratis para recibir más información respecto a</span>
                           <h3 class="tp-cta-title">Nuestros programas y promociones.</h3>
                        </div>
                     </div>
                  </div>
                  <div class="col-xxl-2 col-lg-3">
                     <div class="tp-cta-btn-wrap">
                        <div class="tp-cta-btn text-lg-end">
                           <a class="tp-btn" href="#">Consultar<span><svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M1 7H13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              <path d="M7 1L13 7L7 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                              </svg></span>
                           </a>
                        </div>
                        <div class="tp-cta-shape-1">
                           <img src="{{ asset("centro_estudios/assets/img/cta/cta-shape-1.png");}}" alt="">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
         <!-- cta-area-end -->

      </main>

    
      <!-- footer-area-end -->

@endsection