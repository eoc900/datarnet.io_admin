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

<div class="product-count d-flex align-items-center gap-3 gap-lg-4 mb-4 fw-bold flex-wrap font-text1">
    <a href="javascript:;"><span class="me-1">Total resultados: </span><span class="text-secondary">{{ $count }}</span></a>
</div>

<div class="row pb-5">
        <div class="col-md-5">
            <div class="position-relative d-flex justify-content-start">
                <input class="form-control px-5" type="search" placeholder="{{ $searchFor }}" id="dynamic_search">
                <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                <button class="btn btn-primary" id="testAjax">Buscar</button>
            </div>
        </div>

        @if(count($filtros_busqueda)>0)
        <div class="col offset-md-2">
        <div class="d-flex align-items-center gap-2 justify-content-lg-end ">
             <div class="input-group position-relative justify-content-start mb-3 d-flex">

                    <button class="btn btn-outline-secondary dropdown-toggle float-start" type="button" data-bs-toggle="dropdown" aria-expanded="false">Filtros disponibles</button>								
                    <ul class="dropdown-menu">
                        @foreach($filtros_busqueda as $filtro)
                        <li><button class="dropdown-item filtro" data-filtro="{{ strtolower($filtro);  }}">{{ $filtro }}</button></li>
                        @endforeach
                    </ul>
                    <input type="text" class="form-control float-end tagsinput-values" data-role="tagsinput" value="{{ $filtros_busqueda[0] }}">
            </div>
        </div>
        </div>   
        @endif
    
</div>


<div class=" d-flex justify-content-lg-end">
    
        <div class="mb-3 justify-content-lg-end">
           <a href="{{ (is_array($routeCreate))?route($routeCreate[0],$routeCreate[1]):route($routeCreate); }}" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>{{ $txtBtnCrear }}</a>
        </div>
   
</div>
