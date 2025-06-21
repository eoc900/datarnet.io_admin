
    {{-- NOTA[input-segment]: input segment es importante porque agrupa la configuracion del input de formulario y el tipo de input --}}
    <div class="input-group input_types mt-2">
        @php
            $elementos = [
            ["value"=>"tabla","option"=>"Tabla con registros"],
            ["value"=>"tarjeta","option"=>"Tarjeta con título y un valor"],
            ["value"=>"texto_sm","option"=>"Texto corto"],
            ["value"=>"texto_md","option"=>"Texto mediano"],
            ["value"=>"texto_lg","option"=>"Texto largo"],
            ["value"=>"grafica","option"=>"Área para gráfica"],
            ["value"=>"espacio","option"=>"Columna en blanco"]
        ];
        @endphp
        @php
            $dimensiones = [["value"=>"3","option"=>"1/4 de pantalla"],
            ["value"=>"4","option"=>"1/3 de pantalla"],
            ["value"=>"6","option"=>"1/2 de pantalla"],
            ["value"=>"9","option"=>"3/4 de pantalla"],
            ["value"=>"12","option"=>"Pantalla completa"]];
        @endphp


        <select name="elemento" id="elemento" class="form-control">
            @foreach ($elementos as $elemento)
                <option value="{{ $elemento["value"] }}">{{ $elemento["option"] }}</option>
            @endforeach
        </select>
        <select name="amplitud" id="amplitud" class="form-control">
        @foreach ($dimensiones as $dimension)
            <option value="{{ $dimension["value"] }}">{{ $dimension["option"] }}</option>
        @endforeach
        </select>
        <button type="button" class="btn btn-success agregar-elemento font-20"><i class="lni lni-plus"></i></button>
    </div>

    <script>
    @push('insertar_espacio_configuracion')
        @include('sistema_cobros.informes.scripts.eventos_elementos')
        agregarElemento();
        eventoClickSeccion();
        activarEventoEliminarSeccion();


        function insertarElemento(){
            let amplitud = $("#amplitud").val();
            let elemento = $("#elemento").val();
            let index = $("#contenido-para-pdf").children().length;
            console.log("el índice del nuevo elemento es: "+index);
            console.log($("#contenido-para-pdf").children());
             $.ajax({
                    url: '{{ route("ajax.render_elementos") }}',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',col:amplitud,tipo_elemento:elemento,index:index},
                    success:function(response){
                        $("#contenido-para-pdf").append(response);
                        {{-- Abrimos aquí el sidebar y pasamos lo que queremos ver de configuracion --}}
                        // Obtenemos el id
                        var id = $("#contenido-para-pdf").find(".seccion").last().attr('data-seccion');
                        console.log("se agregó el elemento siguiente: "+id);
                        abrirSideBar("Hola sidebar");
                        ajaxConfigElementData(id);
                        activarEventoEliminarSeccion();
             
                        
                    }
            });
        }

        // Llamamos la configuración de un elemento de archivo json
        function ajaxConfigElementData(element_id=""){
            $.ajax({
                    url: '{{ route("ajax.config_element_data") }}',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',
                    element:element_id,
                    id_informe:"{{ (isset($id_informe))?$id_informe:'' }}",
                    edicion:"{{ (isset($edicion) && $edicion!='false')?true:false }}" },
                    success:function(response){
                       $("#contenido-configuracion").html(response);
                       //Habilitar selección de tablas
                        eventoSeleccionarTablas();
                        eventoEliminarTabla();
                        arrastrarColumna();
                        activarDropJoins();
                        eventoEliminarColumnaJoin();
                        eventosClickCondiciones();
                        activarEventoAgregarCondicionInterna();
                        onActualizarSubmit();
                        activarAgregarFuncion();
                        actualizarOpcionesAgrupacion();
                        activarAgregarAgrupacion();
                        activarEliminarAgrupacion();
                        actualizarOpcionesOrden();
                        activarAgregarOrden();
                        activarEliminarOrden();
                        activarToggleLimit(); 
                        activarBotonEnlazarFiltro();
                        activarEventosGrafica();
                        // Cada que se guarde una sección guardamos los filtros
                        guardarSeccionFormulario();

                        
                    }
            });
        }

        
        function ajaxColumnasTabla(tabla, append_on,index=""){

            $.ajax({
            url: '/ajax/columnas_tabla', // Ajusta esta URL
                        method: 'POST',
                        data: {
                            _token:'{{csrf_token()}}', // CSRF para Laravel
                            tabla: tabla,
                            drag_drop:true,
                            index: index
                        },
                        success: function(response) {
                            console.log('encontramos las siguientes columnas:', response);
                            // Necesitamos
                            $(append_on).append(response);
                            arrastrarColumna();
                        }
            });
        }

        function agregarElemento(){
            $(".agregar-elemento").off();
            $(".agregar-elemento").click(function(){
                console.log("Estás a punto de agregar un elemento de configuración");
                insertarElemento();
                eventoClickSeccion();
                activarDroppableSeleccionar();
            });
        }

        // Función para mostrar la configuración al dar click en una seccion
       function eventoClickSeccion() {
            $(document).off('click', '.seccion-body');

            $(document).on('click', '.seccion-body', function () {
                const $seccion = $(this).closest('.seccion');
                const data_seccion = $seccion.data('seccion');

                $('.seccion').removeClass('seccion-seleccionada');
                $seccion.addClass('seccion-seleccionada');

                abrirSideBar("Configurando sección");
                ajaxConfigElementData(data_seccion);
                arrastrarColumna();
            });
        }




        // Función para actualizar el input oculto
        function actualizarInputTablas() {
            let tablas = [];
            $("#tablas_agregadas_query .tabla-btn").each(function() {
                tablas.push($(this).data("tabla"));
            });
            $("#tablas_seleccionadas_query").val(tablas.join(","));
        }

        // Evento al hacer clic en "+"
        function eventoSeleccionarTablas(){
            console.log("evento reconocido");
            $("#agregar_tabla_query").off();
            $("#agregar_tabla_query").click(function(){
            let tablaSeleccionada = $("#opciones_tabla_query").val();

            // Evitar agregar duplicados
            if ($("#tablas_agregadas_query .tabla-btn[data-tabla='" + tablaSeleccionada + "']").length > 0) {
                alert("Esta tabla ya ha sido agregada.");
                return;
            }

            // Crear el botón con opción de eliminar
            let btn = `
                <button type="button" class="btn btn-outline-primary btn-sm me-2 mb-2 tabla-btn" data-tabla="${tablaSeleccionada}">
                    ${tablaSeleccionada}
                    <span class="text-danger ms-1 eliminar-tabla" style="cursor:pointer;">&times;</span>
                </button>
            `;

            $("#tablas_agregadas_query").append(btn);
            actualizarInputTablas();
            // Generar un contenedor con un ID único para las columnas
            let safeId = tablaSeleccionada.replace(/\./g, "_"); // por si hay nombres con puntos
            let contenedor = `
                <div class="columnas-de-tabla mt-2" id="columnas_tabla_${safeId}" data-tabla="${tablaSeleccionada}">
                    <label class="form-label"><strong>Columnas de ${tablaSeleccionada}</strong></label>
                </div>
            `;
            $("#columnas_agregadas").append(contenedor);

            // Llamar AJAX para insertar el dropdown dentro de ese contenedor
            ajaxColumnasTabla(tablaSeleccionada, `#columnas_tabla_${safeId}`);
            verificarMostrarZonaJoins();
            });
        }
        

        // Delegado para eliminar una tabla
       function eventoEliminarTabla() {
            $(document).off("click", ".eliminar-tabla");
            $(document).on("click", ".eliminar-tabla", function () {
                let $botonTabla = $(this).closest(".tabla-btn");
                let nombreTabla = $botonTabla.data("tabla");

                // Eliminar botón visual
                $botonTabla.remove();

                // Eliminar el contenedor de columnas asociado
                let safeId = nombreTabla.replace(/\./g, "_");
                $(`#columnas_tabla_${safeId}`).remove();
                
                actualizarInputTablas();
                eventoEliminarColumnasDeTabla(nombreTabla);       
                verificarMostrarZonaJoins(); 
            });
        }

        function eventoEliminarColumnasDeTabla(tabla) {
            $("#columnas_seleccionadas .arrastrar_columna").each(function() {
                const valor = $(this).find("input").val(); // valor tipo: tabla.columna
                if (valor.startsWith(tabla + ".")) {
                    $(this).remove();
                    // Actualizar el dropdown de agrupación
                    actualizarOpcionesAgrupacion();
                    actualizarOpcionesOrden();
                }
            });
        }


        
        function arrastrarColumna() {
            console.log("evento arrastrable");
            console.log($("body").find(".arrastrar_columna"));
            // $("body").find(".arrastrar_columna").off();
            //$("body").find(".arrastrar_columna").draggable("destroy");
            $("body").find(".arrastrar_columna").draggable({
            handle: ".handle",
            appendTo: "body",  
            cursorAt: { top: 50, right: 0 },           
            helper: function(event) {
                
                var original = $(this);
                var clone = original.clone();

                // Copiar valores seleccionados de <select>
                original.find("select").each(function(index) {
                var value = $(this).val();
                clone.find("select").eq(index).val(value);
                });

                // Copiar valores de inputs
                original.find("input").each(function(index) {
                var value = $(this).val();
                clone.find("input").eq(index).val(value);
                });

                // Copiar estado de checkboxes
                original.find("input[type=checkbox]").each(function(index) {
                var checked = $(this).prop("checked");
                clone.find("input[type=checkbox]").eq(index).prop("checked", checked);
                });

                // Ajustar estilo
                clone.css({
                    width: original.outerWidth()-20,
                    height: original.outerHeight(),          
                    zIndex: 9999
                });
                return clone;
            },
            drag: function (event, ui) {
              

                    const sidebar = $('#sidebar-configuracion')[0];
                    const sidebarOffset = $('#sidebar-configuracion').offset();
                    const sidebarHeight = $('#sidebar-configuracion').outerHeight();
                    const cursorY = event.pageY;

                    const topEdge = sidebarOffset.top;
                    const bottomEdge = topEdge + sidebarHeight;

                    const distanceToTop = cursorY - topEdge;
                    const distanceToBottom = bottomEdge - cursorY;

                    const SCROLL_SPEED = 5;
                    const SCROLL_ZONE = 150;

                    // Scroll hacia arriba
                    if (distanceToTop >= 0 && distanceToTop < SCROLL_ZONE) {
                        sidebar.scrollTop -= SCROLL_SPEED;
                    }
                    // Scroll hacia abajo
                    else if (distanceToBottom >= 0 && distanceToBottom < SCROLL_ZONE) {
                        sidebar.scrollTop += SCROLL_SPEED;
                    }

                    // Limitar la frecuencia del scroll (cada 50ms)
                   
            },
            revert: "invalid"
        });

        activarDroppableSeleccionar();
      }

       
        function activarDroppableSeleccionar(){
            console.log("hey");
            console.log($("body").find( "#columnas_seleccionadas"));
            $("body").find( "#columnas_seleccionadas").off();
            $("body").find( "#columnas_seleccionadas").droppable({
              accept:'.arrastrar_columna',
              addClasses: false,
              tolerance: "pointer", 
              drop: function( event, ui ) {
                  console.log(ui);
                  console.log("se hizo el drop");
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });
                    const value = ui.draggable.find("select").val();

                    // 🚫 Validación de duplicados
                    const existe = $(this).find('input[value="' + value + '"]').length > 0;
                    if (existe) {
                        alert("Esta columna ya ha sido seleccionada.");
                        return;
                    }

                    droppedItem.addClass("mt-3");
                    droppedItem.find(".handle").html('x');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("remove-seleccionada").addClass("btn-danger");
                    droppedItem.find("select").remove();
                    droppedItem.find("label").remove();
                    droppedItem.find(".input-group").append('<input type="text" name="seleccionar[]" class="respuesta form-control" value="'+value+'" readonly>');
                    
                    $(this).append(droppedItem); // Lo agregamos al área droppable
                    actualizarOpcionesAgrupacion();

                    
              }
            });
            eventoEliminarColumnaSeleccionada();
        }

        function eventoEliminarColumnaSeleccionada() {
            $("body").off("click", ".remove-seleccionada");
            $("body").on("click", ".remove-seleccionada", function () {
                // Eliminar el bloque completo (el clon)
                $(this).closest(".arrastrar_columna").remove();
            });
        }

        {{-- JOINS --}}
        function verificarMostrarZonaJoins() {
            const tablas = $("#tablas_seleccionadas_query").val().split(",").filter(t => t.trim() !== "");

            if (tablas.length > 1) {
                $("#dropdown_tabla_principal").removeClass("d-none");
                $("#joins_configuracion").removeClass("d-none");
                 generarBloquesJoinAjax(tablas);
            } else {
                $("#dropdown_tabla_principal").addClass("d-none");
                $("#joins_configuracion").addClass("d-none");
                $("#zona_joins").empty();
            }
        }
        function generarBloquesJoinAjax(tablas) {
            $.ajax({
                url: '{{ route("ajax.zona_join") }}',
                method: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    tablas: tablas,
                    tabla_principal: $("#tabla_principal").val()
                },
                success: function (response) {
                    $("#zona_joins").html(response);
                    activarDropJoins(); // vuelve a activar droppables
                    activarEventosJoinDropdowns(); // 🔥 IMPORTANTE
                },
                error: function () {
                    alert("Error al generar los bloques de join.");
                }
            });
        }
        function activarDropJoins() {
            console.log("drop joins activado");
            $("body").find(".drop-columna-a, .drop-columna-b").droppable({
                accept: ".arrastrar_columna",
                addClasses: false,
                drop: function (event, ui) {
                    console.log("🟢 Drop detectado");

                    const valor = ui.draggable.find("select").val() || ui.draggable.find("input").val();
                    const index = $(this).data("index");
                    const tipo = $(this).hasClass("drop-columna-a") ? "columna_a" : "columna_b";

                    // Contenedor con input + botón de eliminar
                    const inputGroup = $(`
                        <div class="d-flex align-items-center gap-2">
                            <input type="text" class="form-control mb-1" name="joins[${index}][${tipo}]" value="${valor}" readonly>
                            <button type="button" class="btn btn-sm btn-danger eliminar-columna" title="Eliminar">×</button>
                        </div>
                    `);

                    $(this).empty().append(inputGroup);
                }
            });

            eventoEliminarColumnaJoin(); // Activa eliminación
        }

        function actualizarColumnasJoin(tabla, tipoColumna, index) {
            $.ajax({
                url: '{{ url("/ajax/columnas_tabla") }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    tabla: tabla,
                    drag_drop: true,
                    index: index
                },
                success: function (response) {
                    // tipoColumna debe ser 'a' o 'b'
                    const contenedor = tipoColumna === 'a'
                        ? $('.drop-columna-a[data-index="' + index + '"]')
                        : $('.drop-columna-b[data-index="' + index + '"]');

                    contenedor.html(response);
                    activarDragColumnas(); // vuelve a activar .draggable en los nuevos selects
                },
                error: function () {
                    alert("Error al cargar columnas de la tabla " + tabla);
                }
            });
        }

        function activarEventosJoinDropdowns() {
            $("body").off("change", ".tabla_a_selector");
            $("body").on("change", ".tabla_a_selector", function () {
                const index = $(this).data("index");
                const tabla = $(this).val();
               // actualizarColumnasJoin(tabla, 'a', index);
            });

            $("body").off("change", ".tabla_b_selector");
            $("body").on("change", ".tabla_b_selector", function () {
                const index = $(this).data("index");
                const tabla = $(this).val();
                //actualizarColumnasJoin(tabla, 'b', index);
            });
        }
        function activarDragColumnas() {
            //$(".arrastrar_columna").draggable("destroy");
            $(".arrastrar_columna").draggable({
                handle: ".handle",
                helper: "clone",
                appendTo: "body",
                revert: "invalid",
                cursorAt: { top: 50, right: 0 },  
                drag: function (event, ui) {
                        let sidebar = $('#sidebar-configuracion')[0];

                        const offset = $(sidebar).offset();
                        const scrollTop = sidebar.scrollTop;
                        const height = $(sidebar).outerHeight();
                        const y = event.pageY - offset.top + scrollTop;

                        const SCROLL_ZONE = 50;
                        const SCROLL_SPEED = 15;

                        // Scroll hacia abajo
                        if (y > height - SCROLL_ZONE) {
                            sidebar.scrollTop += SCROLL_SPEED;
                        }

                        // Scroll hacia arriba
                        else if (y < SCROLL_ZONE) {
                            sidebar.scrollTop -= SCROLL_SPEED;
                        }
                    }
            });
        }

        function eventoEliminarColumnaJoin() {
            $("body").off("click", ".eliminar-columna");
            $("body").on("click", ".eliminar-columna", function () {
                $(this).closest(".drop-columna-a, .drop-columna-b").empty();
            });
        }
        {{-- JOINS --}}


        {{-- CONDICIONES WHERE --}}
        function eventosClickCondiciones(){
            $("body").find("#agregar_condicion").off();
                $("#agregar_condicion").off().on("click", function () {
                const tipo = $("#tipo_condicion_a_agregar").val(); // "simple" o "grupo"
                const ruta = tipo === "simple"
                    ? '{{ route("ajax.where_simple") }}'
                    : '{{ route("ajax.where_grupal") }}';

                const tablasSeleccionadas = $("#tablas_seleccionadas_query").val().split(",").filter(t => t.trim() !== "");
                const index = $("body").find(".condicion").length;
                $.ajax({
                    url: ruta,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        tablas: tablasSeleccionadas, // <- importante
                        index: index
                    },
                    success: function (html) {
                        $("#where_condiciones").append(html);
                        activarEventoAgregarCondicionInterna();
                        activarBotonEnlazarFiltro();
                    },
                    error: function () {
                        alert("Error al generar la condición.");
                    }
                });
            });

            // Delegado para eliminar condiciones
            $("body").find(".eliminar-condicion").off();
            $(document).on("click", ".eliminar-condicion", function () {
                $(this).closest(".condicion-simple").remove();
                  reasignarIndicesWhere();
            });

            // Delegado para eliminar grupos
            $("body").find(".agregar-condicion-simple-grupo").off();
            $(document).on("click", ".eliminar-grupo", function () {
                $(this).closest(".grupo-condiciones").remove();
                  reasignarIndicesWhere();
            });

            

            

        }

        function activarEventoAgregarCondicionInterna() {
            $("body").off("click", ".agregar-condicion-simple-grupo");
            $("body").on("click", ".agregar-condicion-simple-grupo", function () {
                const grupoIndex = $(this).data("index");
                const contenedorGrupo = $(this).closest(".grupo-condiciones").find(".contenido-grupo");
                const tablasSeleccionadas = $("#tablas_seleccionadas_query").val().split(",").filter(t => t.trim() !== "");
                // Contar cuántas condiciones internas hay ya
                const totalInternas = contenedorGrupo.find(".condicion-simple").length;
                const index_interno = totalInternas;
                const index = grupoIndex;

                $.ajax({
                    url: '{{ route("ajax.where_simple") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        index: index,
                        tablas: tablasSeleccionadas, // <- importante
                        index_interno: index_interno,
                        es_subgrupo: true // puedes usar esto para ajustar la vista si es necesario
                    },
                    success: function (response) {
                        contenedorGrupo.append(response);
                        activarBotonEnlazarFiltro();
                    },
                    error: function () {
                        alert("No se pudo cargar la nueva condición interna.");
                    }
                });
            });
        }
        
    function reasignarIndicesWhere() {
            const contenedor = document.getElementById("where_condiciones");
            let grupoIndex = 0;
            let simpleIndex = 0;
                const grupos = Array.from(contenedor.querySelectorAll('.grupo-condiciones'));
            contenedor.querySelectorAll('.condicion').forEach((bloque, ordenGlobal) => {
            const esGrupo = bloque.classList.contains('grupo-condiciones');
            const necesitaLogico = (ordenGlobal > 0);

            if (esGrupo) {
                const existeSelect = bloque.querySelector('select[name^="where_logico_grupal"]');

                if (necesitaLogico) {
                    if (!existeSelect) {
                        const nuevoSelect = document.createElement('select');
                        nuevoSelect.name = `where_logico_grupal[${ordenGlobal}]`; // nombre temporal, lo corregimos abajo
                        nuevoSelect.className = 'form-select mb-2';
                        nuevoSelect.style.maxWidth = '100px';

                        const optionAND = document.createElement('option');
                        optionAND.value = 'AND';
                        optionAND.text = 'AND';

                        const optionOR = document.createElement('option');
                        optionOR.value = 'OR';
                        optionOR.text = 'OR';

                        nuevoSelect.appendChild(optionAND);
                        nuevoSelect.appendChild(optionOR);

                        bloque.insertBefore(nuevoSelect, bloque.firstChild);
                    }
                } else {
                    if (existeSelect) existeSelect.remove();
                }

                // Después de insertar o dejar el select, lo renombramos correctamente:
                const selectFinal = bloque.querySelector('select[name^="where_logico_grupal"]');
                if (selectFinal) {
                    selectFinal.name = `where_logico_grupal[${grupoIndex}]`;
                }

                // Reindexar condiciones internas del grupo
                const condicionesInternas = bloque.querySelectorAll('.condicion-simple');
                condicionesInternas.forEach((condicion, indexInterno) => {
                    const prefix = `${grupoIndex}_${indexInterno}`;
                    condicion.setAttribute('data-index', prefix);

                    condicion.querySelectorAll('[name]').forEach((input) => {
                        if (input.name.includes('where[')) {
                            const campo = input.name.split('][')[1].replace(']', '');
                            input.name = `where[${prefix}][${campo}]`;
                        } else if (input.name.includes('where_logico_subgrupo')) {
                            input.name = `where_logico_subgrupo[${prefix}]`;
                        }
                    });
                });

                grupoIndex++;
            } else {
                const esPrimeroSimple = (simpleIndex === 0);
                bloque.setAttribute('data-index', simpleIndex);

                bloque.querySelectorAll('[name]').forEach((input) => {
                    if (input.name.includes('where[')) {
                        const campo = input.name.split('][')[1].replace(']', '');
                        input.name = `where[${simpleIndex}][${campo}]`;
                    } else if (input.name === 'where_logico[]') {
                        if (esPrimeroSimple) {
                            input.remove(); // eliminar si es la primera
                        }
                    }
                });

                simpleIndex++;
            }
        });


    }

    // Antes de enviar: guardar el orden de las condiciones
   function actualizarOrdenCondiciones() {
        const orden = [];

        document.querySelectorAll('#where_condiciones > .condicion').forEach(bloque => {
            const index = bloque.getAttribute('data-index');
            orden.push(index);
        });

        document.getElementById('orden_condiciones').value = JSON.stringify(orden);
    }

    function handleSubmit(event) {
        actualizarOrdenCondiciones(); // ← actualiza el input oculto

         if (!validarColumnasDeFunciones()) {
            event.preventDefault(); // Cancela envío si hay columnas faltantes
        }

        // No haces preventDefault aquí, porque quieres que se envíe
         return true;
    }

    function onActualizarSubmit(){
        $(document).on('submit', '#actualizar_seccion', handleSubmit);
    }
    {{-- CONDICIONES WHERE --}}

    {{-- Funciones--}}
    function activarAgregarFuncion(){
        console.log("Agregando funcion");
        $("#agregar_funcion").off();
        $("#agregar_funcion").click(function(){
            
            let index = $("#funciones_agregadas").find(".agregado").length;
            const tablas = $("#tablas_seleccionadas_query").val().split(",").filter(t => t.trim() !== "");
            $.ajax({
                    url: '{{ route("ajax.funcion_agregada") }}',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',index:index,tablas:tablas},
                    success:function(response){
                        $("#funciones_agregadas").append(response);
                        activarEliminarFuncion();  
                        sincronizarFuncionesYColumnas();                                                             
                    },
                    error: function () {
                        alert("Ocurrió un error al cargar la función agregada.");
                    }
            });
        });
    }
    function activarEliminarFuncion() {
        $("#funciones_agregadas").on("click", ".eliminar-agregado", function () {
            $(this).closest(".agregado").remove();
        });
    }
    function validarColumnasDeFunciones() {
        let columnasFunciones = new Set();
        let columnasSeleccionadas = new Set();

        // Recolectar columnas utilizadas en funciones agregadas (excepto '*')
        $("#funciones_agregadas select[name*='[columna]']").each(function () {
            const valor = $(this).val();
            if (valor && valor !== '*') {
                columnasFunciones.add(valor);
            }
        });

        // Recolectar columnas que el usuario arrastró manualmente (seleccionar[])
        $("#columnas_seleccionadas input[name='seleccionar[]']").each(function () {
            columnasSeleccionadas.add($(this).val());
        });

        // Validar: buscar columnas que están duplicadas (en funciones y también seleccionadas)
        let duplicadas = [];
        columnasFunciones.forEach(col => {
            if (columnasSeleccionadas.has(col)) {
                duplicadas.push(col);
            }
        });

        if (duplicadas.length > 0) {
            alert("Estas columnas están seleccionadas y también se usan en funciones agregadas. Elimina del área de columnas seleccionadas:\n" + duplicadas.join("\n"));
            return false; // Prevenir envío del formulario
        }

        return true; // Todo está bien
    }

    function sincronizarFuncionesYColumnas() {
            // Evento cuando se cambia la columna en alguna función agregada
            // Se eliminar la columna en caso de ser agregada a una función
            $(document).on('change', "#funciones_agregadas select[name*='[columna]']", function () {
                const columnaSeleccionada = $(this).val();
                
                if (!columnaSeleccionada || columnaSeleccionada === "*") return;

                // Buscar inputs con esa columna seleccionada
                $("#columnas_seleccionadas input[name='seleccionar[]']").each(function () {
                    if ($(this).val() === columnaSeleccionada) {
                        console.log("Eliminando columna duplicada en función: " + columnaSeleccionada);
                        $(this).closest('.arrastrar_columna').remove();
                    }
                });
            });
    }

    {{-- Funciones--}}

    {{-- Agrupaciones --}}
        function actualizarOpcionesAgrupacion() {
            const select = $("#columnas_para_agrupacion");
            const columnasSeleccionadas = $("input[name='seleccionar[]']")
                .map(function () {
                    return $(this).val();
                })
                .get();

            // Limpiar opciones existentes
            select.empty();

            // Agregar opciones que no estén agrupadas aún
            columnasSeleccionadas.forEach(col => {
                if (!agrupaciones.includes(col)) {
                    select.append(`<option value="${col}">${col}</option>`);
                }
            });
        }
        let agrupaciones = [];
        function activarAgregarAgrupacion() {
            $("#agregar_agrupacion").click(function () {
                console.log("agrupacion funcion agregar");
                const columna = $("#columnas_para_agrupacion").val();
                if (!columna || agrupaciones.includes(columna)) return;

                agrupaciones.push(columna);

                const btn = $(`
                    <button type="button" class="btn btn-outline-primary btn-sm me-2 mb-2 tabla-btn" data-columna="${columna}">
                        ${columna}
                        <span class="text-danger ms-1 eliminar-agrupacion" style="cursor:pointer;">×</span>
                        <input type="hidden" name="group_by[]" value="${columna}">
                    </button>
                `);

                $("#agrupaciones_agregadas").append(btn);
                actualizarOpcionesAgrupacion();
                activarEliminarAgrupacion();
            });
        }
        function activarEliminarAgrupacion() {
            $(document).on('click', '.eliminar-agrupacion', function () {
                const btn = $(this).closest('button');
                const col = btn.data('columna');
                agrupaciones = agrupaciones.filter(c => c !== col);
                btn.remove();
                actualizarOpcionesAgrupacion();
            });
        }

        {{-- Agrupaciones --}}

        {{-- Order By OrderBy --}}
        let ordenamientos = [];

    function actualizarOpcionesOrden() {
        const columnas = [];
        $('#columnas_seleccionadas input[name="seleccionar[]"]').each(function () {
            columnas.push($(this).val());
        });

        const $select = $('#orden_columna');
        const valorActual = $select.val();
        $select.empty();

        columnas.forEach(col => {
            if (!ordenamientos.some(o => o.columna === col)) {
                $select.append(`<option value="${col}">${col}</option>`);
            }
        });

        $select.val(valorActual);
    }

    function activarAgregarOrden() {
        $("#agregar_orden").click(function () {
            const columna = $("#orden_columna").val();
            const direccion = $("#orden_direccion").val();

            if (!columna || ordenamientos.some(o => o.columna === columna)) return;

            ordenamientos.push({ columna, direccion });

            const btn = $(`
                <button type="button" class="btn btn-outline-dark btn-sm me-2 mb-2 orden-btn" data-columna="${columna}">
                    ${columna} (${direccion})
                    <span class="text-danger ms-1 eliminar-orden" style="cursor:pointer;">×</span>
                    <input type="hidden" name="order_by[]" value="${columna}|${direccion}">
                </button>
            `);

            $("#ordenes_agregadas").append(btn);
            actualizarOpcionesOrden();
            activarEliminarOrden();
        });
    }

    function activarEliminarOrden() {
        $(document).on('click', '.eliminar-orden', function () {
            const btn = $(this).closest('button');
            const columna = btn.data('columna');

            ordenamientos = ordenamientos.filter(o => o.columna !== columna);
            btn.remove();
            actualizarOpcionesOrden();
        });
    }
    {{-- Order by --}}

    function activarToggleLimit() {
        const toggle = document.getElementById("toggle_limit");
        const inputLimit = document.getElementById("limit");

        if (!toggle || !inputLimit) return;

        toggle.addEventListener("change", function () {
            if (this.checked) {
                inputLimit.removeAttribute("disabled");
            } else {
                inputLimit.setAttribute("disabled", true);
                inputLimit.value = ""; // limpia el valor
            }
        });
    }

    {{-- Relación con Filtros --}}
    function activarBotonEnlazarFiltro(){
         console.log("activar filtro funcion");
        $("body").find(".activar-filtro").off();

        $("body").find(".activar-filtro").click(function(){
            console.log("activar filtro");
            let grupo = $(this).closest('.input-group');
            let selectFiltro = grupo.find('.filtro-parametro');
            let inputHidden = grupo.find('.filtro-activo');
            let inputValor = grupo.find('.input-valor');

            if (inputHidden.val() === 'false') {
                inputHidden.val('true');
                selectFiltro.removeClass('d-none');
                inputValor.prop('disabled', true);
                
                // Crea un input hidden con el mismo name que el input de valor
                const name = inputValor.attr('name');
                if (grupo.find(`input[type="hidden"][name="${name}"]`).length === 0) {
                    grupo.append(`<input type="hidden" name="${name}" value=""/>`);
                }

                $(this).html('-');
            } else {
                inputHidden.val('false');
                selectFiltro.addClass('d-none');
                inputValor.prop('disabled', false);
                
                // Remueve el hidden creado anteriormente
                const name = inputValor.attr('name');
                grupo.find(`input[type="hidden"][name="${name}"]`).remove();

                selectFiltro.val('');
                $(this).html('<i class="fadeIn animated bx bx-filter"></i>');
            }

        })
       
    }

    {{-- Relación con filtros --}}


    {{-- Grafica --}}
    function activarEventosGrafica(){
            $('#configurar_grafica').off();
       
            if ($('#configurar_grafica').length > 0) {
            $(document).on('click', '#configurar_grafica', function () {
                    let columnas = [];
                    let agregados = [];

                    // Capturar columnas seleccionadas
                    $("input[name='seleccionar[]']").each(function () {
                        columnas.push($(this).val());
                    });

                    // Capturar alias de funciones agregadas
                    $("input[name*='agregados'][name*='[alias]']").each(function () {
                        agregados.push($(this).val());
                    });

                    // Limpiar y repoblar selects
                    let labelSelect = $("#label_columna");
                    let valorSelect = $("#valor_columna");

                    labelSelect.empty();
                    valorSelect.empty();

                    columnas.forEach(function (col) {
                        labelSelect.append(`<option value="${col}">${col}</option>`);
                    });

                    agregados.forEach(function (alias) {
                        labelSelect.append(`<option value="${alias}">${alias}</option>`);
                        valorSelect.append(`<option value="${alias}">${alias}</option>`);
                    });
                });
            }
    }

    {{-- Grafica --}}

    {{-- Guardado de formulario --}}
    function obtenerDatosSeccion(seccionID) {
        let datos = {};
        $(`${seccionID} :input`).each(function () {
            const name = $(this).attr("name");
            if (name) {
                if ($(this).is(':checkbox')) {
                    datos[name] = $(this).is(':checked');
                } else if ($(this).is(':radio')) {
                    if ($(this).is(':checked')) {
                        datos[name] = $(this).val();
                    }
                } else {
                    datos[name] = $(this).val();
                }
            }
        });
        return datos;
    }

    function guardarSeccionFormulario(seccion="#seccion-auto-guardado") {
        // seccion = "#seccion-auto-guardado" 
        const form = document.querySelector("#creadorInforme");
        const datos = new FormData(form);
  
         $.ajax({
                url: "{{ route('autoguardado_seccion.creador_informe') }}",
                method: "POST",
                data: datos,
                processData: false, // ✅ Importante para FormData
                contentType: false, // ✅ Importante para FormData
                success: function (response) {
                    console.log("Guardado correctamente", response);
                },
                error: function (xhr) {
                    console.error("Error al guardar", xhr.responseText);
                }
            });
    }
    {{-- Guardado de formulario--}}






      
      
       
    @endpush

</script>
