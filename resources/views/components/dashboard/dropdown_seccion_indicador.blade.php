@php
    $indicadores = [["value"=>"col-md-3","option"=>"1/4 de pantalla"],
    ["value"=>"col-md-4","option"=>"1/3 de pantalla"],
    ["value"=>"col-md-6","option"=>"1/2 de pantalla"],
    ["value"=>"col-md-12","option"=>"Pantalla completa"]];
@endphp


<select name="amplitud" id="" class="form-control">
@foreach ($indicadores as $indicador)
    <option value="{{ $indicador["value"] }}">{{ $indicador["option"] }}</option>
@endforeach
</select>
<button type="button" class="btn btn-success agregar-indicador font-20"><i class="lni lni-plus"></i></button>