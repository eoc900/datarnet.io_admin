{{-- Modal eliminar horario --}}
<div class="modal fade" id="eliminar_horario" tabindex="1000" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center" id="exampleModalLabel">¿Quieres eliminar este horario?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <input type="hidden" id="eliminar_hora" value="">
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="aceptar_eliminar_horario">Aceptar</button>
      </div>
    </div>
  </div>
</div>