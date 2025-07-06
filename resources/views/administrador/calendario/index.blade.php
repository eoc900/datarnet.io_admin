@extends('administrador.calendario.layouts.index')
@section("content")

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
 <div class="justify-content-lg-end">
        <div class="mb-3 justify-content-lg-end">
           <a href="{{ route($routeCreate) }}" class="btn btn-primary px-4"><i class="bi bi-plus-lg me-2"></i>{{ $txtBtnCrear }}</a>
        </div>
    </div>  

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <div id='calendar'></div>
        </div>
    </div>
</div>

@endsection