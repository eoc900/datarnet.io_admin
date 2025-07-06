@if (isset($show))
    @if (isset($campo["label"]) && isset($campo["name"]) && isset($campo["formatos"]))
        @php
            $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
        @endphp

        <div class="mb-3">
            <label class="form-label">{{ $campo["label"] }}</label>
            <input type="file" class="form-control" name="{{ $nameAttr }}" accept="{{ $campo["formatos"] }}">
        </div>
        @if (isset($campo["directorio"]))
            <input type="hidden" name="input[{{ $tabla }}][{{ $index }}][directorio]" value="{{ $campo["directorio"] }}">
        @endif

        @if (isset($campo["formatos"]))
            <input type="hidden" name="input[{{ $tabla }}][{{ $index }}][formatos]" value="{{ $campo["formatos"] }}">
        @endif

    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif
@else
    @if (isset($label) && isset($name) && isset($formatos))
        @php
            //$formatos = implode(",",$formatos);
        @endphp

        <div class="mb-3">
            <label class="form-label">{{ $label }}</label>
            <input type="file" class="form-control" name="{{ $name }}" accept="{{ $formatos }}">
        </div>
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif
@endif

