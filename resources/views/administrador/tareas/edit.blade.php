@extends('administrador.tareas.layouts.create')
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

 @include('general.partials.alertsTopSection')

<div class="col-12 col-md-6 offset-md-3">
<div class="card">
    <div class="card-body">

         <h5 class="mb-4">Editar tarea</h5>
            <form class="row g-3" method="post" action="{{ route('tareas.update', $tarea->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="col-md-12 pt-3">
                    <label class="form-label">Concluye</label>
                    <input type="text" class="form-control date-time" name="terminar_en" value="{{ $tarea->terminar_en }}">
                </div>
                <div class="col-md-12 pt-3">
                    <label class="form-label">Marcar como</label>
                <select id="input21" class="form-select  pt-3" name="estado">
                       @foreach($estados as $estado)
                        <option {{ ($tarea->estado==$estado)? "selected":"" }} value="{{ $estado }}">{{ $estado }}</option>
                       @endforeach
                </select>
                </div>
                <div class="col-md-12 pt-3">
                    <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                        <button type="submit" class="btn btn-success float-end px-4">Submit</button>
                    
                    </div>
                </div>
            </form>
    </div>
</div>
</div>




@endsection