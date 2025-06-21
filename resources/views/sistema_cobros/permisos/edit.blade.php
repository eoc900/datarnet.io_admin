@extends('general.layouts.index')
@section("content")
@include('components.sistema_cobros.response')

<a href="{{ route('tabla','permisos') }}" class="btn btn-secondary">Volver a la lista de permisos</a>
<x-form-in-card titulo="Editar el permiso" route="permisos.update" accion="edicion" :obj="$obj">
    <x-lista-mensajes/>
    <div class="row">

       
            
        <div class="form-group">
                <x-campo-formulario label="Nombre del permiso" id="nombre" name="name" type="text" :value="$obj->name" placeholder="Nombre del permiso" required="true" parentClass="col-12"/>
        </div>            
        <x-boton nombreBoton="Editar nombre del permiso" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        

    </div>
</x-form-in-card>


@endsection