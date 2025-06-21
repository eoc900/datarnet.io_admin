{{-- Modal: Configuración Avanzada --}}
@if (isset($arreglo) && in_array("conf_avanzada", $arreglo))
    <div class="modal fade mt-5" id="modalExplicacionAvanzada" tabindex="-1" aria-labelledby="tituloModalExplicacion" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border border-warning">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title" id="tituloModalExplicacion"><i class="lni lni-information"></i> Atención</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-dark">
                    Esta opción debe activarse cuando se requiere hacer una <b>personalización más profunda con los datos del formulario</b> creado.<br><br>
                    Un técnico podrá ejecutar un script especial como:
                    <ul>
                        <li>Mandar datos por correo electrónico</li>
                        <li>Configurar envío de SMS</li>
                        <li>Realizar integraciones con otros sistemas</li>
                    </ul>
                    Solo activa esta opción si entiendes sus implicaciones o cuentas con apoyo técnico.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
@endif

{{-- Modal: Slug --}}
@if (isset($arreglo) && in_array("slug", $arreglo))
    <div class="modal fade mt-5" id="modalExplicacionSlug" tabindex="-1" aria-labelledby="tituloModalSlug" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border border-info">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white" id="tituloModalSlug"><i class="lni lni-information"></i> ¿Qué es un "Slug"?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-dark">
                    <p>
                        El <strong>slug</strong> es una versión simplificada del nombre del documento, usado normalmente en URLs o identificadores únicos.
                        Debe ser breve, sin espacios ni caracteres especiales. Usualmente se escribe en minúsculas y separado por guiones.
                    </p>
                    <p><strong>Ejemplo:</strong></p>
                    <div class="text-center">
                        <img src="{{ asset('/dashboard_resources/assets/imagenes/ejemplo-slug.jpg') }}" alt="Ejemplo de slug" class="img-fluid border rounded shadow-sm">
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    @if (isset($arreglo) && in_array("conf_avanzada", $arreglo))
        const checkboxAvanzado = document.getElementById('conf_avanzada') || document.getElementById('publico');
        let yaMostro = false;
        if (checkboxAvanzado) {
            checkboxAvanzado.addEventListener('change', function () {
                if (checkboxAvanzado.checked && !yaMostro) {
                    new bootstrap.Modal(document.getElementById('modalExplicacionAvanzada')).show();
                    yaMostro = true;
                }
            });
        }
    @endif
});
</script>
