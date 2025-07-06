@extends('sistema_cobros.tablas_modulos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
    @if (session('link_cargar_datos'))
        <div class="alert alert-primary d-flex">
            <p class="mt-4"><b>Esta tabla ya existe en la base de datos</b></p>
            <a href="{{ session("link_cargar_datos") }}" class="btn btn-info ms-5 pt-3">Agregar datos a tabla existente</a>
        </div>
    @endif
<div class="card">
<div class="card-header pt-3">
    <h5>Generar un nueva tabla con archivo de excel</h5>
</div>
<div class="card-body">
       
    <form class="row" method="post" action="{{ route('insertar.archivo') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
      
        <div class="row">
            <div class="col-sm-6">
                <label for="nombre" class="form-label">Nombre archivo CSV o Excel:</label>
                <input type="text" name="nombre_archivo" value="{{ old("nombre_archivo") }}" placeholder="Nombre de tabla en sistema" class="form-control">
            </div>
            <div class="col-sm-6">
                <label for="archivo" class="form-label">Subir archivo CSV o Excel:</label>
                <input type="file" class="form-control" name="archivo" id="archivo" accept=".csv, .xlsx" required>
            </div>
         
            <div class="col-12 pt-3">

                @php
                    $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
                @endphp
                <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo"/>
            </div>
         <x-boton nombre_boton="Insertar tabla" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>


      


</div>
</div>


@endsection