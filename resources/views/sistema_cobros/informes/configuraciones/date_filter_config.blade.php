<div class="col-md-6 border p-5 d-none mb-5 shadow" id="date-filter-config">

  <h5>Configurar filtro de Fecha</h5>
  <input type="hidden" name="type[]" value="date">

  <div class="mb-3">
    <label for="displayDropdown" class="form-label">Desplegar filtro como</label>
    <select class="form-select" id="displayDropdown" name="modo_visual_filtro_fecha">
      <option value="calendario">Calendario</option>
    </select>
  </div>

  {{-- 
  <div class="mb-3">
    <label class="form-label d-block">Formato de búsqueda</label>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="format" id="formatRange" value="range">
      <label class="form-check-label" for="formatRange">Rango</label>
    </div>
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="radio" name="format" id="formatSingle" value="single">
      <label class="form-check-label" for="formatSingle">Una sola fecha</label>
    </div>
  </div> --}}

  <div id="dateRangeFields">
      <label>Fecha Inicial por defecto</label>
      <input type="text" class="form-control mb-2" name="default_start" id="default_start" value="{{ $filtros['date']['default_start']??'' }}">

      <label>Fecha Final por defecto (opcional)</label>
      <input type="text" class="form-control" name="default_end" id="default_end" value="{{ $filtros['date']['default_end']??'' }}">
  </div>
</div>


@push('date_filter_config')

 <script>
    $(document).ready(function(){
        $("#default_start").flatpickr({
                altInput: true,
                enableTime: true,
                dateFormat: "Y-m-d",
                locale: "es" // Establecer el idioma español
        });

          $("#default_end").flatpickr({
                altInput: true,
                enableTime: true,
                dateFormat: "Y-m-d",
                locale: "es" // Establecer el idioma español
        });

    });
</script>
    
@endpush

