<div class="col-md-4 py-3 ps-5 ">
        {{-- Seleccionar alguna tabla de la base de datos --}}
        <label for="" class="text-primary"><i class="lni lni-skipping-rope"></i> Enlazar formulario a una tabla</label>
        <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="enlazarTabla" name="enlazar_tabla" value="true">
                <label class="form-check-label" for="enlazarTabla">Enlazar formulario</label>
        </div>
        {{-- Seleccionar alguna tabla de la base de datos --}}
        {{-- Es público o privado --}}
        <label for="" class="text-primary mt-3"><i class="lni lni-lock-alt"></i> Formulario público</label>
        <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="publico" name="formulario_publico" value="true">
                <label class="form-check-label" for="publico">Publico</label>
        </div>
        {{-- Es público o privado --}}               
</div>
<div class="col-md-4">
        {{-- Habilitar identidad de formulario --}}    
        <label for="" class="text-primary mt-3"><i class="lni lni-key"></i> Habilitar opciones avanzadas</label>
        <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="conf_avanzada" name="conf_avanzada" value="true">
                <label class="form-check-label" for="conf_avanzada">Configuración avanzada</label>
        </div>
        {{-- Habilitar identidad de formulario --}}
        {{-- Habilitar múltiples registros--}}    
        <label for="" class="text-primary mt-3"><i class="lni lni-list"></i> Permitir múltiples registros</label>
        <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="multiples_registros" name="multiples_registros" value="true">
                <label class="form-check-label" for="multiples_registros">Múltiples registros</label>
        </div>
        {{-- Habilitar múltiples registros --}}
</div>

<div class="col-md-4">
        {{-- Permisos usuarios --}}
        @include('components.informes.usuarios_checkbox')
        {{-- Permisos usuarios--}}
</div>
<div class="col-sm-12 py-3 contenedor_enlazar_tabla d-none">
        <div class="tabla_enlazada">
                {{-- Aquí se muestran las opciones de tablas disponibles en caso de enlazar el formulario --}}
                <div class="col-12">
                        <select class="mt-5 mb-5 form-control" data-tags="true" data-placeholder="Buscar tablas" data-allow-clear="true" id="buscar_tablas" name="id_tabla_db">
                        </select>
                </div>
                {{-- Aquí se muestran las opciones de tablas disponibles en caso de enlazar el formulario --}}
        </div>
</div>

{{-- Selección de banner superior para formulario público --}}
<div id="seccion-banner" class="col-12 mt-4 d-none">
        <label class="text-primary"><i class="lni lni-image"></i> Imagen de banner para formulario público</label>

        <div id="drop-zone" class="border border-dashed rounded p-4 text-center bg-light"
                style="cursor: pointer;">
                <p class="text-muted mb-2">Arrastra una imagen aquí o haz clic para seleccionarla</p>
                <input type="file" id="banner_input" name="banner_formulario" accept="image/*" class="d-none" />
                <img id="preview-banner" src="" class="img-fluid mt-3 d-none border rounded" style="max-height: 200px;" />
        </div>
</div>
{{-- Selección de banner superior para formulario público --}}

{{-- Título del formulario --}}
<div class="col-sm-6 py-3">
        <label for="titulo_formulario">Titulo formulario</label>
        <input type="text" name="nombre_formulario" id="nombre_formulario" class="form-control" maxlength="50" required>
        <small id="alerta_longitud" class="text-danger d-none">Has excedido el límite de caracteres (50).</small>
</div>
{{-- Título del formulario --}}

{{-- Slug --}}
 <div class="col-sm-6 py-3">
        <label for="nombre_documento" class="d-flex align-items-center">
                Slug 
                <i class="lni lni-question-circle ms-2 text-primary" 
                style="cursor: pointer;" 
                data-bs-toggle="modal" 
                data-bs-target="#modalExplicacionSlug"
                title="¿Qué es esto?">
                </i>
        </label>
        <input type="text" name="nombre_documento" id="nombre_documento" class="form-control" maxlength="50" required>
</div>
{{-- Slug --}}

{{-- Inputs Configuración avanzada --}}
<div id="campos-avanzados" class="row d-none col-12 border-top border-bottom py-3">
        <p><b><i class="lni lni-cog"></i> Configuración avanzada</b></p>
        <div class="row">
        <div class="col-sm-6">
                <label for="action">Action route</label>
                <input type="text" name="action" id="action" class="form-control" value="ruta_automatica" required>
        </div>
        <div class="col-sm-6">
                <label for="identificador_proceso">Identificador</label>
                <input type="text" name="identificador_action" id="identificador_proceso" class="form-control" placeholder="notificacion-programada">
        </div>       
        </div>
</div>
{{-- Inputs Configuración avanzada --}}

{{-- Descripción --}}
 <div class="col-sm-12 py-3">
        <label for="nombre_documento">Descripción</label>
        <textarea name="descripcion" id="descripcion" cols="30" rows="3" class="form-control"></textarea>
</div>
{{-- Descripción --}}
        

@push('form_creator_top_section')
    function eventoEnlazarTabla(){
        $('#enlazarTabla').change(function() {
            if ($(this).is(':checked')) {
                $(".contenedor_enlazar_tabla").removeClass('d-none'); // Remover clase si está desmarcado        
            } else {
                $(".contenedor_enlazar_tabla").addClass('d-none'); // Agregar clase si está marcado
            }
        });
    }
    function select2TablaModulo(){
         $('#buscar_tablas').select2({
                placeholder: 'Selecciona una tabla',    
                 width: '100%',       
                ajax:{
                    type: "post",
                    dataType: "json",
                    url: "/select2/tablas_modulos",
                    data: function (params) {
                        var query = {
                            search: params.term,
                            _token: '{{csrf_token()}}',
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        console.log(data);
                            return {
                                    results: $.map(data.results, function (item) {
                                        return {
                                            text: "Tabla: "+item.text,
                                            id: item.id                                          
                                        }
                                    })
                            }
                    }
                }
        });
        $('#buscar_tablas').on('select2:select', function (e) {       
          console.log(e.params.data.id);
          // Cuando seleccionas una tabla se tiene que esconder la sección de configuración
          ajaxRenderizarCampos(e.params.data.id);
        });
      }
@endpush
