@extends('administrador.tipos_documentos.layouts.index')
@section("content")

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
							<form class="row" method="post" action="{{ route('tipos_documentos.store') }}" enctype="multipart/form-data">
							@csrf
								<div class="col-md-12">
									<label for="input1" class="form-label">Nombre categoría</label>
									<input type="text" class="form-control" id="input1" placeholder="Nombre tipo de documento" name="nombre">
								</div>
								<div class="col-md-12">
									<label for="input2" class="form-label">Descripcion</label>
									<textarea class="form-control" id="input2" name="descripcion"
										placeholder="Ejemplo: tipo documento para comprobar domicilio de maestros" rows="2"></textarea>
								</div>
								<div class="col-md-12">
									<label for="input3" class="form-label">Ruta almcenamiento</label>
									<input type="text" class="form-control" id="input3" placeholder="/maestros/comprobantes" name="ruta_almacenamiento">
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
               
				<!--end row-->

@endsection