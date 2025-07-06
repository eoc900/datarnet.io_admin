@if (isset($show))
    @if (isset($campo["valor_oculto"]) && isset($campo["name"]))
          {{-- Atributo name --}}
        @php
            $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
        @endphp

        <label for="" class="form-label">{{ $label }}</label>
        <input type="hidden" name="{{ $nameAttr }}" placeholder="{{ $campo["placeholder"] }}" class="form-control" value="{{ $campo["valor_oculto"] ?? '' }}">
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif

@else
    @if (isset($valor_oculto) && isset($name))
    <label for="" class="form-label">{{ $label }}</label>
    <input type="hidden" name="{{ $name }}" placeholder="{{ $placeholder }}" class="form-control" value="{{ $valor_oculto ?? '' }}">
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif


@endif







