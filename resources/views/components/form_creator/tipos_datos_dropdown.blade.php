@if (isset($tipos_datos) && isset($name))
    @php 
    $tabla = $tabla ?? 'padre'; 
    $excel = $es_carga_excel ?? false;
    @endphp
    <tr>
    <td>
    <input type="text" readonly value="{{ $name }}" class="form-control" name="{{ $excel ? 'columna[]' : "campos[$tabla][$index][columna]" }}">
    </td>
    <td>
    <select name="{{ $excel ? 'tipo_dato[]' : "campos[$tabla][$index][tipo_dato]" }}" id="" class="form-control">
        @foreach ($tipos_datos as $tipo)
            <option value="{{ $tipo->tipo_dato }}">{{ $tipo->tipo_dato }}</option>
        @endforeach
    </select>
    </td>
    <td>
        <input type="number" class="form-control" name="{{ $excel ? 'limite_caracteres[]' : "campos[$tabla][$index][limite_caracteres]" }}" placeholder="Cantidad caracteres">
    </td>
    <td>
    <div class="form-check form-switch ms-5">
        @if ($excel)
            <input type="hidden" name="llave_primaria[{{ $index }}]" value="0">
            <input class="form-check-input" type="checkbox" name="llave_primaria[{{ $index }}]" value="1">
        @else
            <input class="form-check-input" type="checkbox" name="campos[{{ $tabla }}][{{ $index }}][llave_primaria]" value="1">
        @endif
    </div>
</td>

<td>
    <div class="form-check ms-5">
        @if ($excel)
            <input type="hidden" name="es_unico[{{ $index }}]" value="0">
            <input class="form-check-input" type="checkbox" name="es_unico[{{ $index }}]" value="1">
        @else
            <input class="form-check-input" type="checkbox" name="campos[{{ $tabla }}][{{ $index }}][es_unico]" value="1">
        @endif
    </div>
</td>

<td>
    <div class="form-check ms-5">
        @if ($excel)
            <input type="hidden" name="es_null[{{ $index }}]" value="0">
            <input class="form-check-input" type="checkbox" name="es_null[{{ $index }}]" value="1">
        @else
            <input class="form-check-input" type="checkbox" name="campos[{{ $tabla }}][{{ $index }}][es_null]" value="1">
        @endif
    </div>
</td>

<td>
    <div class="form-check ms-3">
        @if ($excel)
            <input type="hidden" name="es_foranea[{{ $index }}]" value="0">
            <input class="form-check-input checkbox-foranea" type="checkbox" name="es_foranea[{{ $index }}]" value="1">
        @else
            <input class="form-check-input checkbox-foranea" type="checkbox" name="campos[{{ $tabla }}][{{ $index }}][es_foranea]" value="1">
        @endif
    </div>
</td>

    <td>
        <div class="form-check ms-3" >
           {{-- PARA LLAVES FORANEAS: Aquí debemos de visualizar todas las tablas con un select --}}
           <select name="{{ $excel ? 'on_table[]' : "campos[$tabla][$index][on_table]" }}" id="" class="form-control on_table" data-index="{{ $index }}" data-main="{{ $tabla }}">
            @foreach ($tablas as $tabla_foreach)
                <option value="{{ $tabla_foreach  }}">{{ $tabla_foreach }}</option>
            @endforeach
           </select>
        </div>
    </td>
         {{-- PARA LLAVES FORANEAS: --}}
    <td>
        <div class="border-start form-check ms-3 on_row" data-index="{{ $index }}">
           {{-- Aquí debemos de visualizar todas los campos disponibles de la tabla seleccionada--}}
           <select name="{{ $excel ? 'on_row[]' : "campos[$tabla][$index][on_row]" }}" id="">
            <option value="false">No aplica</option>
           </select>
        </div>
    </td>                                      
</tr>
@endif