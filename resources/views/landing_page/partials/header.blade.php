<!-- pre loader area start -->
      <div id="loading">
         <div id="loading-center">
            <div id="loading-center-absolute">
               <!-- loading content here -->
               <div class="tp-preloader-content">
                  <div class="tp-preloader-logo">
                     <div class="tp-preloader-circle">
                        <svg width="190" height="190" viewBox="0 0 380 380" fill="none" xmlns="http://www.w3.org/2000/svg">
                           <circle stroke="#D9D9D9" cx="190" cy="190" r="180" stroke-width="6" stroke-linecap="round">
                           </circle>
                           <circle stroke="red" cx="190" cy="190" r="180" stroke-width="6" stroke-linecap="round"></circle>
                        </svg>
                     </div>
                     <img src="{{ asset("centro_estudios/assets/img/logo/preloader/preloader-icon.png");}}" alt="">
                  </div>
                  <p class="tp-preloader-subtitle">Cargando...</p>
               </div>
            </div>
         </div>
      </div>
      <!-- pre loader area end -->

      <!-- back to top start -->
      <div class="back-to-top-wrapper">
         <button id="back_to_top" type="button" class="back-to-top-btn">
            <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
               <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
            </svg>
         </button>
      </div>
      <!-- back to top end -->


      <!-- header-area-start -->
      <header class="header-area tp-header-transparent p-relative">
         <div class="tp-header-top theme-bg">
            <div class="container">
               <div class="row">
                  <div class="col-lg-6">
                     <div class="tp-heder-info d-flex justify-content-center justify-content-lg-start align-items-center">
                        <div class="tp-header-info-item d-none d-md-block">
                           <span><a href="#"><i class="fa-brands fa-facebook-f"></i></a>1.5k Seguidores</span>
                        </div>
                        <div class="tp-header-info-item">
                           <span>
                              <a href="tel:4616128410"><i><img src="{{ asset("centro_estudios/assets/img/icon/calling.svg");}}" alt="phone-img"></i>Celaya <br>
                                 +(461) 61 28410</a>
                           </span>
                        </div>
                         <div class="tp-header-info-item">
                           <span>
                              <a href="tel:4171725252"><i><img src="{{ asset("centro_estudios/assets/img/icon/calling.svg");}}" alt="phone-img"></i>Acámbaro <br> +(417) 172 5252</a>
                           </span>
                        </div>
                         <div class="tp-header-info-item">
                           <span>
                              <a href="tel:4626270210"><i><img src="{{ asset("centro_estudios/assets/img/icon/calling.svg");}}" alt="phone-img"></i>Irapuato <br> +(462) 627 0210</a>
                           </span>
                        </div>
                       
                     </div>
                  </div>
                  <div class="col-lg-6 col-md-6 d-none d-lg-block">
                     <div class="tp-header-right-list d-flex justify-content-md-end">
                        <a href="#">Planteles</a>
                        <a href="#">Soporte</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="header-sticky" class="tp-header-mob-space tp-header-1 {{ (isset($blog))?"shadow short-menu-height":""; }}">
            <div class="container">
               <div class="row align-items-center {{ (isset($blog))?"short-menu-height":""; }}">
                  <div class="col-xxl-2 col-xl-2 col-lg-6 col-md-6 col-6">
                     <div class="tp-header-logo-1">
                        <a href="/">
                           <img class="logo-1" src="{{ asset("centro_estudios/assets/img/logo/logo-centro-de-estudios-de-celaya.png");}}" alt="logo">
                           <img class="logo-2" src="{{ asset("centro_estudios/assets/img/logo/logo-centro-de-estudios-de-celaya.png");}}" alt="logo">
                        </a>
                     </div>
                  </div>
                  <div class="col-xxl-8 col-xl-7 d-none d-xl-block">
                     <div class="main-menu text-end {{ (isset($blog))?"blog":""; }}">
                        <nav class="tp-main-menu-content">
                           <ul>
                              <li class="tp-static">
                                 <a class="tp-static" href="/">Inicio</a>
                              </li>
                              <li class="has-dropdown">
                                 <a href="#">Carreras</a>
                                 <div class="tp-megamenu-main">
                                    <div class="megamenu-demo-small p-relative">
                                       <div class="tp-megamenu-small-content">
                                          <div class="row tp-gx-50">
                                             <div class="col-xl-6">
                                                <div class="tp-megamenu-list">
                                                   <a href="#">Lic. En Derecho (Irapuato)</a>
                                                   <a href="#">Lic. En Servicio Social</a>
                                                   <a href="#">Ing. En Administración Industrial (Irapuato)</a>
                                                   <a href="#">Lic. Gestión de Sistemas (Irapuato)</a>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                     
                                    </div>
                                 </div>
                              </li>
                              <li class="has-dropdown">
                                 <a href="#">Admisiones</a>
                                 <ul class="tp-submenu">
                                    <li><a href="#">General</a></li>
                                    <li><a href="#">Cómo aplicar</a></li>
                                 </ul>
                              </li>
                              <li>
                                 <a href="/blog">Blog</a>
                              </li>
                           </ul>
                        </nav>
                     </div>
                  </div>
                  <div class="col-xxl-2 col-xl-3 col-lg-6 col-md-6 col-6 {{ (isset($blog))?"blog":""; }}">
                     <div class="tp-header-contact d-flex align-items-center justify-content-end">
                        <div class="tp-header-btn d-none d-md-block ml-30">
                           <a href="university-application-form.html">Contactar </a>
                        </div>
                        <div class="tp-header-bar d-xl-none ml-30">
                           <button class="offcanvas-open-btn"><i class="fa-solid fa-bars"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- header-area-end -->

      <!-- offcanvas area start -->
      <div class="offcanvas__area">
         <div class="offcanvas__wrapper">
            <div class="offcanvas__close">
               <button class="offcanvas__close-btn offcanvas-close-btn">
                  <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M11 1L1 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                     <path d="M1 1L11 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </button>
            </div>
            <div class="offcanvas__content">
               <div class="offcanvas__top mb-90 d-flex justify-content-between align-items-center">
                  <div class="offcanvas__logo logo">
                     <a href="/">
                        <img src="{{ asset("centro_estudios/assets/img/logo/logo-centro-de-estudios-de-celaya.png");}}" alt="logo" class="logo-small">
                     </a>
                  </div>
               </div>
               <div class="offcanvas-main">
                  <div class="offcanvas-content">
                     <h3 class="offcanvas-title">Bienvenido</h3>
                     <p>Conoce nuestros planteles y programas.</p>
                  </div>
                  <div class="tp-main-menu-mobile d-xl-none"></div>
                  <div class="offcanvas-gallery">
                     <div class="row gx-2">
                        <div class="col-md-3 col-3">
                           <div class="offcanvas-gallery-img fix">
                              <a href="#"><img src="{{ asset("centro_estudios/assets/img/menu/offcanvas/offcanvas-1.jpg");}}" alt=""></a>
                           </div>
                        </div>
                        <div class="col-md-3 col-3">
                           <div class="offcanvas-gallery-img fix">
                              <a href="#"><img src="{{ asset("centro_estudios/assets/img/menu/offcanvas/offcanvas-2.jpg");}}" alt=""></a>
                           </div>
                        </div>
                        <div class="col-md-3 col-3">
                           <div class="offcanvas-gallery-img fix">
                              <a href="#"><img src="{{ asset("centro_estudios/assets/img/menu/offcanvas/offcanvas-3.jpg");}}" alt=""></a>
                           </div>
                        </div>
                        <div class="col-md-3 col-3">
                           <div class="offcanvas-gallery-img fix">
                              <a href="#"><img src="{{ asset("centro_estudios/assets/img/menu/offcanvas/offcanvas-4.jpg");}}" alt=""></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="offcanvas-contact">
                     <h3 class="offcanvas-title sm">Information</h3>
      
                     <ul>
                        <li><a href="tel:1245654">+ 4 20 7700 1007</a></li>
                        <li><a href="mailto:hello@acadia.com">hello@acadia.com</a></li>
                        <li><a href="#">Avenue de Roma 158b, Lisboa</a></li>
                     </ul>
                  </div>
                  <div class="offcanvas-social">
                     <h3 class="offcanvas-title sm">Follow Us</h3>
                     <ul>
                        <li>
                           <a href="#">
                              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M11.25 1.5H4.75C2.95507 1.5 1.5 2.95507 1.5 4.75V11.25C1.5 13.0449 2.95507 14.5 4.75 14.5H11.25C13.0449 14.5 14.5 13.0449 14.5 11.25V4.75C14.5 2.95507 13.0449 1.5 11.25 1.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M10.6016 7.5907C10.6818 8.13166 10.5894 8.68414 10.3375 9.16955C10.0856 9.65497 9.68711 10.0486 9.19862 10.2945C8.71014 10.5404 8.15656 10.6259 7.61663 10.5391C7.0767 10.4522 6.57791 10.1972 6.19121 9.81055C5.80451 9.42385 5.54959 8.92506 5.46271 8.38513C5.37583 7.8452 5.46141 7.29163 5.70728 6.80314C5.95315 6.31465 6.34679 5.91613 6.83221 5.66425C7.31763 5.41238 7.87011 5.31998 8.41107 5.4002C8.96287 5.48202 9.47372 5.73915 9.86817 6.1336C10.2626 6.52804 10.5197 7.0389 10.6016 7.5907Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M11.5742 4.42578H11.5842" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                              </svg>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M2.50589 12.7494C4.57662 16.336 9.16278 17.5648 12.7494 15.4941C14.2113 14.65 15.2816 13.388 15.8962 11.9461C16.7895 9.85066 16.7208 7.37526 15.4941 5.25063C14.2674 3.12599 12.1581 1.82872 9.89669 1.55462C8.34063 1.366 6.71259 1.66183 5.25063 2.50589C1.66403 4.57662 0.435172 9.16278 2.50589 12.7494Z" stroke="currentColor" stroke-width="1.5"></path>
                                 <path d="M12.7127 15.4292C12.7127 15.4292 12.0086 10.4867 10.5011 7.87559C8.99362 5.26451 5.28935 2.57155 5.28935 2.57155M5.68449 15.6124C6.79553 12.2606 12.34 8.54524 16.3975 9.43537M12.311 2.4082C11.1953 5.72344 5.75732 9.38453 1.71875 8.58915" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                              </svg>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <svg width="18" height="11" viewBox="0 0 18 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M1 5.5715H6.33342C7.62867 5.5715 8.61917 6.56199 8.61917 7.85725C8.61917 9.15251 7.62867 10.143 6.33342 10.143H1.76192C1.30477 10.143 1 9.83823 1 9.38108V1.76192C1 1.30477 1.30477 1 1.76192 1H5.5715C6.86676 1 7.85725 1.99049 7.85725 3.28575C7.85725 4.58101 6.86676 5.5715 5.5715 5.5715H1Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"></path>
                                 <path d="M10.9062 7.09454H17.0016C17.0016 5.41832 15.6301 4.04688 13.9539 4.04688C12.2777 4.04688 10.9062 5.41832 10.9062 7.09454ZM10.9062 7.09454C10.9062 8.77076 12.2777 10.1422 13.9539 10.1422H15.2492" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M16.1125 1.44434H11.668" stroke="currentColor" stroke-width="1.2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                              </svg>
                           </a>
                        </li>
                        <li>
                           <a href="#">
                              <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M12.75 13H5.25C3 13 1.5 11.5 1.5 9.25V4.75C1.5 2.5 3 1 5.25 1H12.75C15 1 16.5 2.5 16.5 4.75V9.25C16.5 11.5 15 13 12.75 13Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                 <path d="M8.70676 5.14837L10.8006 6.40465C11.5543 6.90716 11.5543 7.66093 10.8006 8.16344L8.70676 9.41972C7.86923 9.92224 7.19922 9.50348 7.19922 8.5822V6.06964C7.19922 4.98086 7.86923 4.64585 8.70676 5.14837Z" fill="currentColor"></path>
                              </svg>
                           </a>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="body-overlay"></div>
      <!-- offcanvas area end -->