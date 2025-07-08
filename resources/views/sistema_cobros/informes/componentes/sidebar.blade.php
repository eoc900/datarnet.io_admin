   
  <div id="sidebar-configuracion" class="sidebar-secciones d-none">
      <div class="form-check mb-3 pt-3 px-5">
        <input type="hidden" name="rawSQL" value="0">
        <input class="form-check-input" type="checkbox" id="toggleRawSQL" name="rawSQL" value="1">
        <label class="form-check-label" for="toggleRawSQL">
          Usar consulta SQL cruda
        </label>
      </div>
      <div class="sidebar-secciones-header">
          <h5>Configuración de sección</h5>
          <button id="cerrarSidebar" class="btn-close" type="button"></button>
      </div>

      <div class="sidebar-secciones-body" id="contenido-configuracion">
        {{-- Aquí cargaremos la vista de configuración --}}
      </div>

  {{-- Consultas crudas --}}
</div>


@push('funciones_sidebar')
    



function toggleSQLMode() {
    console.log("esconder constructor");

    const isChecked = $("#toggleRawSQL").is(":checked");

    if (isChecked) {
        $("#contenido-configuracion-1").hide();
        $("#raw-sql-section").show();
        $("#setRawSQL").val(1);
    } else {
        $("#contenido-configuracion").show();
        $("#raw-sql-section").hide();
        $("#setRawSQL").val(0);
    }
}


function abrirSideBar(contenido){
      // Mostrar el sidebar
  $('#sidebar-configuracion').removeClass('d-none');

  // Insertar el contenido dinámico
  $('#contenido-configuracion').html(contenido);
}


function cerrarSidebar() {
  $('#sidebar-configuracion').addClass('d-none');
  $('#contenido-configuracion').empty();
}

$('#cerrarSidebar').click(function () {
  cerrarSidebar();
  $("body").find(".seccion-seleccionada").removeClass("seccion-seleccionada");
});

@endpush
