  <!-- Sidebar oculto al inicio -->
  <div id="sidebar-configuracion" class="sidebar-secciones d-none">
    <div class="sidebar-secciones-header">
      <h5>Configuración de sección</h5>
      <button id="cerrarSidebar" class="btn-close" type="button"></button>
    </div>
    <div class="sidebar-secciones-body" id="contenido-configuracion">
      {{-- Aquí cargaremos la vista de configuración --}}
    </div>
  </div>
</div>


@push('funciones_sidebar')
    

console.log("hola");

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
