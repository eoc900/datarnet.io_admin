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
        <div class="col-sm-4 py-3 ps-5 ">
                <label for="" class="text-primary"><i class="lni lni-skipping-rope"></i> Enlazar formulario a una tabla</label>
                <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="enlazarTabla" name="enlazar_tabla" value="true">
                        <label class="form-check-label" for="enlazarTabla">Enlazar formulario</label>
                </div>
                <label for="" class="text-primary mt-3"><i class="lni lni-lock-alt"></i> Formulario público</label>
                <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="publico" name="formulario_publico" value="true">
                        <label class="form-check-label" for="publico">Publico</label>
                </div>                
        </div>
        <div class="col-4">
                <label for="" class="text-primary mt-3"><i class="lni lni-key"></i> Habilitar opciones avanzadas</label>
                <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="conf_avanzada" name="conf_avanzada" value="true">
                        <label class="form-check-label" for="conf_avanzada">Configuración avanzada</label>
                </div>
        </div>
        <div class="col-sm-12 py-3 contenedor_enlazar_tabla d-none">
                <div class="tabla_enlazada">
                        {{-- Aquí se muestran las opciones de tablas disponibles en caso de enlazar el formulario --}}
                        <div class="col-12">
                                <select class="mt-5 mb-5 form-control" data-tags="true" data-placeholder="Buscar tablas" data-allow-clear="true" id="buscar_tablas" name="id_tabla_db">
                                </select>
                        </div>
                </div>
        </div>

        {{-- Sección oculta inicialmente --}}
        <div id="seccion-banner" class="col-12 mt-4 d-none">
                <label class="text-primary"><i class="lni lni-image"></i> Imagen de banner para formulario público</label>

                <div id="drop-zone" class="border border-dashed rounded p-4 text-center bg-light"
                        style="cursor: pointer;">
                        <p class="text-muted mb-2">Arrastra una imagen aquí o haz clic para seleccionarla</p>
                        <input type="file" id="banner_input" name="banner_formulario" accept="image/*" class="d-none" />
                        <img id="preview-banner" src="" class="img-fluid mt-3 d-none border rounded" style="max-height: 200px;" />
                </div>
        </div>


        <div class="col-sm-6 py-3">
                <label for="titulo_formulario">Titulo formulario</label>
                <input type="text" name="nombre_formulario" id="nombre_formulario" class="form-control" maxlength="50" required>
                <small id="alerta_longitud" class="text-danger d-none">Has excedido el límite de caracteres (50).</small>
        </div>
       <div class="col-sm-6 py-3">
                <label for="nombre_documento" class="d-flex align-items-center">
                        Slug 
                        <i class="lni lni-question-circle ms-2 text-primary" 
                        style="cursor: pointer;" 
                        data-bs-toggle="modal" 
                        data-bs-target="#modalExplicacionSlug"
                        title="¿Qué es esto?">
                        </i>
                </label>
                <input type="text" name="nombre_documento" id="nombre_documento" class="form-control" maxlength="50" required>
        </div>
        <div id="campos-avanzados" class="row d-none col-12 border-top border-bottom py-3">
                <p><b><i class="lni lni-cog"></i> Configuración avanzada</b></p>
                <div class="row">
                <div class="col-sm-6">
                        <label for="identificador_proceso">Identificador</label>
                        <input type="text" name="identificador_action" id="identificador_proceso" class="form-control" placeholder="notificacion-programada">
                </div>
                <div class="col-sm-6">
                        <label for="action">Action route</label>
                        <input type="text" name="action" id="action" class="form-control" value="ruta_automatica" required>
                </div>
                </div>
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
@include("sistema_cobros.form_creator.modales.modal_definir_datos",["ruta"=>route("modal_crear_tabla")])
@include("sistema_cobros.form_creator.modales.modal_multi_item")
{{-- Modales --}}



@stack("boton")
@endsection

