{{-- ---> NOTA: Las funciones de front-end se encuentran en sistema_cobros.form_creator.layouts.index --}}
@php
    $subcampo = $subcampo ?? true; // si no se pasa, se asume que sí es subcampo (por AJAX)
@endphp
<div class="row configuracion-input shadow border border-light py-5 px-3 mt-3 {{ ($subcampo)?'subcampo':'' }}">
    <button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
    <h5 class="text-dark">Campo de búsqueda</h5>
    <input type="hidden" name="{{ $subcampo ? 'input' : 'input[]' }}" value="select2">
    {{-- ---> datos básicos --}}
     <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Nombre de etiqueta</label>
        <input type="text" placeholder="Buscar registro" class="form-control" name="{{ $subcampo ? 'label' : 'label[]' }}" value="{{ $input["placeholder"]??'' }}">
    </div>
    <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Nombre del input</label>
        <input type="text" placeholder="id_primaria_alumno" class="form-control" name="{{ $subcampo ? 'name' : 'name[]' }}" value="{{ $input["name"]??'' }}">
    </div>
    
    {{-- ---> datos básicos --}}


     {{-- ---> MODULO IMPORTANTE: para alimentar columnas a áreas de drop <---- --}}
    <div class="col-sm-12 mt-5 seleccion-tabla">
        <div class="row">
            <div class="col-sm-6">
                <div class="input-group conjunto-arrastrable-tabla">
                    <button type="button" class="btn btn-outline-dark">Tabla</button>
                    <select name="{{ $subcampo ? 'tabla' : 'tabla[]' }}" class="input-type form-control tabla-form-creator">
                        @foreach ($tablas as $tabla)
                            <option value="{{ $tabla }}">{{ $tabla }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-info text-white seleccionar-tabla">Seleccionar</button>
                    @if (isset($tabla_arrastrable))
                         <span class="handle btn btn-primary"><i class="lni lni-move"></i></span>
                    @endif
                </div>
            </div>
            <div class="col-sm-6">
                {{-- ---> para arrastrar  columnas --}}
                <div class="campo-draggable-columnas">
                    @if(isset($input))
                        <div class="alert alert-info">Selecciona una tabla diferente para ver sus opciones</div>
                    @endif
                </div>
                {{-- ---> para arrastrar  columnas --}}
            </div>
        </div>
    </div>
    {{-- ---> MODULO IMPORTANTE: para alimentar columnas a áreas de drop <---- --}}


     {{-- ---> para hacer drop en secciones--}}
     <div class="col-sm-6 mt-3">
        <label for="" class="form-label text-primary">Realizar búsqueda en la siguiente tabla:</label>
        <div class="drop-tabla text-primary border border-primary">
            @if (!isset($input))
                <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                <p class="text-center">Arrastra tu tabla aquí</p>
            @endif
            @if(isset($input))
                <div class="input-group conjunto-arrastrable-tabla ui-draggable-dragging" style="width: 474px; height: 38px; position: relative; left: auto; top: auto;">
                <button type="button" class="btn btn-outline-dark">Tabla</button>
                <span class="handle btn ui-draggable-handle btn-outline-success"><i class="lni lni-checkmark-circle"></i></span>
                <input type="text" name="{{ $subcampo ? 'tabla_fuente' : 'inputs['.$i.'][tabla_fuente]' }}" class="tabla_fuente form-control" value="{{ $input["tabla"] }}" readonly=""></div>
            @endif
          
        </div>
    </div>
     <div class="col-sm-6 mt-3">
        <label for="" class="form-label text-primary">Buscar texto en los campos siguientes:</label>
        <div class="drop-campos-busqueda text-primary border border-primary pb-3 ps-3">
            @if (!isset($input))
            <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
            <p class="text-center">Arrastra columnas de tabla aquí</p>
            @endif
            @if(isset($input))
                @php
                    $firstIteration = false;
                @endphp

                @foreach ($input["buscar_en"] as $index=>$value)
                    <div class="conjunto-arrastrable ui-draggable-dragging mt-3">
                    <div class="input-group mb-3">
                        <button type="button" class="btn title btn-outline-success">buscar por</button>
                        <span type="button" class="handle btn float-end ui-draggable-handle btn-success"><i class="lni lni-checkmark-circle"></i></span>
                        <input type="text" name="{{ $subcampo ? 'buscar_en' : 'inputs['.$i.'][buscar_en]'}}" class="buscar_en form-control" value="{{ $value }}" readonly="">
                        <button type="button" class="btn btn-warning concatenado purple" data-concatenado="purple"><i class="lni lni-link"></i></button>
                        @if (!$firstIteration)
                            @if(isset($input["campos_concatenados"]))
                            <input type="hidden" name="{{ $subcampo ? 'campos_concatenados' : 'inputs['.$i.'][campos_concatenados]'}}" class="form-control campos_concatenados" value="{{ implode(',',$input["campos_concatenados"]) }}" readonly="">
                            @endif
                            <input type="hidden" name="{{ $subcampo ? 'campos_busqueda' : 'inputs['.$i.'][campos_busqueda]'}}" class="form-control campos_busqueda" value="{{ implode(',',$input["buscar_en"]) }}" readonly="">
                             @php
                                $firstIteration = true;
                            @endphp
                        @endif
                    </div>
                    </div>
                @endforeach
               


            @endif

        </div>
    </div>
    <div class="col-sm-6 mt-3">
        <label for="" class="form-label text-primary">Campos respuesta retorno:</label>
        <div class="drop-campos-respuesta text-primary border border-primary">
            @if(!isset($input))
            <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
            <p class="text-center">Los resultados que verás como opciones</p>
            @endif
            @if(isset($input))
                @php
                    $firstIteration = false;
                @endphp

                @foreach ($input["retornar"] as $index=>$value)
                    <div class="conjunto-arrastrable ui-draggable-dragging mt-3">
                        <div class="input-group mb-3">
                            <button type="button" class="btn title btn-outline-success">Retornar</button>
                            <span type="button" class="handle btn float-end ui-draggable-handle btn-success"><i class="lni lni-checkmark-circle"></i></span>
                        <input type="text" name="{{ $subcampo ? 'respuesta' : 'inputs['.$i.'][respuesta]'}}" class="respuesta form-control" value="{{ $value }}" readonly="">
                        @if (!$firstIteration)
                         <input type="hidden" name="{{ $subcampo ? 'campos_respuesta' : 'inputs['.$i.'][campos_respuesta]'}}" class="form-control campos_respuesta" value="{{ implode(",",$input["retornar"]) }}" readonly="">
                            @php
                                $firstIteration = true;
                            @endphp
                         @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="col-sm-6 mt-3">
        <label for="" class="form-label text-primary">Campo identificador:</label>
        <div class="drop-campo-identificador text-primary border border-primary">
            @if (!isset($input))
                <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                <p class="text-center">ID principal</p>
            @endif
            @if (isset($input))
                <div class="conjunto-arrastrable ui-draggable-dragging mt-3" style="width: 474px; height: 38px; position: relative; left: auto; top: auto;">
                <div class="input-group mb-3">
                    <button type="button" class="btn title btn-outline-success">principal</button>
                    <span type="button" class="handle btn float-end ui-draggable-handle btn-success"><i class="lni lni-checkmark-circle"></i></span>
                    <input type="text" name="{{ $subcampo ? 'principal' : 'inputs['.$i.'][principal]'}}" class="principal form-control" value="{{ $input["principal"] }}" readonly="">
                </div>
                </div>
            @endif
        </div>
    </div>
    {{-- ---> para hacer drop en secciones--}}


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