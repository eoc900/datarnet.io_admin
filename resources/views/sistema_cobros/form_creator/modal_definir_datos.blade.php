<!-- Botón para abrir el modal -->
@push("boton")
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#miModalFormulario">
        Abrir formulario
    </button>
@endpush

<!-- Modal -->
<div class="modal fade" id="miModalFormulario" tabindex="-1" aria-labelledby="tituloModal" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
    
      <div class="modal-header">
        <h5 class="modal-title text-center" id="tituloModal">Nueva tabla en la base de datos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      
      {{-- formulario --}}
      <form id="crear_tabla_con_formulario">
        <input type="hidden" value="" class="nombre_archivo" name="nombre_archivo">
        <div class="modal-body">
            <div class="contenido_preloader">
            </div>

            {{-- Distribución del input-group --}}
            <div class="contenido_config_cols">
                <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Columna</th>
                        <th class="text-center">Tipo Dato</th>
                        <th class="text-center"># Caracteres</th>
                        <th class="text-center">Llave primaria</th>
                        <th class="text-center">Unique</th>
                        <th class="text-center">Null</th>
                        <th class="text-center">Foranea</th>
                        <th class="text-center">Tabla foranea</th>
                        <th class="text-center">Columna foranea</th>
                    </tr>
                </thead>
                <tbody class="campos_agregados">
                   {{-- insertamos campos de configuración de columnas--}}
                </tbody>
                </table>
               
            </div>
              
            {{-- input-group --}}

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary generar-tabla-db">Aceptar configuración</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

@push('agregar_campo_columna')
    
@endpush


