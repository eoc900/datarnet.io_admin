@extends('sistema_cobros.inscripciones.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear un sistema académico</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('sistemas_academicos.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="sistema_academico"/>

            <x-campo-formulario label="Código Sistema Académico" id="codigo_sistema" name="codigo_sistema" type="text" placeholder="INGSistemasDigitales" required="true"
                    parentClass="col-12"/>
            
            <x-campo-formulario label="Nombre Oficial" id="nombre" name="nombre" type="text" placeholder="Ingeniería en Sistemas Digitales" required="true"
                    parentClass="col-12"/>
            
            <div class="col-12 pt-3">
                       <x-dropdown-formulario label="Nivel Académico" id="nivel_academico" :options="$niveles" value-key="id" option-key="option" simpleArray="true" name="nivel_academico" activo="activo"/>
            </div>

            <div class="col-12 pt-3">
                       <x-dropdown-formulario label="Modalidad" id="modalidad" :options="$modalidades" value-key="id" option-key="option" simpleArray="true" name="modalidad" activo="activo"/>
            </div>

            <div class="col-12 pt-3">
                       <x-dropdown-formulario label="Escuela" id="codigo_escuela" :options="$escuelas" value-key="id" option-key="codigo_escuela" simpleArray="false" name="id_escuela" activo="activo"/>
            </div>

            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />

            </div>

             
            <x-boton nombre_boton="Crear Escuela" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </form>
</div>
</div>
@endsection