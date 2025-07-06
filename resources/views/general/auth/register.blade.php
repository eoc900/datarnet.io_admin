@extends('general.auth.layouts.index')
@section("content")
  
  <div class="row mt-5">
           <div class="col-12 mt-3 col-md-8 col-lg-6 col-xl-5 col-xxl-5 mx-auto">
            <div class="card rounded-4 mb-0 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-5">
                  <img src="{{ asset('dashboard_resources/assets/branding/banner-registro-proyecto-inteligente.jpg') }}" class="mb-4 banner-register" width="145" alt="">
                  <h4 class="fw-bold text-center">Registro rápido</h4>
                  <p class="mb-0 text-center">Por favor ingresa tus datos para generar tu cuenta.</p>
                <form method="POST" class="row g-3" action="{{ route('register') }}">
                    @csrf
                  <div class="form-body my-4">
									
											<div class="col-12 mt-3">
												<label for="inputUsername" class="form-label">Nombre</label>
												<input type="text" class="form-control" id="inputUsername" placeholder="Lourdes" name="name" required>
											</div>
                                            <div class="col-12 mt-3">
												<label for="inputUsername" class="form-label">Apellidos</label>
												<input type="text" class="form-control" id="inputUsername" placeholder="Lopez Martinez" name="lastname" required>
											</div>
											<div class="col-12 mt-3">
												<label for="inputEmailAddress" class="form-label">Correo electrónico</label>
												<input type="email" class="form-control" id="inputEmailAddress" placeholder="example@user.com" name="email" required>
											</div>
                                            <div class="col-12 mt-3">
												<label for="telefono" class="form-label">Teléfono</label>
												<input type="text" class="form-control" id="telefono" placeholder="461123492" name="telephone" required>
											</div>
											<div class="col-12 mt-3">
												
                                                    <label for="inputChoosePassword" class="form-label">Contraseña</label>
                                                    <div class="input-group" id="show_hide_password">
                                                            <input type="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Ingresa tu contraseña"  name="password" required>
                                                            <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                                    </div>
                                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>
                                            <div class="col-12 mt-3">
                                            
                                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                                <div class="input-group" id="password_confirmation">
                                                        <input type="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Ingresa tu contraseña"  name="password_confirmation" required>
                                                        <a href="javascript:;" class="input-group-text bg-transparent"><i class="bi bi-eye-slash-fill"></i></a>
                                                </div>
                                                 <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                            </div>

                
										
											<div class="col-12 mt-3">
												<div class="form-check form-switch">
													<input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked">
													<label class="form-check-label" for="flexSwitchCheckChecked">He leído y acepto los términos y &amp; condiciones</label>
												</div>
											</div>
											<div class="col-12 mt-3">
												<div class="d-grid">
													<button type="submit" class="btn btn-grd-danger text-white">Registrarme</button>
												</div>
											</div>
											<div class="col-12 mt-3">
												<div class="text-center">
													<p class="mb-0">Ya tienes una cuenta? <a href="/login">Inicia sesión</a></p>
												</div>
											</div>
										</form>
									</div>                  

              </div>
            </div>
           </div>
        </div>
		<a href="https://wa.me/5211234567890" 
			class="whatsapp-button" 
			target="_blank" 
			title="Chatea con nosotros por WhatsApp">
				<img src="https://cdn-icons-png.flaticon.com/512/124/124034.png" alt="WhatsApp" />
			</a>


