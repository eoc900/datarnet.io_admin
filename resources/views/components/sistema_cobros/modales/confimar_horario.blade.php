{{-- Modal aceptar horario --}}
<div class="modal fade" id="horario_modal" tabindex="1000" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Asignar siguiente fecha</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Haz seleccionado el siguiente rango:
        <p class="mt-3"><b>Inicio: </b><span class="inicio" data-inicio=""></span></p>
        <p><b>Fin: </b><span class="fin" data-fin=""></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="aceptar_horario">Aceptar</button>
      </div>
    </div>
  </div>
</div>

