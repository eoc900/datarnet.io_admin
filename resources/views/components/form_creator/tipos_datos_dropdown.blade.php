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
            <input class="form-check-input" type="checkbox" name="{{ $excel ? 'llave_primaria[]' : "campos[$tabla][$index][llave_primaria]" }}">
            {{-- <label class="form-check-label" for="flexSwitchCheckChecked">Es llave primaria</label> --}}
        </div>
    </td>
    <td>
        <div class="form-check ms-5">
            <input class="form-check-input" type="checkbox" name="{{ $excel ? 'es_unico[]' : "campos[$tabla][$index][es_unico]" }}">
        </div>
    </td>
    <td>
        <div class="form-check ms-5">
            <input class="form-check-input" type="checkbox" value="true" id="" name="{{ $excel ? 'es_null[]' : "campos[$tabla][$index][es_null]" }}">
        </div>
    </td>
    <td>
         <div class="form-check ms-3">
            <input class="form-check-input checkbox-foranea" type="checkbox" value="true" id="" name="{{ $excel ? 'es_foranea[]' : "campos[$tabla][$index][es_foranea]" }}">
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