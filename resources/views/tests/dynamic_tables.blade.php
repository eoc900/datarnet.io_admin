@extends('administrador.maestros.layouts.dynamic_tables')
@section("content")
 <main class="main-wrapper">
    <div class="main-content">
    <!--breadcrumb-->
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
          <a href="javascript:;"><span class="me-1">Total </span><span class="text-secondary">{{ $count }}</span></a>
        </div>

        <div class="row pb-5">
          <div class="col-auto">
            <div class="position-relative">
              <input class="form-control px-5" type="search" placeholder="{{ $searchFor }}" id="dynamic_search">
              <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
              <button class="btn btn-primary" id="testAjax">Buscar</button>
            </div>
          </div>
         
         
        </div>

        <div class="dynamic_table">
        @include('general.tables.simple_table', [
            'data' => $data,
            "columns"=>$columns,
            "keys"=>$keys,
            "rowCheckbox"=>$rowCheckbox,
            "idKeyName"=>$idKeyName,
            "rowActions"=>$rowActions,
            "routeDestroy"=>$routeDestroy,
            "routeShow"=>$routeShow,
            "routeEdit"=>$routeEdit,
            "routeIndex"=>$routeIndex
            ])
        </div>
        <div class="card">
            <div class="card-body">
                
            </div>
        </div>

    </div>
 </main>

@endsection