@if (isset($elemento))

    {{-- Nuestro formulario para actualizar configuraciones de secciones --}}
    <form action="{{ route("actualizar.seccion") }}" method="POST" id="actualizar_seccion">
        @csrf
        <input type="hidden" name="id" value="{{ $elemento['id'] }}">
        
        {{-- query builder --}}
        <div id="contenido-configuracion-1">
        {{-- Identificar Si Es Vista Edición Y No Create--}}
            @if(isset($edicion) && $edicion==true)
                <input type="hidden" name="editar_informe" value="true">
                <input type="hidden" name="id_informe" value="{{ $id_informe??'' }}">
            @else
                <input type="hidden" name="editar_informe" value="false">
            @endif
            
        
            @switch($elemento["tipo"])
                @case("tabla")
                    {{-- Incluir la vista para sidebar para cuando el elemento es una tabla --}}
                    <h5>Configuración de tabla</h5>
                    @include('sistema_cobros.informes.componentes.sidebar.query',[
                        "elemento"=>$elemento,
                        "tablas"=>$tablas,
                        "columnasPorTabla"=>$columnasPorTabla,
                        "columnas"=>$columnasPorTabla
                    ])
                    @break
                @case("tarjeta")
                {{-- Incluir la vista para sidebar para cuando el elemento es una tarjeta --}}
                    <h5>Visualizar configuración de tarjeta</h5>           
                    @include('sistema_cobros.informes.componentes.sidebar.tarjeta',["elemento"=>$elemento])
                    @include('sistema_cobros.informes.componentes.sidebar.query',[
                        "elemento"=>$elemento,
                        "tablas"=>$tablas,
                        "columnasPorTabla"=>$columnasPorTabla,
                        "columnas"=>$columnasPorTabla])
                    @break
                @case("texto_sm")
                {{-- Incluir la vista para sidebar para cuando el elemento es una texto --}}
                    <h5>Visualizar configuración de texto</h5>
                    @break
                @case("texto_md")
                {{-- Incluir la vista para sidebar para cuando el elemento es una texto--}}
                    <h5>Visualizar configuración de texto</h5>
                    @break
                @case("texto_lg")
                {{-- Incluir la vista para sidebar para cuando el elemento es una texto --}}
                    <h5>Visualizar configuración de texto</h5>
                    @break
                @case("grafica")
                    <h5>Visualizar configuración de gráfica</h5>
                    @include('sistema_cobros.informes.componentes.sidebar.query', [
                        "elemento" => $elemento,
                        "tablas" => $tablas,
                        "columnasPorTabla" => $columnasPorTabla,
                        "columnas" => $columnasPorTabla
                    ])
                    <hr>
                    @include('sistema_cobros.informes.componentes.sidebar.grafica', [
                        "elemento" => $elemento
                    ])
                    @break

                @default
                    <div class="alert alert-warning">El elemento solicitado no fue reconocido.</div>
                    
            @endswitch
        </div>
        {{-- query builder --}}

         <div id="raw-sql-section" style="display: none;" class="m-4">
      <!-- Sidebar oculto al inicio -->
     
          <input type="hidden" name="rawSQL" value="0" id="setRawSQL">
          {{-- Consultas crudas --}}
          
            <label for="sql_raw">Consulta SQL</label>
            <textarea class="form-control" name="sql_raw" id="sql_raw" rows="6" placeholder="Escribe aquí tu consulta SQL...">{{ $elemento['query']['raw_sql'] ?? '' }}</textarea>

            <div class="mb-4">
                  <input type="hidden" name="tipo" value="grafica">
                  <label for="tipo_grafica" class="form-label">Tipo de gráfica</label>
                  <select name="configuracion_grafica[tipo_grafica]" class="form-select" id="tipo_grafica">
                      <option value="bar" @selected(($elemento['grafica']['tipo'] ?? '') === 'bar')>Barras</option>
                      <option value="line" @selected(($elemento['grafica']['tipo'] ?? '') === 'line')>Línea</option>
                      <option value="pie" @selected(($elemento['grafica']['tipo'] ?? '') === 'pie')>Pastel</option>
                      <option value="donut" @selected(($elemento['grafica']['tipo'] ?? '') === 'donut')>Dona</option>
                  </select>
              </div>

              <div class="mb-3">
                  <label class="form-label">Columna para etiquetas (labels)</label>
                  <input type="text" name="configuracion_grafica[label_columna]" class="form-control"
                        value="{{ $elemento['grafica']['label_columna'] ?? '' }}"
                        placeholder="Ej. nombre_vehiculo, fecha, etc.">
              </div>
              <div class="mb-3">
                    <label class="form-label">Columna para series dinámicas (agrupación interna)</label>
                    <input type="text" name="configuracion_grafica[columna_series_dinamicas]" class="form-control"
                        value="{{ $elemento['grafica']['columna_series_dinamicas'] ?? '' }}"
                        placeholder="Ej. estatus_venta, categoria, etc.">
                </div>


              <div class="mb-3">
                  <label class="form-label">Series (columnas para valores)</label>
                  <div id="series-container">
                      @php
                        $series = $elemento['grafica']['series'] ?? [''];
                      @endphp
                      @foreach ($series as $index => $serie)
                          <div class="input-group mb-2">
                              <input type="text" name="configuracion_grafica[series][]" class="form-control"
                                    value="{{ $serie }}" placeholder="Ej. costo_total_unitario">
                              <button class="btn btn-danger btn-sm remove-serie" type="button">🗑</button>
                          </div>
                      @endforeach
                  </div>
                  <button type="button" class="btn btn-outline-success btn-sm mt-1" id="add-serie">➕ Agregar serie</button>
              </div>

              <div class="mb-3">
                  <label for="titulo_grafica" class="form-label">Título de la gráfica</label>
                  <input type="text" name="configuracion_grafica[titulo]" class="form-control"
                        value="{{ $elemento['grafica']['titulo'] ?? '' }}">
              </div>

              <div class="form-check mb-2">
                  <input type="checkbox" name="stacked" id="stacked" class="form-check-input"
                        @checked(!empty($elemento['grafica']['stacked']))>
                  <label for="stacked" class="form-check-label">Apilar barras (stacked)</label>
              </div>

              <div class="form-check mb-2">
                  <input type="checkbox" name="mostrar_leyenda" id="mostrar_leyenda" class="form-check-input"
                        @checked(!empty($elemento['grafica']['mostrar_leyenda']))>
                  <label for="mostrar_leyenda" class="form-check-label">Mostrar leyenda</label>
              </div>

              <div class="mb-3">
                  <label for="color_grafica" class="form-label">Color personalizado base</label>
                  <input type="color" name="color_grafica" id="color_grafica" class="form-control form-control-color"
                        value="{{ $elemento['grafica']['color_personalizado'] ?? '#36A2EB' }}">
              </div>
             
          </div>
      </div>


        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@else

    <div class="alert alert-warning">No encontramos el id {{ $id }}</div>
   


@endif