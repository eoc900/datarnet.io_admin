@extends('sistema_cobros.tipos_contactos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear un nuevo tipo de correo</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('tipos_contactos.update',$tipo_contacto->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-lista-mensajes/>
        <div class="row">
            <div class="col-sm-12">
                <label for="tipo_contacto">Tipo de Contacto:</label>
                <input type="text" id="tipo_contacto" name="tipo_contacto" class="form-control"
                    value="{{ isset($tipo_contacto) ? $tipo_contacto->tipo_contacto : old('tipo_contacto') }}" required maxlength="32">
                @error('tipo_contacto')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp
            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" :selected="$tipo_contacto->tipo_contacto" />
        </div>
         <x-boton nombre_boton="Editar tipo de contacto" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection