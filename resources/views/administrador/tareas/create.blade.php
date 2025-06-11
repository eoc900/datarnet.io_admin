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

         <h5 class="mb-4">Crear nueva tarea</h5>
            <form method="post" action="{{ route('tareas.store') }}" enctype="multipart/form-data">
                @csrf
                
               
                <div class="col-md-6">
                    <label for="input13" class="form-label">Título</label>
                    <div class="position-relative input-icon">
                        <input type="text" class="form-control" id="input13" name="titulo" placeholder="Nombre" >
                    </div>
                </div>
                <div class="col-md-12 pt-3">
                    <label for="input23" class="form-label">Descripción</label>
                    <textarea class="form-control" id="input23" name="descripcion" rows="3" placeholder="Detalles sobre la tarea"></textarea>
                </div>
                <div class="col-md-12 pt-3">
                    <label class="form-label">Iniciar en</label>
                    <input type="text" class="form-control date-time" name="fecha_inicio">
                </div>
                <div class="col-md-12 pt-3">
                    <label class="form-label">Concluye</label>
                    <input type="text" class="form-control date-time" name="terminar_en">
                </div>
                 <div class="col-md-12 pt-3">
                    <label class="form-label">Responsable</label>
                <select id="input21" class="form-select  pt-3" name="responsable">
                       @foreach($usuarios as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                       @endforeach
                </select>
                </div>
                <div class="col-md-12 pt-3">
                    <label class="form-label">Marcar como</label>
                <select id="input21" class="form-select  pt-3" name="estado">
                       @foreach($estados as $estado)
                        <option value="{{ $estado }}">{{ $estado }}</option>
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