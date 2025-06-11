@extends('administrador.maestros.layouts.edicion_maestro')
@section("content")
<!--start main wrapper-->
  <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Formulario de edición</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Maestro</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->
      


        <!--start stepper one--> 
			   
        

                
				<!--start stepper two--> 
				<h6 class="text-uppercase">Edición múltiple</h6>
			    <hr>
				<div id="stepper2" class="bs-stepper">
					<div class="card">
					  
					  <div class="card-header">
						  <div class="d-lg-flex flex-lg-row align-items-lg-center justify-content-lg-between" role="tablist">
							  <div class="step" data-target="#test-nl-1">
								<div class="step-trigger" role="tab" id="stepper2trigger1" aria-controls="test-nl-1">
								  <div class="bs-stepper-circle"><i class='material-icons-outlined'>account_circle</i></div>
								  <div class="">
									  <h5 class="mb-0 steper-title">Información personal</h5>
									  <p class="mb-0 steper-sub-title">Datos del maestro</p>
								  </div>
								</div>
							  </div>
							  <div class="bs-stepper-line"></div>
							  <div class="step" data-target="#test-nl-2">
								  <div class="step-trigger" role="tab" id="stepper2trigger2" aria-controls="test-nl-2">
									<div class="bs-stepper-circle"><i class='material-icons-outlined'>money</i></div>
									<div class="">
										<h5 class="mb-0 steper-title">Información bancaria</h5>
										<p class="mb-0 steper-sub-title">Datos de pago</p>
									</div>
								  </div>
								</div>
							  <div class="bs-stepper-line"></div>
							  <div class="step" data-target="#test-nl-3">
								  <div class="step-trigger" role="tab" id="stepper2trigger3" aria-controls="test-nl-3">
									<div class="bs-stepper-circle"><i class='material-icons-outlined'>school</i></div>
									<div class="">
										<h5 class="mb-0 steper-title">Education</h5>
										<p class="mb-0 steper-sub-title">Education Details</p>
									</div>
								  </div>
								</div>
								<div class="bs-stepper-line"></div>
								  <div class="step" data-target="#test-nl-4">
									  <div class="step-trigger" role="tab" id="stepper2trigger4" aria-controls="test-nl-4">
									  <div class="bs-stepper-circle"><i class='material-icons-outlined'>sentiment_satisfied</i></div>
									  <div class="">
										  <h5 class="mb-0 steper-title">Work Experience</h5>
										  <p class="mb-0 steper-sub-title">Experience Details</p>
									  </div>
									  </div>
								  </div>
							</div>
					  </div>
					  <div class="card-body">
					  
						<div class="bs-stepper-content">
						 
							<div id="test-nl-1" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger1">
								@if ($errors->any())
									<div class="alert alert-danger">
										<ul>
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									</div>
								@endif
								@if (session("success"))
									 <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show">
									<div class="d-flex align-items-center">
										<div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span>
										</div>
										<div class="ms-3">
										<h6 class="mb-0 text-white">Operación exitosa</h6>
										<div class="text-white">{{ (session('success'))}}</div>
										</div>
									</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
								@endif
								<!-- Datos personales -->

								<h5 class="mb-4">{{ $maestro->nombre." ".$maestro->apellido_paterno }}</h5>
								<form class="row g-3" method="post" action="{{ route('maestros.update', $maestro->id) }}" enctype="multipart/form-data">
									@csrf
                            		@method('PUT')
									<div class="col-md-12">
									<label for="input13" class="form-label"><b>Estatus actual sistema</b></label>
									<select id="input21" class="form-select" name="estado_sistema">
											<option {{ ($maestro->estado_sistema=="Activo")? "selected":"" }} value="Activo">Activo</option>
											<option {{ ($maestro->estado_sistema=="Inactivo")? "selected":"" }}  value="Inactivo">Inactivo</option>
									</select>
									</div>
									<div class="col-md-6">
										<label for="input13" class="form-label">Nombre</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input13" name="nombre" placeholder="{{ old('nombre', $maestro->nombre) }}" value="{{ old('nombre', $maestro->nombre) }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="input14" class="form-label">Apellido paterno</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input14" name="apellido_paterno" placeholder="{{ old('apellido_paterno', $maestro->apellido_paterno); }}" value="{{ old('apellido_paterno', $maestro->apellido_paterno); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
										</div>
									</div>
									<div class="col-md-6">
										<label for="input14" class="form-label">Apellido materno</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input143" name="apellido_materno" placeholder="{{ old('apellido_materno', $maestro->apellido_materno); }}" value="{{ old('apellido_materno', $maestro->apellido_materno); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">person_outline</i></span>
										</div>
									</div>
									<div class="col-md-12">
										<label for="input15" class="form-label">Telefono</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input15" name="telefono" placeholder="{{ old('telefono', $maestro->telefono); }}" value="{{ old('telefono', $maestro->telefono); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">call</i></span>
										</div>
									</div>
									<div class="col-md-12">
										<label for="input16" class="form-label">Correo Personal</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input16" name="correo_personal" placeholder="{{ old('correo_personal', $maestro->correo_personal); }}" value="{{ old('correo_personal', $maestro->correo_personal); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">email</i></span>
										</div>
									</div>
									<div class="col-md-12">
										<label for="input16" class="form-label">Correo Institucional</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input162" name="correo_institucional" placeholder="{{ old('correo_institucional', $maestro->correo_institucional); }}" value="{{ old('correo_institucional', $maestro->correo_institucional); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">email</i></span>
										</div>
									</div>
										<div class="col-md-12">
										<label for="input23" class="form-label">Direccion calle</label>
										<textarea class="form-control" id="input23" name="calle" placeholder="Calle" rows="3">{{ old('calle', $maestro->calle); }}</textarea>
									</div>
										<div class="col-md-4">
										<label for="input22" class="form-label">Código Postal</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input22" name="codigo_postal" placeholder="{{ old('codigo_postal', $maestro->codigo_postal); }}" value="{{ old('codigo_postal', $maestro->codigo_postal); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">location_on</i></span>
										</div>
									</div>
									<div class="col-md-4">
										<label for="input20" class="form-label">Ciudad</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input20" name="ciudad" placeholder="{{ old('ciudad', $maestro->ciudad); }}" value="{{ old('ciudad', $maestro->ciudad); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">location_city</i></span>
										</div>
									</div>
									<div class="col-md-4">
										<label for="input21" class="form-label">Estado</label>
										<select id="input21" class="form-select" name="estado">
											<option selected value="{{ $maestro->estado }}">{{ ucfirst($maestro->estado) }}</option>
											
													<option value="aguascalientes">Aguascalientes</option>
													<option value="baja california">Baja California</option>
													<option value="baja california sur">Baja California Sur</option>
													<option value="campeche">Campeche</option>
													<option value="chiapas">Chiapas</option>
													<option value="chihuahua">Chihuahua</option>
													<option value="coahuila">Coahuila</option>
													<option value="colima">Colima</option>
													<option value="durango">Durango</option>
													<option value="guanajuato">Guanajuato</option>
													<option value="guerrero">Guerrero</option>
													<option value="hidalgo">Hidalgo</option>
													<option value="jalisco">Jalisco</option>
													<option value="ciudad de mexico">Ciudad de México</option>
													<option value="estado de mexico">Estado de México</option>
													<option value="michoacan">Michoacán</option>
													<option value="morelos">Morelos</option>
													<option value="nayarit">Nayarit</option>
													<option value="nuevo leon">Nuevo León</option>
													<option value="oaxaca">Oaxaca</option>
													<option value="puebla">Puebla</option>
													<option value="queretaro">Querétaro</option>
													<option value="quintana roo">Quintana Roo</option>
													<option value="san luis potosi">San Luis Potosí</option>
													<option value="sinaloa">Sinaloa</option>
													<option value="sonora">Sonora</option>
													<option value="tabasco">Tabasco</option>
													<option value="tamaulipas">Tamaulipas</option>
													<option value="tlaxcala">Tlaxcala</option>
													<option value="veracruz">Veracruz</option>
													<option value="yucatan">Yucatán</option>
													<option value="zacatecas">Zacatecas</option>


											
										</select>
									</div>
									<div class="col-md-12">
										<label for="input18" class="form-label">Inicio contrato</label>
										<div class="position-relative input-icon">
											<input type="text" class="form-control" id="input18" name="inicio_contrato" placeholder="{{ old('inicio_contrato', $maestro->inicio_contrato); }}" value="{{ old('inicio_contrato', $maestro->inicio_contrato); }}">
											<span class="position-absolute top-50 translate-middle-y"><i class="material-icons-outlined fs-5">event</i></span>
										</div>
									</div>
								
									<div class="col-md-12">
										<div class="form-check">
											<input class="form-check-input" type="checkbox" id="input24">
											<label class="form-check-label" for="input24">Check me out</label>
										</div>
									</div>
									<div class="col-md-12">
										<div class="d-md-flex d-grid align-items-center gap-3 float-end">
											<button type="submit" class="btn btn-grd-success float-end px-4">Submit</button>
										
										</div>
									</div>
								</form>

							<!-- Datos personales -->
							  
							</div>
  
							<div id="test-nl-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger2">
  
							  <h5 class="mb-1">Account Details</h5>
							  <p class="mb-4">Enter Your Account Details.</p>
  
							  <div class="row g-3">
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Username</label>
									  <input type="text" class="form-control" placeholder="jhon@123">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">E-mail Address</label>
									  <input type="text" class="form-control" placeholder="example@xyz.com">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Password</label>
									  <input type="password" class="form-control" value="12345678">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Confirm Password</label>
									  <input type="password" class="form-control" value="12345678">
								  </div>
								  <div class="col-12">
									  <div class="d-flex align-items-center gap-3">
										  <button class="btn btn-grd-danger px-4" onclick="stepper2.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
										  <button class="btn btn-grd-success px-4" onclick="stepper2.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
									  </div>
								  </div>
							  </div><!---end row-->
							  
							</div>
  
							<div id="test-nl-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger3">
							  <h5 class="mb-1">Your Education Information</h5>
							  <p class="mb-4">Inform companies about your education life</p>
  
							  <div class="row g-3">
								  <div class="col-12 col-lg-6">
									  <label class="form-label">School Name</label>
									  <input type="text" class="form-control" placeholder="School Name">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Board Name</label>
									  <input type="text" class="form-control" placeholder="Board Name">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">University Name</label>
									  <input type="text" class="form-control" placeholder="University Name">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Course Name</label>
									  <select class="form-select">
										  <option selected>---</option>
										  <option value="1">One</option>
										  <option value="2">Two</option>
										  <option value="3">Three</option>
										</select>
								  </div>
								  <div class="col-12">
									  <div class="d-flex align-items-center gap-3">
										  <button class="btn btn-grd-danger px-4" onclick="stepper2.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
										  <button class="btn btn-grd-success px-4" onclick="stepper2.next()">Next<i class='bx bx-right-arrow-alt ms-2'></i></button>
									  </div>
								  </div>
							  </div><!---end row-->
							  
							</div>
  
							<div id="test-nl-4" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper2trigger4">
							  <h5 class="mb-1">Work Experiences</h5>
							  <p class="mb-4">Can you talk about your past work experience?</p>
  
							  <div class="row g-3">
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Experience 1</label>
									  <input type="text" class="form-control" placeholder="Experience 1">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Position</label>
									  <input type="text" class="form-control" placeholder="Position">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Experience 2</label>
									  <input type="text" class="form-control" placeholder="Experience 2">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Position</label>
									  <input type="text" class="form-control" placeholder="Position">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Experience 3</label>
									  <input type="text" class="form-control" placeholder="Experience 3">
								  </div>
								  <div class="col-12 col-lg-6">
									  <label class="form-label">Position</label>
									  <input type="text" class="form-control" placeholder="Position">
								  </div>
								  <div class="col-12">
									  <div class="d-flex align-items-center gap-3">
										  <button class="btn btn-grd-primary px-4" onclick="stepper2.previous()"><i class='bx bx-left-arrow-alt me-2'></i>Previous</button>
										  <button class="btn btn-grd-success px-4" onclick="stepper2.next()">Submit</button>
									  </div>
								  </div>
							  </div><!---end row-->
							  
							</div>
					
						</div>
						 
					  </div>
					 </div>
				   </div>
				  <!--end stepper two--> 


				

    </div>
  </main>
  <!--end main wrapper-->

@endsection