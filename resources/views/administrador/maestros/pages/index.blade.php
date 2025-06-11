@extends('general.pre_made.layouts.index')
@section("content")

 <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">General</div>
					<div class="ps-3">
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb mb-0 p-0">
								<li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
								</li>
								<li class="breadcrumb-item active" aria-current="page">Maestros</li>
							</ol>
						</nav>
					</div>
					
				</div>
				<!--end breadcrumb-->

        @if(session('success'))
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

        @if(session('error'))
        <div class="alert alert-danger border-0 bg-grd-danger alert-dismissible fade show">
          <div class="d-flex align-items-center">
            <div class="font-35 text-white"><span class="material-icons-outlined fs-2">report_gmailerrorred</span>
            </div>
            <div class="ms-3">
              <h6 class="mb-0 text-white">Operación fallida</h6>
              <div class="text-white">{{ (session('error')) }}</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="product-count d-flex align-items-center gap-3 gap-lg-4 mb-4 fw-bold flex-wrap font-text1">
          <a href="javascript:;"><span class="me-1">Total maestros</span><span class="text-secondary">{{ $total }}</span></a>
        </div>

        <div class="row g-3">
          <div class="col-auto">
            <div class="position-relative">
              <input class="form-control px-5" type="search" placeholder="Buscar maestros">
              <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
            </div>
          </div>
          <div class="col-auto flex-grow-1 overflow-auto">
            <div class="btn-group position-static">
              <div class="btn-group position-static">
                <button type="button" class="btn btn-filter dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
                  Materia
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                  <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                </ul>
              </div>
              <div class="btn-group position-static">
                <button type="button" class="btn btn-filter dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
                  Campus
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                  <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                </ul>
              </div>
              <div class="btn-group position-static">
                <button type="button" class="btn btn-filter dropdown-toggle px-4" data-bs-toggle="dropdown" aria-expanded="false">
                  Grado académico
                </button>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="javascript:;">Action</a></li>
                  <li><a class="dropdown-item" href="javascript:;">Another action</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li><a class="dropdown-item" href="javascript:;">Something else here</a></li>
                </ul>
              </div>
            </div>  
          </div>
          <div class="col-auto">
            <div class="d-flex align-items-center gap-2 justify-content-lg-end">
               <button class="btn btn-filter px-4"><i class="bi bi-box-arrow-right me-2"></i>Exportar</button>
               <a href="{{ url('maestros/create') }}" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Agregar maestro</a>
            </div>
          </div>
        </div><!--end row-->

         @if($data->count())
        <div class="card mt-4">
          <div class="card-body">
            <div class="customer-table">
              <div class="table-responsive white-space-nowrap">
                 <table class="table align-middle">
                  <thead class="table-light">     
                    <tr>
                      <th>
                        <input class="form-check-input" type="checkbox">
                      </th>
                      <th>Maestro</th>
                      <th>Correo</th>
                      <th>Telefono</th>
                      <th>Estatus</th>
                      <th>Origen</th>
                      <th>Acciones</th>
                     
                    </tr>
                   </thead>
                   <tbody>
                     @foreach ($data as $row)
                     <tr>
                       <td>
                         <input class="form-check-input" type="checkbox">
                       </td>
                       <td>
                        <a class="d-flex align-items-center gap-3" href="javascript:;">
                          <div class="customer-pic">
                            <img src="{{ Storage::url("avatar_maestros/".$row->avatar) }}" class="rounded-circle" width="40" height="40" alt="">
                          </div>
                          <p class="mb-0 customer-name fw-bold">{{ $row->nombre ." ". $row->apellido_paterno }}</p>
                        </a>
                       </td>
                       <td>
                          <a href="#" class="font-text1">{{ $row->correo_personal }}</a>
                       </td>
                       <td>{{ $row->telefono }}</td>
                       <td><span class="badge rounded-pill bg-grd-{{  ($row->estado_sistema=="Activo")? "success" : "warning"; }}">{{ $row->estado_sistema }}</span></td>
                       <td>{{ $row->ciudad }}</td>
                       <td>
                        <a href="{{ route('maestros.show', $row->id) }}" class="btn btn-sm btn-primary"><i class="material-icons-outlined">search</i></a>
                        <a href="{{ route('maestros.edit', $row->id) }}" class="btn btn-sm btn-outline-info"><i class="material-icons-outlined">edit</i></a>
                                <a href="{{ route('maestros.index', $row->id) }}"
                                  class="btn btn-danger btn-sm btn-delete"
                                  onclick="event.preventDefault(); document.getElementById( 'delete-form-{{$row->id}}').submit();"> 
                                  <i class="material-icons-outlined">delete</i>
                                </a>
                                   <form id="delete-form-{{$row->id}}" action="{{route('maestros.destroy', $row->id)}}" method="post">  
                                     @csrf @method('DELETE') 
                                  </form> 
                        </td>
                     
                     </tr>
                     @endforeach
                    
                   </tbody>
                 </table>
              </div>
            </div>
          </div>
        </div>
         {{ $data->links() }}
        @else

        <div class="card mt-4">
          <div class="card-body">
                <div class="alert alert-border-secondary alert-dismissible fade show">
                    <div class="">No hay maestros registrados</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
          </div>
        </div>
        @endif
       

    </div>
  </main>
  <!--end main wrapper-->



@endsection