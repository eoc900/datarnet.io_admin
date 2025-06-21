{{-- EVENTO ELIMINAR --}}
function activarEventoEliminarSeccion() {
    console.log("Evento eliminar sección detectado");
    $(document).off('click', '.eliminar-seccion');

    $(document).on('click', '.eliminar-seccion', function () {
        const $boton = $(this);
        const id = $boton.data('id');

        if (!id) return;

        if (!confirm('¿Estás seguro de eliminar esta sección?')) return;

        $.ajax({
            url: '{{ route('ajax.eliminar_seccion_informe') }}', // Ajusta esta ruta
            method: 'POST',
            data: {
                id: id,
                _token: '{{csrf_token()}}'
            },
            success: function (response) {
                // Elimina visualmente el contenedor
                $boton.closest('.seccion').remove();
            },
            error: function (xhr) {
                console.error('Error al eliminar sección', xhr);
                alert('No se pudo eliminar la sección. Intenta más tarde.');
            }
        });
    });
}
{{-- EVENTO ELIMINAR --}}
