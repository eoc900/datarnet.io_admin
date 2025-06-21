{{-- ---> NOTA: Las funciones de front-end se encuentran en sistema_cobros.form_creator.layouts.index --}}
@php
    $subcampo = $subcampo ?? true; // si no se pasa, se asume que sí es subcampo (por AJAX)
@endphp

<div class="row configuracion-input shadow border border-light py-5 px-3 mt-3 {{ ($subcampo)?'subcampo':'' }}">
    <button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
    <h5 class="text-dark">Campos opciones radio</h5>
    <input type="hidden" name="{{ $subcampo ? 'input' : 'input[]' }}" value="radio">
    {{-- ---> datos básicos --}}
     <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Nombre de etiqueta</label>
        <input type="text" placeholder="Nombre del alumno" class="form-control" name="{{ $subcampo ? 'label' : 'label[]' }}" value="{{ $input["placeholder"]??'' }}">
    </div>
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Nombre del input</label>
        <input type="text" placeholder="Nombre del alumno" class="form-control" name="{{ $subcampo ? 'name' : 'name[]' }}" value="{{ $input["name"]??'' }}">
    </div>
    {{-- ---> datos básicos --}}


    <div class="input-group mt-2">
        <button type="button" class="btn btn-outline-dark opcion">Opción</button>
        <input type="text" name="append_input" class="append-input form-control" placeholder="Ingresa tu opción aquí">
        <button type="button" class="btn btn-primary agregar-radio">+</button>
    </div>
    

    <div class="opciones-radio border border-primary mt-5 pb-5 ">  {{-- ---> Aquí se hará un append  --}}
        <p class="text-primary"><i class="fadeIn animated bx bx-list-ol"></i> Opciones radio seleccionadas</p>
        @if (isset($input["opciones"]))
            <input type="hidden" name="{{ $subcampo ? 'opciones_radio' : 'inputs['.$i.'][opciones_radio]' }}" value="{{implode(',',$input["opciones"])}}" class="opciones_radio">
            @foreach ($input["opciones"] as $opcion)
                <div class="input-group mt-2">
                    <button type="button" class="btn btn-outline-dark opcion">Opción</button>
                    <input type="text" name="append_input" class="append-input form-control" placeholder="Ingresa tu opción aquí" value="{{ $opcion }}" readonly="readonly">
                    <button type="button" class="btn btn-danger remove">x</button>
                </div>
            @endforeach
        @endif

         @if (!isset($input["opciones"]))
            <input type="hidden" name="opciones_radio[]" class="opciones_radio">
         @endif
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