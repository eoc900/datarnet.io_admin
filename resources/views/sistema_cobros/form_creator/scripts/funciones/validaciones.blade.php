
function activarValidacionCheckbox(){
    $(document).off('change', '.validacion_activada'); // limpia evento anterior
    $(document).on('change', '.validacion_activada', function() {
        const $checkbox = $(this);
        const isChecked = $checkbox.is(':checked');

        if (!isChecked) {
            // Si desactiva, podemos limpiar la caja
            const $contenedor = $checkbox.closest('.configuracion-input');
            const index = $contenedor.index('.contenedor_campos .configuracion-input');
            $(`.contenedor-validaciones[data-index="${index}"]`).empty();
            return;
        }

        const $configuracionInput = $checkbox.closest('.configuracion-input');
        const index = $configuracionInput.index('.contenedor_campos .configuracion-input');

        // Opcional: prevenir duplicados (ya insertado)
        const $contenedorValidaciones = $(`.contenedor-validaciones[data-index="${index}"]`);
        if ($contenedorValidaciones.children().length > 0) {
            return;
        }

        console.log("validacion checkbox detectada");
        $.ajax({
            url: '{{ route('ajax.caja_validacion') }}', // <- ajusta según tu ruta real
            type: 'post',
            data: {
                _token:'{{csrf_token()}}',
                index: index
            },
            success: function(response) {
                $contenedorValidaciones.html(response);
                activarCambioTipoDato();
            },
            error: function(xhr) {
                console.error('Error al cargar la caja de validación:', xhr);
            }
        });
    });
}
{{-- Escuchar el cambio en el select de tipo de dato que se debe de validar --}}
function activarCambioTipoDato() {
    // Limpiamos evento anterior si ya se había registrado
    $(document).off('change', '.tipos_reglas');

    // Escuchamos cambios en el select del tipo de dato
    $(document).on('change', '.tipos_reglas', function () {
        console.log("tipo de dato validación cambió");
        const $select = $(this);
        const tipoDato = $select.val();

        // Detectamos el contenedor .caja-validacion más cercano
        const $caja = $select.closest('.caja-validacion');
        const index = $caja.data('index');

        if (!tipoDato || typeof index === 'undefined') {
            return;
        }

        const $contenedorReglas = $caja.find('.valores_reglas_contenedor');

        $.ajax({
            url: '{{ route('ajax.tipo_dato_regla_validacion') }}', // ajusta según tu ruta real
            type: 'post',
            data: {
                 _token:'{{csrf_token()}}',
                tipo_dato: tipoDato,
                index: index
            },
            success: function (response) {
                $contenedorReglas.html(response);
            },
            error: function (xhr) {
                console.error('Error al cargar reglas para tipo:', tipoDato, xhr);
            }
        });
    });
}
{{-- Escuchar el cambio en el select de tipo de dato que se debe de validar --}}
