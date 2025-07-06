@if (isset($campo["label"]) && isset($campo["name"]))
{{-- Atributo name --}}
@php
    $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
@endphp
{{-- Atributo name --}}
<label for="" class="form-label">{{ $campo["label"]}}</label>
<input type="text" name="{{ $nameAttr }}" placeholder="{{ $campo["placeholder"] }}" class="form-control" value="{{ $campo["value"] ?? '' }}">
@else
    <div class="alert alert-warning">
        No obtuvimos los datos completos para correr la pre-visualización
    </div>
@endif
