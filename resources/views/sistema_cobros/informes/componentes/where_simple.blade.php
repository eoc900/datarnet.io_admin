<div class="{{ (!$esSubgrupo)?'condicion':'' }} condicion-simple mb-2 mt-2 shadow p-3" data-tipo="simple" data-index="{{ $index }}">

    {{-- Para que no haya where logico en la primera condición --}}
    @if((isset($index) && ($index > 0) && !$esSubgrupo) || (isset($index_interno) && ($index_interno > 0)))
    @if($esSubgrupo)
            <select name="where_logico_subgrupo[{{ $index . '_' . $index_interno }}]" class="form-select me-2">
                <option value="AND" {{ (isset($valor['logico']) && $valor['logico'] == 'AND') ? 'selected' : '' }}>AND</option>
                <option value="OR"  {{ (isset($valor['logico']) && $valor['logico'] == 'OR') ? 'selected' : '' }}>OR</option>
            </select>
        @else
            <select name="where_logico[]" class="form-select me-2">
                <option value="AND">AND</option>
                <option value="OR">OR</option>
            </select>
        @endif
    @endif




    <select name="where[{{ $esSubgrupo ? $index . '_' . $index_interno : $index }}][columna]" class="form-select w-auto me-2">
        <option value="">-- Seleccionar columna --</option>
        @foreach ($columnas as $tabla => $cols)
            @foreach ($cols as $col)
                <option value="{{ $tabla . '.' . $col }}">{{ $tabla }}.{{ $col }}</option>
            @endforeach
        @endforeach
    </select>

    <select name="where[{{ $esSubgrupo ? $index . '_' . $index_interno : $index }}][operador]" class="form-select w-auto me-2">
        <option value="=">=</option>
        <option value="!=">!=</option>
        <option value="<"><</option>
        <option value=">">></option>
        <option value="BETWEEN">BETWEEN</option>
        <option value="LIKE">LIKE</option>
        <option value="IN">IN</option>
        <option value="NOT IN">NOT IN</option>
        <option value="IS NULL">IS NULL</option>
        <option value="IS NOT NULL">IS NOT NULL</option>
    </select>

    <div class="input-group">
        <button type="button" class="btn btn-outline-primary activar-filtro me-2">
            <i class="fadeIn animated bx bx-filter"></i>
        </button>
           <!-- Dropdown de selección de filtro (inicialmente oculto) -->
        <select name="where[{{ $esSubgrupo ? $index . '_' . $index_interno : $index }}][filtro_parametro]" class="form-select me-2 filtro-parametro d-none">
            <option value="">-- Usar valor de filtro --</option>
            <option value="fecha_inicial">Fecha Inicial</option>
            <option value="fecha_finaliza">Fecha Finaliza</option>
            <option value="dos_fechas">Fecha inicial y Fecha Final</option>
            <option value="texto_busqueda">Texto de Búsqueda</option>
        </select>
        <input type="hidden" name="where[{{ $esSubgrupo ? $index . '_' . $index_interno : $index }}][filtro_activo]" class="filtro-activo">
        <input type="text" name="where[{{ $esSubgrupo ? $index . '_' . $index_interno : $index }}][valor]" class="form-control me-2 input-valor" placeholder="valor o lista">
        <button type="button" class="btn btn-danger eliminar-condicion">×</button>
    </div>
</div>
