<div class="modal fade mt-5" id="modalParametrosUrl" tabindex="-1" role="dialog" aria-labelledby="modalParametrosUrlLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-dark">
        <h5 class="modal-title text-white">Parámetros de URL</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>

      </div>

      <div class="modal-body">
        <div id="contenedor-parametros-url"></div>

        <!-- 🧩 BLOQUE PLANTILLA -->
        <div class="parametro-url-base d-none">
          <div class="card mb-3 p-3 shadow-sm parametro-url-bloque" data-index="__INDEX__" id="parametro-__INDEX__">
            <div class="row">
              <div class="col-md-4">
                <label>Nombre del parámetro</label>
                <input type="text" class="form-control" name="parametros_url[__INDEX__][nombre]" required>
              </div>
              <div class="col-md-4">
                <label>Tipo de dato</label>
                <select class="form-control" name="parametros_url[__INDEX__][tipo]">
                  <option value="string">string</option>
                  <option value="entero">entero</option>
                  <option value="fecha">fecha</option>
                  <option value="booleano">booleano</option>
                </select>
              </div>
              <div class="col-md-3">
                <label>¿Requerido?</label>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="parametros_url[__INDEX__][requerido]">
                  <label class="form-check-label">Sí</label>
                </div>
              </div>
              <div class="col-md-1 text-right pt-3">
                <button type="button" class="btn btn-outline-dark btn-sm" onclick="eliminarParametroUrl(this)">🗑</button>
              </div>
            </div>
          </div>
        </div>

        <button type="button" class="btn btn-outline-primary mt-3" onclick="agregarParametroUrl()">➕ Agregar parámetro</button>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>

@push('funciones_modal_parametros')
<script>


    let contadorParametros = 0;

    function agregarParametroUrl(param = {}) {
    const index = contadorParametros++;
    const plantilla = document.querySelector('.parametro-url-base').innerHTML.replace(/__INDEX__/g, index);

    const wrapper = document.createElement('div');
    wrapper.innerHTML = plantilla;
    const bloque = wrapper.firstElementChild;

    // Prellenar datos si vienen como argumento
    if (param.nombre) bloque.querySelector(`[name="parametros_url[${index}][nombre]"]`).value = param.nombre;
    if (param.tipo) bloque.querySelector(`[name="parametros_url[${index}][tipo]"]`).value = param.tipo;
    if (param.requerido) bloque.querySelector(`[name="parametros_url[${index}][requerido]"]`).checked = true;

    document.getElementById('contenedor-parametros-url').appendChild(bloque);
    }

    function eliminarParametroUrl(btn) {
    const card = btn.closest('.parametro-url-bloque');
    if (card) card.remove();
    }



   

</script>
@endpush
