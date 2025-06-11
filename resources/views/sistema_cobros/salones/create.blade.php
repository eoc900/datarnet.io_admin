@extends('sistema_cobros.salones.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear un sistema académico</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('salones.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
       

            <div class="col-12 pt-3 ">
                <x-dropdown-formulario label="Escuelas" id="id_escuela" :options="$escuelas" value-key="id" option-key="nombre" simpleArray="false" name="id_escuela"/>
            </div>
            
            <x-campo-formulario label="Clave" id="clave" name="nombre" type="text" placeholder="Identificador/nombre del salón" required="true"
            parentClass="col-12"/>
            
            <x-campo-formulario label="Máxima capacidad alumnos" id="capacidad" name="capacidad" type="text" placeholder="Cantidad ejemplo: 24" required="true"
            parentClass="col-12"/>
    
            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />

            </div>


             
            <x-boton nombre_boton="Agregar salón" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </form>
</div>
</div>
@endsection