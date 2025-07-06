  {{-- Switch para activar filtro de fecha --}}
  <div class="form-check form-switch mb-3">
    <input class="form-check-input filtro-toggle" type="checkbox" id="switchFiltroFecha" data-target="#date-filter-config" name="filtro_fecha"
    value="true" {{ isset($filtros["date"])?'checked':'' }}>
    <label class="form-check-label" for="switchFiltroFecha">Filtro de Fecha</label>
  </div>

  {{-- Switch para activar filtro de texto --}}
  <div class="form-check form-switch mb-3">
    <input class="form-check-input filtro-toggle" type="checkbox" id="switchFiltroTexto" data-target="#text-filter-config" name="filtro_texto"
    value="true" {{ isset($filtros["text"])?'checked':'' }}>
    <label class="form-check-label" for="switchFiltroTexto">Filtro de Texto</label>
  </div>



@push("listado-filtros")
    <script>
    $(document).ready(function(){


        // Inicializar visibilidad de cada sección según el estado del switch
        $('.filtro-toggle').each(function () {
        const target = $(this).data('target');
        if ($(this).is(':checked')) {
            $(target).removeClass('d-none');
        } else {
            $(target).addClass('d-none');
        }
        });

        // Al cambiar el estado del switch
        $('.filtro-toggle').on('change', function () {
        const target = $(this).data('target');
        $(target).toggleClass('d-none', !$(this).is(':checked'));
        });

       


    });

</script>
@endpush
