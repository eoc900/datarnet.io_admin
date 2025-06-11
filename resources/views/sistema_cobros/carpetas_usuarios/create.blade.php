@extends('sistema_cobros.directorios_root.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Generar un nuevo directorio a usuario</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('carpetas_usuarios.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
    

            <div class="col-12 mt-5">
                <label for="buscarUsuario">Buscar usuario</label>
                <x-select2 placeholder="Buscar usuario" id="buscarUsuario" name="id_usuario" />
            </div>

            <div class="mensaje_existe">
            </div>

            <div class="col-12 mt-3">
                <label for="nombre_carpeta">Nombre de la carpeta</label>
                <input type="text" class="form-control" name="nombre_carpeta" placeholder="Nombre del directorio" id="nombre_carpeta">
            </div>


            <x-boton nombre_boton="Crear carpeta" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>
@endsection