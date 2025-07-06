@extends('sistema_cobros.form_creator.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
        <div class="card-header pt-3">
        <h5>Crear un formulario</h5>
        </div>
        <div class="card-body">
        <form class="row" method="post" action="{{ route('form_creator.store') }}" enctype="multipart/form-data" id="guardar_formulario">
                @csrf
               <div class="mb-3 d-flex justify-content-end">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#modalParametrosUrl">
                ⚙️ Parámetros URL
                </button>
                </div>


                <input type="hidden" name="crear" value="formulario">
                {{-- Seccion superior: ["opciones"=>[
                        "enlazar_tabla"=>true||false,
                        "formulario_publico"=>true||false,
                        "conf_avanzada"=>true||false,
                        "id_tabla_db"=>"tabla seleccionada",
                        "banner_formulario"=>"input de tipo archivo",
                        "nombre_formulario"=>"Texto para título",
                        "nombre_documento"=>"Es el slug empleado",
                        "identificador_action"=>"Para formularios personalizados",
                        "action"=>"default: ruta_automatica",
                        "descripcion"=>"breve descripcion"
                ]] --}}
                @include('sistema_cobros.form_creator.components.creator.top_section')
                {{-- CIERRE Seccion superior --}}

                {{-- Version #1 --}}
                <div class="contenedor_campos bg-light pt-5 pb-5 shadow border-round">
                        {{-- Aquí se agregan las configuraciones de todos los inputs --}}
                </div>
                {{-- Version #1 --}}
                
                @include('sistema_cobros.form_creator.modales.modal_parametros_url')

                <x-boton nombre_boton="Generar formulario" type="submit" classes="btn-submit btn btn-success float-end" parentClass="col-12 pt-5 float-end"/>
                </div>
        </form>
        </div>
</div>

{{-- Modales --}}
@include("sistema_cobros.form_creator.modales.modal_definir_datos",["ruta"=>route("modal_crear_tabla")])
@include("sistema_cobros.form_creator.modales.modal_multi_item")
{{-- Modales --}}


@endsection

