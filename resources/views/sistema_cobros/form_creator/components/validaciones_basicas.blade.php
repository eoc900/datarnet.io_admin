<div class="col-md-6">
    <label for="regla_obligatoriedad" class="form-label text-primary">¿Campo requerido?</label>
    <select name="reglas[{{ $index }}][obligatoriedad]" class="form-select">
        <option value="">Sin validación</option>
        <option value="required">Obligatorio (required)</option>
        <option value="nullable">Opcional (nullable)</option>
    </select>
</div>

<div class="col-md-6">
    <label for="regla_tipo" class="form-label text-primary">Tipo de dato esperado</label>
    <select name="reglas[{{ $index }}][tipo_dato]" class="form-select tipos_reglas">
        <option value="">Sin validación de tipo</option>
        <option value="string">Texto (string)</option>
        <option value="numeric">Número (numeric)</option>
        <option value="integer">Número entero (integer)</option>
        <option value="boolean">Booleano (boolean)</option>
        <option value="array">Arreglo (array)</option>
        <option value="date">Fecha (date)</option>
        <option value="email">Correo (email)</option>
        <option value="uuid">UUID</option>
        <option value="url">URL</option>
        <option value="ip">IP</option>
        <option value="json">JSON</option>
        <option value="image">Imagen</option>
        <option value="file">Archivo</option>
    </select>
</div>
