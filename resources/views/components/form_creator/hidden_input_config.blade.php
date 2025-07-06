{{-- ---> NOTA: Las funciones de front-end se encuentran en sistema_cobros.form_creator.layouts.index --}}
@php
    $subcampo = $subcampo ?? true; // si no se pasa, se asume que sí es subcampo (por AJAX)
@endphp
<div class="configuracion-input shadow border border-light py-5 px-3 mt-3 {{ ($subcampo)?'subcampo':'' }}">
    <button type="button" class="remove-conf-input btn btn-danger"><i class="lni lni-close"></i></button>
    <h5 class="text-dark">Campo de texto oculto</h5>
    <input type="hidden" name="{{ $subcampo ? 'input' : 'input[]' }}" value="{{ $input["type"] ?? 'hidden' }}">
    {{-- ---> datos básicos --}}
   
    <label for="" class="form-label">Atributo name</label>
    <input type="text" placeholder="Nombre de la columna" class="form-control" name="{{ $subcampo ? 'name' : 'name[]' }}" value="{{ $input["name"] ?? '' }}">

    <label for="" class="form-label">Asignar un valor oculto</label>
    <input type="text" placeholder="Ejemplo de código: 1231XX" class="form-control" name="{{ $subcampo ? 'valor_oculto' : 'inputs['.$i.'][valor_oculto]' }}" value="{{ $input["name"] ?? '' }}">

</div>