{{-- ---> NOTA: Las funciones de front-end se encuentran en sistema_cobros.form_creator.layouts.index --}}
@php
    $subcampo = $subcampo ?? true; // si no se pasa, se asume que sí es subcampo (por AJAX)
@endphp

<div class="row configuracion-input shadow border border-light py-5 px-3 mt-3 {{ ($subcampo)?'subcampo':'' }}">
    <button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
    <h5 class="text-dark">Campo de correo</h5>
    <input type="hidden" name="{{ $subcampo ? 'input' : 'input[]' }}" value="email">
    {{-- ---> datos básicos --}}
     <div class="col-sm-6 mt-3">
        <label for="" class="form-label">Nombre de etiqueta</label>
        <input type="text" placeholder="Ejemplo: Ingresa fecha de inicio" class="form-control" name="{{ $subcampo ? 'label' : 'label[]' }}" value="{{ $input["label"]??'' }}">
    </div>
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Atributo name</label>
        <input type="text" placeholder="fecha_inicio" class="form-control" name="{{ $subcampo ? 'name' : 'name[]' }}" value="{{ $input["name"]??'' }}">
    </div>
    <div class="col-sm-6 mt-3 mb-5">
        <label for="" class="form-label">Texto de ejemplo en input (placeholder)</label>
        @if ($subcampo)
            <input type="text" placeholder="Inserta tu nombre" class="input-text form-control" name="placeholder" value="{{ $input["placeholder"]??'' }}">
        @else
            <input type="text" placeholder="Inserta tu nombre" class="input-text form-control" name="{{ isset($input["placeholder"])?'inputs['.$index.'][placeholder]':'placeholder[]' }}" value="{{ $input["placeholder"]??'' }}">
        @endif
       
    </div>
    {{-- ---> datos básicos --}}


    {{-- botón previsualización --}}
    <div class="col-sm-12">
        <button type="button" class="btn btn-outline-info previsualizar-btn mt-3">Previsualizar</button>
    </div>

    {{-- sección de previsualización --}}
    <div class="col-sm-12 previsualizacion mt-5 border border-info rounded-pill px-5 py-4 shadow">
    </div>
</div>