<div class="row pb-5">
    {{-- Sección para seleccionar tablas --}}
    @if(isset($tablas))
    <div class="col-sm-12">
        <div class="input-group mb-3">
            <select id="opciones_tabla_query" class="form-control">
                @foreach ($tablas as $tabla)
                    <option value="{{ $tabla }}">{{ $tabla }}</option>
                @endforeach
            </select>
            <button type="button" class="btn btn-success" id="agregar_tabla_query">+</button>
        </div>

        {{-- Input oculto para guardar tablas agregadas --}}
        <input type="hidden" name="tablas_seleccionadas_query" id="tablas_seleccionadas_query" value="{{ $elemento["query"]["tablas_seleccionadas"]??'' }}">

        {{-- Aquí se verán las tablas que han sido agregadas --}}
        <div class="tablas_agregadas" id="tablas_agregadas_query">

            @if (isset($elemento["query"]["tablas_seleccionadas"]))
                @php
                    $seleccionadas = explode(',',$elemento["query"]["tablas_seleccionadas"])
                @endphp
                
                @foreach ($seleccionadas as $seleccionada)
                        <button type="button" class="btn btn-outline-primary btn-sm me-2 mb-2 tabla-btn" data-tabla="{{ $seleccionada }}">
                            {{ $seleccionada }}
                            <span class="text-danger ms-1 eliminar-tabla" style="cursor:pointer;">&times;</span>
                        </button>
                @endforeach
                
            @endif
        </div>
        {{-- Aquí se verán las tablas que han sido agregadas --}}
        <hr>
        {{-- Sección dropdown columnas agregadas --}}
        <div id="columnas_agregadas">
            @if(isset($columnasPorTabla) && count($columnasPorTabla))
                @foreach($columnasPorTabla as $tabla => $columnas)
                    @php
                        $safeId = str_replace('.', '_', $tabla);
                    @endphp
                    <div class="columnas-de-tabla mt-2" id="columnas_tabla_{{ $safeId }}" data-tabla="{{ $tabla }}">
                        <label class="form-label"><strong>Columnas de {{ $tabla }}</strong></label>
                        <div class="arrastrar_columna">
                            <div class="input-group mb-3">
                                <select name="on_row[]" class="form-control float-start">
                                    @foreach($columnas as $columna)
                                        <option value="{{ $tabla . '.' . $columna }}">{{ $columna }}</option>
                                    @endforeach
                                </select>
                                <span class="btn btn-primary handle"><i class="lni lni-move"></i></span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{-- Sección dropdown columnas agregadas --}}

        {{-- Dropdown tabla principal --}}
        <div id="dropdown_tabla_principal" class="mb-3 d-none">
            <label for="tabla_principal" class="form-label">Tabla principal</label>
            <select name="tabla_principal" id="tabla_principal" class="form-control">
                @foreach(explode(',', $elemento["query"]["tablas_seleccionadas"] ?? '')  as $tabla)
                    <option value="{{ $tabla }}"
                    @if(
                        (isset($elemento["query"]["tabla_principal"]) && $elemento["query"]["tabla_principal"] === $tabla)
                        || (!isset($elemento["query"]["tabla_principal"]) && $loop->first)
                    )
                        selected
                    @endif
                    >{{ $tabla }}</option>
                @endforeach
            </select>
        </div>
        {{-- Dropdown tabla principal --}}


        {{-- Sección para arrastrar columnas seleccionadas --}}
        <label for="" class="form-label text-primary">Arrastra los datos que quieres incluir</label>
        <div id="columnas_seleccionadas">
              @if (isset($elemento["query"]["columnas_seleccionadas"]) && is_array($elemento["query"]["columnas_seleccionadas"]))
                @foreach ($elemento["query"]["columnas_seleccionadas"] as $columna)
                    <div class="arrastrar_columna conjunto-arrastrable mt-3">
                        <div class="input-group mb-2">
                          

                            {{-- Campo de valor oculto/lectura para enviar --}}
                            <input type="text" name="seleccionar[]" class="form-control" value="{{ $columna }}" readonly>

                            {{-- Botón para eliminar --}}
                            <span class="btn btn-danger handle remove-seleccionada" title="Eliminar columna">
                                &times;
                            </span>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        {{-- Sección para arrastrar columnas seleccionadas --}}

        {{-- Contenedor para joins --}}
        <div id="joins_configuracion" class="mt-4 mb-5{{ isset($elemento["query"]["joins"]) ? '' : 'd-none' }}">
            <p><b>Configuración de joins</b></p>
            <div id="zona_joins">
                @if (isset($elemento["query"]["joins"]) && is_array($elemento["query"]["joins"]))
                    @foreach ($elemento["query"]["joins"] as $index => $join)
                        <div class="row align-items-center mb-3 join-block border shadow pb-4 pt-3">
                            <div class="col-md-6">
                                <label>Tabla A: {{ $join['tabla_a'] }}</label>
                                <input type="text" class="form-control" value="{{ $join['tabla_a'] }}" readonly>
                                <input type="hidden" name="joins[{{ $index }}][tabla_a]" value="{{ $join['tabla_a'] }}">
                            </div>

                            <div class="col-md-12">
                                <label>Columna A</label>
                                <div class="drop-columna-a border rounded p-2" data-index="{{ $index }}" data-tabla="{{ $join['tabla_a'] }}">
                                    @if (!empty($join["columna_a"]))
                                        <input type="text" class="form-control mb-1" name="joins[{{ $index }}][columna_a]" value="{{ $join['columna_a'] }}" readonly>
                                        <button type="button" class="btn btn-sm btn-danger eliminar-columna float-end">×</button>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>Tabla B: {{ $join['tabla_b'] }}</label>
                                <input type="text" class="form-control" value="{{ $join['tabla_b'] }}" readonly>
                                <input type="hidden" name="joins[{{ $index }}][tabla_b]" value="{{ $join['tabla_b'] }}">
                            </div>

                            <div class="col-md-12">
                                <label>Columna B</label>
                                <div class="drop-columna-b border rounded p-2" data-index="{{ $index }}" data-tabla="{{ $join['tabla_b'] }}">
                                    @if (!empty($join["columna_b"]))
                                        <input type="text" class="form-control mb-1" name="joins[{{ $index }}][columna_b]" value="{{ $join['columna_b'] }}" readonly>
                                        <button type="button" class="btn btn-sm btn-danger eliminar-columna float-end">×</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

            </div>
        </div>
        {{-- Sección para configurar los joins --}}

        {{-- Definir el tipo de sección where que se va a agregar --}}
        <hr>
        <p><b>Condiciones where</b></p>
        <div class="mt-2 input-group">
            <select id="tipo_condicion_a_agregar" class="form-select">
                <option value="simple">Condición simple</option>
                <option value="grupo">Grupo de condiciones (AND / OR)</option>
            </select>
            <button type="button" id="agregar_condicion" class="btn btn-primary ms-2">Agregar condición</button>
        </div>
        {{-- Definir el tipo de sección where que se va a agregar --}}


        {{-- Condiciones where --}}
        <div id="where_condiciones">
                <input type="hidden" name="orden_condiciones" id="orden_condiciones">
              @if(isset($elemento['query']['where']) && is_array($elemento["query"]['where']))
                @foreach($elemento['query']['where'] as $index => $condicion)
                    @if(isset($condicion['grupo']))
                    
                        <div class="condicion grupo-condiciones border p-2 mb-3 mt-3" data-index="{{ $index }}">
                            @if (isset($condicion['logico']))
                                 <select name="where_logico_grupal[]" class="form-select mb-2 mb-4" style="max-width: 100px;">
                                    <option value="AND" {{ ($condicion['logico']=='AND')?'selected':'' }}>AND</option>
                                    <option value="OR" {{ ($condicion['logico']=='OR')?'selected':'' }}>OR</option>
                                </select>
                            @endif                  
                            <div class="contenido-grupo">
                                @foreach($condicion['grupo'] as $subkey => $subcondicion)
                                @php
                                    $isFirst = $loop->first;
                                    $filtroActivo = isset($subcondicion['filtro_activo']) && $subcondicion['filtro_activo'] === 'true';
                                    $filtroParametro = $subcondicion['filtro_parametro'] ?? '';
                                @endphp

                                    <div class="condicion-simple mb-2 shadow">
                                        @unless($isFirst)
                                            <select name="where_logico_subgrupo[{{ $subkey }}]" class="form-select w-auto me-2">
                                                <option value="AND" {{ (isset($subcondicion['logico']) && $subcondicion['logico']=='AND')?'selected':'' }}>AND</option>
                                                <option value="OR" {{ (isset($subcondicion['logico']) && $subcondicion['logico']=='OR')?'selected':'' }}>OR</option>
                                            </select>
                                        @endunless
                                        <select name="where[{{ $subkey }}][columna]" class="form-select w-auto me-2">
                                            <option selected>{{ $subcondicion['columna'] }}</option>
                                        </select>
                                        <select name="where[{{ $subkey }}][operador]" class="form-select w-auto me-2">
                                            <option selected>{{ $subcondicion['operador'] }}</option>
                                        </select>
                                        <div class="input-group">
                                         <button type="button" class="btn btn-outline-primary activar-filtro me-2">
                                              {!! $filtroActivo ? '-' : '<i class="fadeIn animated bx bx-filter"></i>' !!}
                                        </button>
                                          <!-- Dropdown de selección de filtro (inicialmente oculto) -->
                                               <select name="where[{{ $subkey }}][filtro_parametro]" class="form-select filtro-parametro {{ $filtroActivo ? '' : 'd-none' }}">
                                                    <option value="">-- Usar valor de filtro --</option>
                                                    <option value="fecha_inicial" {{ $filtroParametro == 'fecha_inicial' ? 'selected' : '' }}>Fecha Inicial</option>
                                                    <option value="fecha_finaliza" {{ $filtroParametro == 'fecha_finaliza' ? 'selected' : '' }}>Fecha Finaliza</option>
                                                    <option value="dos_fechas" {{ $filtroParametro == 'dos_fechas' ? 'selected' : '' }}>Fecha Inicial y Fecha Finaliza</option>
                                                    <option value="texto_busqueda" {{ $filtroParametro == 'texto_busqueda' ? 'selected' : '' }}>Texto de Búsqueda</option>
                                                </select>

                                         <input type="hidden" name="where[{{ $subkey }}][filtro_activo]" value="{{ $filtroActivo ? 'true' : 'false' }}" class="filtro-activo">

                                         <input type="text" name="where[{{ $subkey }}][valor]" class="form-control d-inline-block input-valor" value="{{ $subcondicion['valor'] ?? '' }}" {{ $filtroActivo ? 'disabled' : '' }}>                                        
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-2 d-flex justify-content-between">
                                <button type="button" class="btn btn-sm btn-outline-primary agregar-condicion-simple-grupo" data-index="{{ $index }}">+ condición</button>
                                <button type="button" class="btn btn-sm btn-outline-danger eliminar-grupo">× eliminar grupo</button>
                            </div>

                        </div>                     
                    @else
                        <div class="condicion condicion-simple mb-2 shadow mt-2 p-3" data-index="{{ $index }}">
                            @php
                                $filtroActivo = isset($condicion['filtro_activo']) && $condicion['filtro_activo'] === 'true';
                                $filtroParametro = $condicion['filtro_parametro'] ?? '';
                            @endphp


                            @if($index > 0)
                                <select name="where_logico[]" class="form-select w-auto me-2 mb-4">
                                    <option value="AND" {{ (isset($condicion['logico']) && $condicion['logico']=='AND') ? 'selected' : '' }}>AND</option>
                                    <option value="OR"  {{ (isset($condicion['logico']) && $condicion['logico']=='OR')  ? 'selected' : '' }}>OR</option>
                                </select>
                            @endif
                            <select name="where[{{ $index }}][columna]" class="form-select w-auto me-2">
                                <option selected>{{ $condicion['columna'] }}</option>
                            </select>
                            <select name="where[{{ $index }}][operador]" class="form-select w-auto me-2">
                                <option selected>{{ $condicion['operador'] }}</option>
                            </select>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-primary activar-filtro me-2">
                                    {!! $filtroActivo ? '-' : '<i class="fadeIn animated bx bx-filter"></i>' !!}
                                </button>
                                   <!-- Dropdown de selección de filtro (inicialmente oculto) -->
                                <select name="where[{{ $index }}][filtro_parametro]" class="form-select filtro-parametro {{ $filtroActivo ? '' : 'd-none' }}">
                                    <option value="">-- Usar valor de filtro --</option>
                                    <option value="fecha_inicial" {{ $filtroParametro == 'fecha_inicial' ? 'selected' : '' }}>Fecha Inicial</option>
                                    <option value="fecha_finaliza" {{ $filtroParametro == 'fecha_finaliza' ? 'selected' : '' }}>Fecha Finaliza</option>
                                    <option value="dos_fechas" {{ $filtroParametro == 'dos_fechas' ? 'selected' : '' }}>Fecha Inicial y Fecha Finaliza</option>
                                    <option value="texto_busqueda" {{ $filtroParametro == 'texto_busqueda' ? 'selected' : '' }}>Texto de Búsqueda</option>
                                </select>

                                <input type="hidden" name="where[{{ $index }}][filtro_activo]" value="{{ $filtroActivo ? 'true' : 'false' }}" class="filtro-activo">
                                <input type="text" name="where[{{ $index }}][valor]" class="form-control d-inline-block input-valor" value="{{ $condicion['valor'] ?? '' }}" {{ $filtroActivo ? 'disabled' : '' }}>
                                <button type="button" class="btn btn-danger eliminar-condicion">×</button>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        {{-- Condiciones where --}}
        <hr>

        {{-- Funciones agregadas --}}
         <p><b>Funciones</b></p>
        <div class="mt-2 ">        
            <button type="button" id="agregar_funcion" class="btn btn-primary">Agregar una función</button>
        </div>
        <div id="funciones_agregadas" class="mb-5">
                @php
                    $funcionesGuardadas = $elemento["query"]['agregados'] ?? [];
                    $columnasPlanas = [];
                    foreach ($columnasPorTabla as $tabla => $cols) {
                        foreach ($cols as $col) {
                            $columnasPlanas[] = $tabla . '.' . $col;
                        }
                    }
                @endphp
          
              

              @foreach($funcionesGuardadas as $index => $agregado)

                 @include('sistema_cobros.informes.componentes.funcion_agregada', [
                    'index' => $index,
                    'valor_funcion' => $agregado['funcion'] ?? '',
                    'valor_columna' => $agregado['columna'] ?? '',
                    'valor_alias' => $agregado['alias'] ?? '',
                    'columnas' => $columnasPorTabla // ← asegúrate que esté disponible
                ]) 
                @endforeach
        
        </div>
        {{-- Funciones agregadas --}}

        <hr>
        {{-- Agrupaciones --}}
        <div class="mt-5">
            <p><strong>Agrupar por</strong></p>
            <div class="d-flex mb-2">
                <select id="columnas_para_agrupacion" class="form-select me-2">
                    {{-- Opciones se actualizan vía JS con base en #columnas_seleccionadas --}}
                </select>
                <button type="button" id="agregar_agrupacion" class="btn btn-primary btn-sm">Agregar agrupación</button>
            </div>
            @php
                $groupBy = $elemento['query']['group_by'] ?? [];
            @endphp
            <div id="agrupaciones_agregadas">
                 @foreach($groupBy as $columna)
                    <button type="button" class="btn btn-outline-primary btn-sm me-2 mb-2 tabla-btn" data-columna="{{ $columna }}">
                        {{ $columna }}
                        <span class="text-danger ms-1 eliminar-agrupacion" style="cursor:pointer;">×</span>
                        <input type="hidden" name="group_by[]" value="{{ $columna }}">
                    </button>
                @endforeach
            </div>
        </div>
        {{-- Agrupaciones --}}

        <hr>
        {{-- Ordenamientos --}}
        <div class="mt-5">
            <p><strong>Ordenar por</strong></p>
            <div class="d-flex mb-2">
                <select id="orden_columna" class="form-select me-2">
                    {{-- Se actualiza con base en columnas seleccionadas --}}
                </select>
                <select id="orden_direccion" class="form-select me-2" style="max-width: 120px;">
                    <option value="ASC">ASC</option>
                    <option value="DESC">DESC</option>
                </select>
                <button type="button" id="agregar_orden" class="btn btn-primary btn-sm">Agregar orden</button>
            </div>

            <div id="ordenes_agregadas">
                @php
                    $ordenGuardado = $elemento["query"]["order_by"] ?? [];
                @endphp

                @foreach($ordenGuardado as $orden)
                    <button type="button" class="btn btn-outline-dark btn-sm me-2 mb-2 orden-btn" data-columna="{{ $orden['columna'] }}">
                        {{ $orden['columna'] }} ({{ $orden['direccion'] }})
                        <span class="text-danger ms-1 eliminar-orden" style="cursor:pointer;">×</span>
                        <input type="hidden" name="order_by[]" value="{{ $orden['columna'] }}|{{ $orden['direccion'] }}">
                    </button>
                @endforeach
            </div>
        </div>
        <hr>
        {{-- Límite de resultados --}}
        <div class="mt-5">
            <p><strong>Límite de resultados</strong></p>

            <div class="form-check form-switch mb-2">
                <input class="form-check-input" type="checkbox" id="toggle_limit" name="usar_limit" value="1"
                    {{ isset($elemento["query"]['limit']) ? 'checked' : '' }}>
                <label class="form-check-label" for="toggle_limit">Aplicar límite</label>
            </div>

            <input type="number"
                min="1"
                step="1"
                name="limit"
                id="limit"
                class="form-control w-25"
                placeholder="Ej. 100"
                value="{{ $elemento["query"]['limit'] ?? '' }}"
                {{ isset($elemento["query"]['limit']) ? '' : 'disabled' }}>
        </div>






    </div>
    @endif
    {{-- Fin: Sección para seleccionar tablas --}}
</div>
