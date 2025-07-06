<div class="col-sm-{{ $valor_col }} seccion" data-seccion="{{ $id }}">
    <div class="card rounded shadow border p-3 h-auto">
              {{-- Botón eliminar sección --}}
        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 eliminar-seccion"
                data-id="{{ $id }}" title="Eliminar sección">
            <i class="bi bi-trash"></i>
        </button>

        {{-- Zona clickeable con overlay --}}
        <div class="seccion-body position-relative">
            
            {{-- Overlay que se muestra al hacer hover --}}
            <div class="seccion-overlay" data-seccion="{{ $id }}">
                <i class="bi bi-gear-fill text-white fs-2 position-absolute top-50 start-50 translate-middle"></i>
            </div>
            {{-- Contenido de configuracion --}}
            <h5>Configurar gráfica</h5>
            <hr>
        </div>
    </div>
</div>