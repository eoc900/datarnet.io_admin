@if (isset($show))
    
    @if (isset($campo["resultados"]))

        {{-- Atributo name --}}
        @php
            $nameAttr = "input[{$tabla}][{$index}][{$campo['name']}]";
        @endphp
        {{-- Atributo name --}}
        {{-- arreglo dropdown tiene un formato así ["value"=>"nombre_columna","option"=>"nombre_columna"] --}}
        <label for="" class="form-label">{{ $campo["label"] }}</label>
        <select name="{{ $nameAttr }}" id="" class="form-control">
            @foreach ($campo["resultados"] as $resultado)
                <option value="{{ $resultado->value }}" {{ ($campo["value"]==$resultado->value)?"selected":'' }}>{{ $resultado->option }}</option>
            @endforeach
        </select>
    
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif

    


@elseif(isset($simple_dropdown))


    <label for="" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="" class="form-control {{ $class ?? '' }}">
        @foreach ($resultados as $resultado)
            <option value="{{ $resultado->value }}" {{ (isset($value) && $value == $resultado->value) ? 'selected' : '' }}>
                {{ $resultado->option }}
            </option>
        @endforeach
    </select>


@else

    @if (isset($resultados))
    {{-- arreglo dropdown tiene un formato así ["value"=>"nombre_columna","option"=>"nombre_columna"] --}}
    <label for="" class="form-label">{{ $label }}</label>
    <select name="{{ $name }}" id="" class="form-control {{ $class ?? '' }}">
        @foreach ($resultados as $resultado)
            <option value="{{ $resultado->value }}" {{ ($value==$resultado->value)?"selected":'' }}>{{ $resultado->option }}</option>
        @endforeach
    </select>
    
    @else
        <div class="alert alert-warning">
            No obtuvimos los datos completos para correr la pre-visualización
        </div>
    @endif


@endif

