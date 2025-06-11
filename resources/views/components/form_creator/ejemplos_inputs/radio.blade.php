@if (isset($show))
    @if (isset($campo["opciones"]))
        {{-- Atributo name --}}
        @php
            $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
        @endphp
        <label for="" class="form-label">{{ $campo["placeholder"] }}</label>
        @foreach ($campo["opciones"] as $index=>$opcion)
            <div class="form-check">
                <input type="radio" id="{{ $index."_".$campo["name"] }}" name="{{ $nameAttr }}" value="{{ $opcion }}" class="form-check-input" {{ (isset($campo["value"]) && $campo["value"]==$opcion)?'checked':'' }}>
                <label for="{{ $index."_".$campo["name"] }}" class="form-check-label">{{ $opcion }}</label><br>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif
@else

    @if (isset($opciones))
        <label for="" class="form-label">{{ $placeholder }}</label>
        @foreach ($opciones as $index=>$opcion)
            <div class="form-check">
                <input type="radio" id="{{ $index."_".$name }}" name="{{ $name }}" value="{{ $opcion }}" class="form-check-input" {{ (isset($value) && $value==$opcion)?'checked':'' }}>
                <label for="{{ $index."_".$name }}" class="form-check-label">{{ $opcion }}</label><br>
            </div>
        @endforeach
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif


@endif

