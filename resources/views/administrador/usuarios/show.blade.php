@extends('administrador.usuarios.layouts.index')
@section("content")

<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Usuario</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
					
								<li class="breadcrumb-item active" aria-current="page"><i class="bx bx-home-alt"></i>Perfil Usuario</li>
							</ol>
						</nav>
					</div>
					<div class="ms-auto">
						<div class="btn-group">
							<button type="button" class="btn btn-primary">Settings</button>
							<button type="button" class="btn btn-primary split-bg-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown">	<span class="visually-hidden">Toggle Dropdown</span>
							</button>
							<div class="dropdown-menu dropdown-menu-right dropdown-menu-lg-end">	<a class="dropdown-item" href="javascript:;">Action</a>
								<a class="dropdown-item" href="javascript:;">Another action</a>
								<a class="dropdown-item" href="javascript:;">Something else here</a>
								<div class="dropdown-divider"></div>	<a class="dropdown-item" href="javascript:;">Separated link</a>
							</div>
						</div>
					</div>
				</div>
				<!--end breadcrumb-->
      

        <div class="card rounded-4">
          <div class="card-body p-4">
            
  
             <div class="position-relative mb-5 background-profile rounded-3">
   
              <div class="profile-avatar position-absolute top-100 start-50 translate-middle">
                <img src="{{ ($data->avatar==null)?url("/dashboard_resources/assets/images/avatars/default.jpg"):Storage::url("avatares/".$data->avatar); }}" class="img-fluid rounded-circle p-1 bg-grd-danger shadow" width="170" height="170" alt="">
                @if(Auth::user()->id==$data->id)
                <div class="input-upload-avatar">
                    <form method="post" action="{{ url('/usuarios/cambio_avatar') }}" enctype="multipart/form-data" class="row" id="avatarForm">
                        @csrf
                        <label for="file-upload" class="btn btn-primary font-20 custom-file-upload">
                            <i class="fadeIn animated bx bx-message-square-edit"></i>
                            </label>
                        <input id="file-upload" type="file" class="upload_avatar" name="avatar"/>
                    </form>
                </div>
                @endif
              </div>
             </div>
             @include("general/partials/alertsTopSection")
              <div class="profile-info pt-5 d-flex align-items-center justify-content-between">
                <div class="">
                  <h3>{{ $data->name." ".$data->lastname }}
                        @if($data->user_type=="Admin")
                            <span class="badge rounded-pill bg-grd-warning text-dark">Admin</span>
                        @endif
                    </h3>

                </div>
                <div class="">
                  <a href="javascript:;" class="btn btn-grd-primary rounded-5 px-4 text-white"><i class="bi bi-chat me-2"></i>Enviar mensaje</a>
                </div>
              </div>
              <div class="kewords d-flex align-items-center gap-3 mt-4 overflow-x-auto">
                  @foreach ($roles as $role)
                      <button type="button" class="btn btn-sm btn-light rounded-5 px-4">{{ $role->name }}</button>
                  @endforeach
                 
           
              </div>

          </div>
        </div>

        <div class="row">
           <div class="col-12 col-xl-8">
            <div class="card rounded-4 border-top border-4 border-primary border-gradient-1">
              <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">Información general</h5>
                  </div>
                  <div class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                      data-bs-toggle="dropdown">
                      <span class="material-icons-outlined fs-5">more_vert</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                    </ul>
                  </div>
                 </div>
						
									<div class="col-md-6">
										<label for="input1" class="form-label">Nombre</label>
										<input type="text" class="form-control" id="input1" placeholder="Nombre" value="{{ $data->name }}">
									</div>
									<div class="col-md-6">
										<label for="input2" class="form-label">Apellidos</label>
										<input type="text" class="form-control" id="input2" placeholder="Apellidos" value="{{ $data->lastname }}">
									</div>
									<div class="col-md-12">
										<label for="input3" class="form-label">Teléfono</label>
										<input type="text" class="form-control" id="input3" placeholder="Phone" value="{{ $data->telephone }}">
									</div>
									<div class="col-md-12">
										<label for="input4" class="form-label">Correo</label>
										<input type="email" class="form-control" id="input4" value="{{ $data->email }}">
									</div>
									
						
								<div class="col-md-12">
				              <label for="input9" class="form-label">Estado</label>
                        <select id="input21" class="form-select  pt-3" name="estado">
                            @foreach(Auth::user()::$estados as $estado)
                                <option {{ ($data->estado==$estado)? "selected":"" }} value="{{ $estado }}">{{ $estado }}</option>
                            @endforeach
                        </select>
                </div>
									
									
							
							</div>
            </div>
           </div>  
           <div class="col-12 col-xl-4">
            <div class="card rounded-4">
              <div class="card-body">
                <div class="d-flex align-items-start justify-content-between mb-3">
                  <div class="">
                    <h5 class="mb-0 fw-bold">Acerca de</h5>
                  </div>
                  <div class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle-nocaret options dropdown-toggle"
                      data-bs-toggle="dropdown">
                      <span class="material-icons-outlined fs-5">more_vert</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                      <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                    </ul>
                  </div>
                 </div>
                 <div class="full-info">
                  <div class="info-list d-flex flex-column gap-3">
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">account_circle</span><p class="mb-0">Nombre completo: {{ $data->name." ".$data->lastname }}</p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">done</span><p class="mb-0">Estatus: {{ $data->estado }} </p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">code</span><p class="mb-0">Roles:   
                      @foreach ($roles as $role)
                      <button type="button" class="btn btn-sm btn-light rounded-5 px-4">{{ $role->name }}</button>
                      @endforeach
                 </p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">flag</span><p class="mb-0">País: Méx</p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">send</span><p class="mb-0">Email: {{ $data->email}}</p></div>
                    <div class="info-list-item d-flex align-items-center gap-3"><span class="material-icons-outlined">call</span><p class="mb-0">Phone: {{ $data->telephone}}</p></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card rounded-4">
         
            </div>

           </div>
        </div><!--end row-->
       


@endsection