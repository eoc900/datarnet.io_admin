{{-- ---> NOTA: Las funciones de front-end se encuentran en sistema_cobros.form_creator.layouts.index --}}
@php
    $subcampo = $subcampo ?? true; // si no se pasa, se asume que sí es subcampo (por AJAX)
@endphp
<div class="row configuracion-input shadow border border-light py-5 px-3 mt-3 {{ ($subcampo)?'subcampo':'' }}">
    <button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
    <h5 class="text-dark">Campo(s) de casillas</h5>
    <input type="hidden" name="{{ $subcampo ? 'input' : 'input[]' }}" value="checkbox">

    {{-- Función de enlazar valores de una tabla de base de datos --}}
    <div class="col-sm-6 mt-3">
        <div class="form-check form-switch">
            <input class="form-check-input enlazar-checkbox-btn" type="checkbox" id="">
            <label class="form-check-label" for="">Enlazar valores de alguna tabla (por ejemplo materias)</label>
            <input type="hidden" name="checkbox-enlazado" class="checkbox-enlazado" value="false">
        </div>
        
    </div>
    <div class="col-sm-6 mt-3 contenedor-tablas-disponibles d-none">
        <div class="d-flex">
            <select class="mt-5 mb-5 form-control select2" data-tags="true" data-placeholder="Buscar tablas" data-allow-clear="true" name="enlazar_tabla_checkbox">
            </select>
            {{-- <button class="btn btn-success"><i class="lni lni-circle-plus"></i></button> --}}
        </div>
        <div class="campo-draggable-columnas mt-3">
        </div>
    </div>
    <div class="col-sm-12 seccion-drop d-none">
        <div class="row">
            <div class="col-sm-6">
                    <label for="" class="form-label">Valores</label>
                    <div class="drop-column-value text-primary border border-primary">
                        <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                        <p class="text-center">Arrastra la columna aquí</p>
                    </div>
            </div>
            <div class="col-sm-6">
                    <label for="" class="form-label">Opciones del desplegable</label>
                    <div class="drop-column-option text-primary border border-primary">
                            <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                            <p class="text-center">Arrastra la columna aquí</p>
                    </div>
            </div>
        </div>
    </div>
    {{-- Función de enlazar valores de una tabla de base de datos --}}


    {{-- ---> datos básicos --}}
    <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Descripción del campo</label>
        <input type="text" placeholder="Selecciona las materias" class="form-control" name="{{ $subcampo ? 'label' : 'label[]' }}" value="{{ $input["placeholder"]??'' }}">
    </div>
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Atributo name</label>
        <input type="text" placeholder="opciones_materias" class="form-control" name="{{ $subcampo ? 'name' : 'name[]' }}" value="{{ $input["name"]??'' }}">
    </div>
    {{-- ---> datos básicos --}}


    <div class="input-group mt-2 info-no-enlazable">
        <button type="button" class="btn btn-outline-dark opcion">Configurar casilla</button>
        <input type="text" name="valor_checkbox" class="valor_checkbox append-input form-control" placeholder="Valor del checkbox">
        <input type="text" name="texto_checkbox" class="texto_checkbox append-input form-control" placeholder="Texto del checkbox">
        <button type="button" class="btn btn-primary agregar-casilla">+</button>
    </div>
    

    <div class="opciones-checkbox border border-primary mt-5 pb-5 info-no-enlazable">  {{-- ---> Aquí se hará un append  --}}
        <p class="text-primary"><i class="fadeIn animated bx bx-list-ol"></i>Casillas agregadas</p>
        <input type="hidden" class="valores_checkbox" name="{{ $subcampo ? 'valores_checkbox' : 'valores_checkbox[]' }}">
        <input type="hidden" class="textos_checkbox" name="{{ $subcampo ? 'textos_checkbox' : 'textos_checkbox[]' }}">
    </div>

      {{--VALIDACIONES: Aquí se pondrá por medio de frontend las validaciones --}}
    <div class="form-check form-switch mt-5 float-end">
            <input class="form-check-input validacion_activada" type="checkbox" id="" name="validacion_activada[{{ $i }}]" value="true">
            <label class="form-check-label" for="">Activar validación de campo</label>
    </div>    
    <div class="contenedor-validaciones" data-index="{{ $i }}"></div>{{-- Aquí hacemos append del elemento .caja-index --}}
    {{--VALIDACIONES: Aquí se pondrá por medio de frontend las validaciones --}}


    {{-- Previsualización  --}}
    @include('components.form_creator.previsualizacion')
    {{-- Previsualización  --}}
</div>
