@extends('administrador.documentos.layouts.index')
@section("content")

            @include('general.partials.alertsTopSection')

        	<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">{{ $breadcrumb_title }}</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb_second }}</li>
							</ol>
						</nav>
					</div>
            </div>
            <!--end breadcrumb-->

            <div class="col-12 col-md-6 offset-md-3">
				<div class="card">
						<div class="card-body p-4">
							<h5 class="mb-4">{{ $breadcrumb_title }}</h5>
							<form class="row" method="post" action="{{ route('documentos.store') }}" enctype="multipart/form-data">
							@csrf
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <input id="fancy-file-upload" type="file" name="files" accept=".jpg, .png, image/jpeg, image/png" multiple>
                                        </div>
                                    </div>
                                </div>

								<div class="col-md-12">
									<label for="input1" class="form-label">Nombre Archivo</label>
									<input type="text" class="form-control" id="input1" placeholder="Nombre tipo de documento" name="nombre">
								</div>
								<div class="col-md-12">
									<label for="input2" class="form-label">Descripcion</label>
									<textarea class="form-control" id="input2" name="descripcion"
										placeholder="Describe el archivo" rows="2"></textarea>
								</div>
								<div class="col-md-12">
									<label for="input3" class="form-label">Tipo de documento</label>
									<select class="form-select rounded-0" name="id_tipo_documento">
                                        
                                        @foreach($tipos_documentos as $tipo)
											<option value="{{ $tipo->id  }}">{{ $tipo->nombre }}</option>
                                        @endforeach
									</select>
								</div>
                                <div class="col-md-12">
									<label for="input3" class="form-label">Estado</label>
									<select class="form-select rounded-0" name="id_tipo_documento">
                                        
                                        @foreach($estados as $estado)
											<option value="{{ $estado  }}">{{ $estado }}</option>
                                        @endforeach
									</select>
								</div>
								
								<div class="col-md-12 mt-4">
									<div class="d-md-flex d-grid align-items-center gap-3">
										<button type="submit" class="btn btn-grd-primary px-4">Submit</button>
									</div>
								</div>
							</form>
						</div>
				</div>
          </div>

@endsection