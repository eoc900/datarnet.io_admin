<!-- Modal reutilizable -->
<div class="modal fade" id="modal-subcampo" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar campo al grupo multi-item</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body ps-4">

        <input type="hidden" id="indexPadreMultiItem">
        <div class="row ps-3" id="contenido-subcampo">
          {{-- Aquí se cargará el contenido de configuración como si fuera otro input --}}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardar-subcampo">Guardar campo</button>
      </div>
    </div>
  </div>
</div>
