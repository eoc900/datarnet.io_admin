@extends('sistema_cobros.inscripciones.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Crear un sistema académico</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('materias.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
            <x-tag-formulario name="formulario" type="hidden" value="sistema_academico"/>

            {{-- <div class="col-12 pt-3 ">
                <x-dropdown-formulario label="Sistema Académico" id="id_sistema" :options="$sistemas_academicos" value-key="id" option-key="nombre" simpleArray="false" name="id_sistema"/>
            </div> --}}
            
            <x-campo-formulario label="Clave" id="clave" name="clave" type="text" placeholder="Clave" required="true"
            parentClass="col-12"/>
            
            <x-campo-formulario label="Nombre de la materia" id="materia" name="materia" type="text" placeholder="Materia" required="true"
            parentClass="col-12"/>
    
            <x-campo-formulario label="Cuatrimestre" id="cuatrimestre" name="cuatrimestre" type="text" placeholder="Cuatrimestre" required="true"
            parentClass="col-12"/>


            <x-campo-formulario label="Créditos" id="creditos" name="creditos" type="text" placeholder="Créditos" required="true"
            parentClass="col-12"/>

            <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp

            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />

            </div>

             <div class="col-6 pt-3">
             @php
                $opciones = array(["id"=>0,"option"=>"No"],["id"=>1,"option"=>"Si"])
            @endphp

            <x-dropdown-formulario label="Es seriada" id="seriada" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="seriada" />

            </div>

             
            <x-boton nombre_boton="Crear materia" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
           

        </div>
    </form>
</div>
</div>
@endsection