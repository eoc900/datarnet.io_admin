@extends('sistema_cobros.tipos_correos_maestros.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear un nuevo tipo de correo</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('tipos_correos_maestros.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
            <x-campo-formulario label="Tipo de correo" id="tipo_correo" name="tipo_correo" type="text" placeholder="Primario, Secundario, Etc." required="true"
            parentClass="col-12"/>
            <div class="col-md-12">
                <label for="input2" class="form-label mt-3">Descripcion</label>
                <textarea class="form-control" id="input2" name="descripcion" placeholder="Describe quienes pueden utilizar esta categoría"
                rows="2"></textarea>
            </div>

        <div class="col-12 pt-3">
        @php
            $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
        @endphp
        <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />
        </div>
         <x-boton nombre_boton="Crear nueva categoría" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection