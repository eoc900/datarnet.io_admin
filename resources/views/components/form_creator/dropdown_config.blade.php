 {{-- ---> NOTA: 
 Las funciones de front-end se encuentran en sistema_cobros.form_creator.layouts.index 
 --}}
@php
    $subcampo = $subcampo ?? true; // si no se pasa, se asume que sí es subcampo (por AJAX)
@endphp

<div class="row configuracion-input shadow border border-light py-5 px-3 mt-3 {{ ($subcampo)?'subcampo':'' }}">
    <button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
     <h5 class="text-dark">Desplegable con opciones</h5>
      <input type="hidden" name="{{ $subcampo ? 'input' : 'input[]' }}" value="{{ $input["type"] ?? 'dropdown' }}">
    {{-- ---> datos básicos --}}
     <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Nombre de etiqueta</label>
        <input type="text" placeholder="Ejemplo: Ingresa fecha de inicio" class="form-control" name="{{ $subcampo ? 'label' : 'label[]' }}" value="{{ $input["label"] ?? '' }}">
    </div>
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Atributo name</label>
        <input type="text" placeholder="fecha_inicio" class="form-control" name="{{ $subcampo ? 'name' : 'name[]' }}" value="{{ $input["name"] ?? '' }}">
    </div>
     {{-- ---> datos básicos --}}

     {{-- ---> MODULO IMPORTANTE: para alimentar columnas a áreas de drop <---- --}}
    <div class="col-sm-12 seleccion-tabla">
        <div class="row">
            <div class="col-sm-6">
                <div class="input-group">
                    <button type="button" class="btn btn-outline-dark">Tabla</button>
                    <select name="{{ $subcampo ? 'tabla' : 'tabla[]' }}" class="input-type form-control tabla-form-creator tabla_dropdown">
                        @foreach ($tablas as $tabla)
                            <option value="{{ $tabla }}" {{ (isset($input["tabla"])&&$tabla==$input["tabla"])?'selected':'' }}>{{ $tabla }}</option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-primary seleccionar-tabla">Seleccionar</button>
                </div>
            </div>
            <div class="col-sm-6">
                {{-- ---> para arrastrar  columnas --}}
                <div class="campo-draggable-columnas">
                </div>
                {{-- ---> para arrastrar  columnas --}}
            </div>
        </div>
    </div>
    {{-- ---> MODULO IMPORTANTE: para alimentar columnas a áreas de drop <---- --}}
   
    {{-- ---> para hacer drop de columnas --}}
    <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Valores del desplegable</label>
        <div class="drop-column-value text-primary border border-primary">
             @if(!isset($input["value"]))      
                <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                <p class="text-center">Arrastra la columna aquí</p>
            @endif
            @if(isset($input["value"]) && $i)                
               <div class="conjunto-arrastrable ui-draggable-dragging">
                <div class="input-group mb-3">
                    <button type="button" class="btn title btn-outline-success">valores</button>
                    
                    <span type="button" class="handle btn float-end ui-draggable-handle btn-success"><i class="lni lni-checkmark-circle"></i></span>
                    <input type="text" name="{{ $subcampo ? 'valor_columna_dropdown' : 'inputs['.$i.'][valor_columna_dropdown]' }}" class="valor_columna_dropdown form-control" value="{{ $input["value"] }}" readonly="">
                </div>
                </div>
            @endif
        </div>
    </div>
    <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Opciones del desplegable</label>
        <div class="drop-column-option text-primary border border-primary">
                @if(!isset($input["value"]))  
                <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                <p class="text-center">Arrastra la columna aquí</p>
                @endif
                @if(isset($input["option"]) && $i)                
                <div class="input-group mb-3">
                    <button type="button" class="btn title btn-outline-success">opciones</button>
                    
                    <span type="button" class="handle btn float-end ui-draggable-handle btn-success"><i class="lni lni-checkmark-circle"></i></span>
                <input type="text" name="{{ $subcampo ? 'opcion_columna_dropdown' : 'inputs['.$i.'][opcion_columna_dropdown]' }}" class="opcion_columna_dropdown form-control" value="{{ $input["option"] }}" readonly=""></div>
                @endif
        </div>
    </div>
    {{-- ---> para hacer drop de columnas --}}

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