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
        <x-lista-mensajes/>
        <div class="col-sm-6 py-3 ps-5 border-bottom">
                <label for="" class="text-primary"><i class="lni lni-skipping-rope"></i> Enlazar formulario a una tabla</label>
                <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="enlazarTabla" name="enlazar_tabla" value="true">
                        <label class="form-check-label" for="enlazarTabla">Enlazar formulario</label>
                </div>
                <label for="" class="text-primary mt-3"><i class="lni lni-lock-alt"></i>Formulario público</label>
                <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="publico" name="formulario_publico" value="true">
                        <label class="form-check-label" for="publico">Publico</label>
                </div>
        </div>
        <div class="col-sm-6 py-3 contenedor_enlazar_tabla d-none">
                <div class="tabla_enlazada">
                        {{-- Aquí se muestran las opciones de tablas disponibles en caso de enlazar el formulario --}}
                        <div class="col-12">
                                <select class="mt-5 mb-5 form-control" data-tags="true" data-placeholder="Buscar tablas" data-allow-clear="true" id="buscar_tablas" name="id_tabla_db">
                                </select>
                        </div>
                </div>
        </div>

        <div class="col-sm-6 py-3 border-bottom">
                <label for="titulo_formulario">Titulo formulario</label>
                <input type="text" name="nombre_formulario" id="nombre_formulario" class="form-control" required>
        </div>
        <div class="col-sm-6 py-3">
                <label for="nombre_documento">Nombre documento</label>
                <input type="text" name="nombre_documento" id="nombre_documento" class="form-control" required>
        </div>
        <div class="col-sm-6 py-3">
                <label for="nombre_documento">Identificador</label>
                <input type="text" name="identificador_action" id="identificador_proceso" class="form-control" required>
        </div>
        <div class="col-sm-6 py-3">
                <label for="nombre_documento">Action route</label>
                <input type="text" name="action" id="action" class="form-control" required>
        </div>
        <div class="col-sm-12 py-3">
                <label for="nombre_documento">Descripción</label>
                <textarea name="descripcion" id="descripcion" cols="30" rows="3" class="form-control"></textarea>
        </div>
        
        <div class="contenedor_campos bg-light pt-5">
            {{-- Aquí se agregan las configuraciones de todos los inputs --}}
        </div>
       
        <x-boton nombre_boton="Generar formulario" type="submit" classes="btn-submit btn btn-success float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>

{{-- Modales --}}
@include("sistema_cobros.form_creator.modal_definir_datos",["ruta"=>route("modal_crear_tabla")])
@include("components.form_creator.modales.modal_multi_item")
{{-- Modales --}}

@stack("boton")
@endsection

