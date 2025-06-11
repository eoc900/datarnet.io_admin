<div class="mb-4">
    <input type="hidden" name="tipo" value="grafica">

    <label for="tipo_grafica" class="form-label">Tipo de gráfica</label>
    <select name="configuracion_grafica[tipo_grafica]" class="form-select" id="tipo_grafica">
        <option value="bar" @selected(($elemento['grafica']['tipo'] ?? '') === 'bar')>Barras</option>
        <option value="line" @selected(($elemento['grafica']['tipo'] ?? '') === 'line')>Línea</option>
        <option value="pie" @selected(($elemento['grafica']['tipo'] ?? '') === 'pie')>Pastel</option>
        <option value="doughnut" @selected(($elemento['grafica']['tipo'] ?? '') === 'doughnut')>Dona</option>
    </select>
    <button type="button" class="btn btn-outline-primary mt-2" id="configurar_grafica">Seleccionar parámetros</button>
</div>

<div class="mb-3">
    <label for="label_columna" class="form-label">Columna para etiquetas (labels)</label>
    <select name="configuracion_grafica[label]" class="form-select" id="label_columna">
        @foreach ($elemento['query']['columnas_seleccionadas'] ?? [] as $col)
            <option value="{{ $col }}" @selected(($elemento['grafica']['label_columna'] ?? '') === $col)>{{ $col }}</option>
        @endforeach
        @foreach ($elemento['query']['agregados'] ?? [] as $ag)
            <option value="{{ $ag['alias'] }}" @selected(($elemento['grafica']['label_columna'] ?? '') === $ag['alias'])>{{ $ag['alias'] }}</option>
        @endforeach
    </select>
</div>

<div class="mb-3">
    <label for="valor_columna" class="form-label">Columna para valores</label>
    <select name="configuracion_grafica[valor]" class="form-select" id="valor_columna">
        @foreach ($elemento['query']['agregados'] ?? [] as $ag)
            <option value="{{ $ag['alias'] }}" @selected(($elemento['grafica']['valor_columna'] ?? '') === $ag['alias'])>{{ $ag['alias'] }}</option>
        @endforeach
    </select>
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
    <label for="color_grafica" class="form-label">Color personalizado</label>
    <input type="color" name="color_grafica" id="color_grafica" class="form-control form-control-color"
           value="{{ $elemento['grafica']['color_personalizado'] ?? '#36A2EB' }}">
</div>
