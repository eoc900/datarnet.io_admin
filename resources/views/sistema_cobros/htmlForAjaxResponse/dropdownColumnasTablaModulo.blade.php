@if (isset($columnas) && isset($tabla) && isset($arrastrable) && $arrastrable!="")
            
            <div class="conjunto-arrastrable">
                <div class="input-group mb-3">
                    <button type="button" class="btn btn-outline-dark title">Columna</button>
                    <select name="opciones_columnas" id="opciones_columnas" class="form-control float-start">
                    @foreach ($columnas as $columna)
                        <option value="{{ $tabla.".".$columna }}">{{ $columna }}</option>
                    @endforeach
                    </select>
                    <span type="button" class="handle btn btn-primary float-end">Arrastrar <i class="lni lni-move"></i></span>
                </div>
            </div>
@elseif (isset($only_columnas) && $only_columnas==true)
       
            @if (isset($multi_item) && !$excel)
                <select name="campos[{{ $multi_item_tabla }}][{{ $multi_item_index }}][on_row]" class="form-control">
            @else
                <select name="on_row[{{ $index }}]" class="form-control">
            @endif
                @foreach ($columnas as $columna)
                    <option value="{{ $tabla.".".$columna }}">{{ $columna }}</option>
                @endforeach
            </select>

@elseif(isset($drag_drop) && $drag_drop==true)
        <div class="arrastrar_columna">
            <label for="" class="form-label">Tabla: {{ $tabla }}</label>
            <div class="input-group mb-3">
                <select name="on_row[{{ $index }}]" id="dropdown_tabla_{{ $index }}" class="form-control float-start">
                    @foreach ($columnas as $columna)
                        <option value="{{ $tabla.".".$columna }}">{{ $columna }}</option>
                    @endforeach
                </select>
                <span class="btn btn-primary handle"><i class="lni lni-move"></i></span>
            </div>
        </div>
@else
            <label for="opciones_columnas" class="form-label">Selecciona la columna que quieres incluir</label><br>
            <div class="input-group mb-3">
                <select name="opciones_columnas" id="opciones_columnas" class="form-control float-start">
                @foreach ($columnas as $columna)
                    <option value="{{ $tabla.".".$columna }}">{{ $columna }}</option>
                @endforeach
                </select>
                <button type="button" class="seleccionar_columna btn btn-primary float-end">Seleccionar +</button>
            </div>

@endif