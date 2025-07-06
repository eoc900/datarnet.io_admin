@extends('administrador.maestros.layouts.index')
@section("content")

 <main class="main-wrapper">
    <div class="main-content">
      <!--breadcrumb-->
				<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
					<div class="breadcrumb-title pe-3">Títulos académicos</div>
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

         <div class="product-count d-flex align-items-center gap-3 gap-lg-4 mb-4 fw-bold flex-wrap font-text1">
          <a href="javascript:;"><span class="me-1">Total títulos</span><span class="text-secondary">{{ $total }}</span></a>
        </div>
        <div class="row g-1">
           
            <div class="d-flex align-items-center gap-2 justify-content-lg-end">
               {{-- <button class="btn btn-filter px-4"><i class="bi bi-box-arrow-right me-2"></i>Exportar</button> --}}
               <a href="{{ url('titulos_academicos/create') }}" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>Agregar Título</a>
            </div>
        
        </div>
        

      <!--breadcrumb-->
      <label for="maestro">Buscar por maestro:</label>
		    <select class="select2-maestro form-control" data-tags="true" data-placeholder="Select an option" data-allow-clear="true" id="maestro">
        </select>
        <input type="hidden" id="maestro_id" name="id" value="">
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
                      <th>Grado</th>
                      <th>Título</th>
                      <th>Inicio</th>
                      <th>Conclusión</th>
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
                          <a href="#" class="font-text1">{{ $row->id_maestro }}</a>
                       </td>
                       <td>{{ $row->grado_academico}}</td>
                      
                       <td>{{ $row->nombre_titulo}}</td>
                        <td>{{ $row->inicio}}</td>
                        <td>{{ $row->conclusion}}</td>
                       <td>
                        <a href="{{ route('titulos_academicos.show', $row->id_titulo) }}" class="btn btn-sm btn-primary"><i class="material-icons-outlined">search</i></a>
                        <a href="{{ route('titulos_academicos.edit', $row->id_titulo) }}" class="btn btn-sm btn-outline-info"><i class="material-icons-outlined">edit</i></a>
                                <a href="{{ route('titulos_academicos.index', $row->id_titulo) }}"
                                  class="btn btn-danger btn-sm btn-delete"
                                  onclick="event.preventDefault(); document.getElementById( 'delete-form-{{$row->id_titulo}}').submit();"> 
                                  <i class="material-icons-outlined">delete</i>
                                </a>
                                   <form id="delete-form-{{$row->id_titulo}}" action="{{route('titulos_academicos.destroy', $row->id_titulo)}}" method="post">  
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
                    <div class="">No hay títulos registrados</div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
          </div>
        </div>
        @endif







    </div>
  </main>
  <!--end main wrapper-->



@endsection