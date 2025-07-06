@extends('general.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
        <h5>Crear un nuevo permiso</h5>
</div>
<div class="card-body">
     
    <form action="{{ route('permisos.store') }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <x-campo-formulario label="Nombre del permiso" id="permiso" name="permiso" type="text" placeholder="ejemplo: Ver lista alumnos, editar eventos, agregar eventos" required="true" parentClass="col-12"/>
            <x-boton nombre_boton="Crear Permiso" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>

       
      
    
</div>
</div>
@endsection