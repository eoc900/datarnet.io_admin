@php
    $opciones = [["value"=>"dia","option"=>"Agrupar por días"],
    ["value"=>"semana","option"=>"Agrupar por semanas"],
    ["value"=>"mes","option"=>"Agrupar por meses"]]
@endphp

<select name="distribuir_por[]" class="dropdown_funcion_fecha form-control">
    @foreach($opciones as $opcion)
        <option value="{{ $opcion["value"] }}">{{ $opcion["option"] }}</option>
    @endforeach
</select>