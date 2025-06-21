@extends('general.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
        <h5>Crear un nuevo rol</h5>
</div>
<div class="card-body">
     
        <form action="{{ route('roles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">

            <x-campo-formulario label="Nombre del rol" id="rol" name="rol" type="text" placeholder="ejemplo: Promotor" required="true" parentClass="col-12"/>
            <x-boton nombre_boton="Crear Rol" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>

            </div>
        </form>

       
      
    
</div>
</div>
@endsection