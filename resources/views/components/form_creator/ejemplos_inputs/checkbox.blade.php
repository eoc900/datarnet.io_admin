@if (isset($show))
    @if (isset($campo["enlazado"]) && $campo["enlazado"]=="false" && isset($campo["valores"]) && isset($campo["textos"]) && isset($campo["label"]))

        <label class="form-label" for="">{{ $campo["label"] }}</label>
        @php
            $valores = explode(",",$campo["valores"]);
            $textos = explode(",",$campo["textos"]);
        @endphp
        @foreach ($valores as $index=>$valor)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $valor }}" {{ (isset($value) && in_array($valor,$value))?'checked':'' }}>
                <label class="form-check-label" >{{ $textos[$index] }}</label>
            </div>
        @endforeach
    @elseif (isset($campo["enlazado"]) && $campo["enlazado"]=="true" && isset($campo["tabla"]))
        <label class="form-label" for="">{{ $campo["label"] }}</label>
            @foreach ($campo["resultados_valores"] as $index=>$valor)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="{{ $valor }}" name="{{ $name }}[]" {{ (isset($campo["value"]) && in_array($valor,$value))?'checked':'' }}>
                    <label class="form-check-label" >{{ $campo["resultados_textos"][$index] }}</label>
                </div>
            @endforeach
    @else
    <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif
@else
    @if (isset($enlazado) && $enlazado=="false" && isset($valores) && isset($textos) && isset($label))

    <label class="form-label" for="">{{ $label }}</label>
    @php
        $valores = explode(",",$valores);
        $textos = explode(",",$textos);
    @endphp


    @foreach ($valores as $index=>$valor)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="{{ $valor }}" {{ (isset($value) && in_array($valor,$value))?'checked':'' }}>
            <label class="form-check-label" >{{ $textos[$index] }}</label>
        </div>
    @endforeach
    @elseif (isset($enlazado) && $enlazado=="true" && isset($tabla))
    <label class="form-label" for="">{{ $label }}</label>
        @foreach ($resultados_valores as $index=>$valor)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="{{ $valor }}" name="{{ $name }}[]" {{ (isset($value) && in_array($valor,$value))?'checked':'' }}>
                <label class="form-check-label" >{{ $resultados_textos[$index] }}</label>
            </div>
        @endforeach
    @else
    <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif
@endif




