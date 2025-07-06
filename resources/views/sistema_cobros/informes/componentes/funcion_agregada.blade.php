<div class="agregado mb-3 d-flex align-items-center mt-4">
    <select name="agregados[{{$index}}][funcion]" class="form-select me-2">
        @foreach(['COUNT', 'SUM', 'AVG', 'MIN', 'MAX'] as $funcion)
            <option value="{{ $funcion }}" {{ $valor_funcion === $funcion ? 'selected' : '' }}>{{ $funcion }}</option>
        @endforeach
    </select>

    <select name="agregados[{{$index}}][columna]" class="form-select me-2">
        @foreach($columnas as $tabla => $cols)
            <optgroup label="{{ $tabla }}">
                @foreach($cols as $columna)
                    @php $columnaCompleta = "$tabla.$columna"; @endphp
                    <option value="{{ $columnaCompleta }}" {{ $valor_columna === $columnaCompleta ? 'selected' : '' }}>{{ $columna }}</option>
                @endforeach
            </optgroup>
        @endforeach
        <option value="*" {{ $valor_columna === '*' ? 'selected' : '' }}>*</option>
    </select>

    <input type="text" name="agregados[{{$index}}][alias]" placeholder="Alias" class="form-control me-2" value="{{ $valor_alias ?? '' }}" />

    <button type="button" class="btn btn-danger btn-sm eliminar-agregado">×</button>
</div>
