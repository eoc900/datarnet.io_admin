<div class="col-md-6 border p-5 d-none mb-5 shadow" id="text-filter-config">
    <h5>Mostramos las opciones que hay para campo de texto</h5>
    <input type="hidden" name="type[]" value="text">

    {{-- Opciones visuales --}}
    <div class="mb-3">
    <label for="opcionesFiltroTexto" class="form-label">Desplegar filtro como</label>
    <select class="form-select" id="opcionesFiltroTexto" name="modo_visual_filtro_texto">
        <option value="select2" {{ ($filtros['text']['mode'] ?? '') == 'select2' ? 'selected' : '' }}>Buscador select2</option>
        <option value="botones" {{ ($filtros['text']['mode'] ?? '') == 'botones' ? 'selected' : '' }}>Botones</option>
        <option value="dropdown" {{ ($filtros['text']['mode'] ?? '') == 'tabla_enlazada' ? 'selected' : '' }}>Dropdown</option>
    </select>

    </div>
    {{-- Opciones visuales --}}


    {{-- Opcion para enlazar tabla --}}
    <div class="form-check form-switch mb-3">
        <input class="form-check-input enlazar-tabla" type="checkbox" id="enlazarTabla" value="true" name="tabla_enlazada_activado"
        {{ ($filtros['text']['tabla_enlazada_activado'] ?? false) ? 'checked' : '' }}>

        <label class="form-check-label" for="enlazarTabla">Extraer valores de tabla existente</label>
    </div>
    {{-- Opcion para enlazar tabla --}}
    
    {{-- Tablas disponibles --}}
    <label for="displayDropdown" class="form-label">Seleccionar tabla</label>
    <div class="input-group">
        <select name="tabla_enlazada" id="select_tabla" class="form-control">
            @foreach ($tablas as $tabla)
                <option value="{{ $tabla }}" {{ ($filtros['text']['tabla_enlazada'] ?? '') == $tabla ? 'selected' : '' }}>
                    {{ $tabla }}
                </option>
            @endforeach
        </select>
    </div>
    {{-- Tablas disponibles --}}

 


    {{-- Renderizamos las columnas --}}
    <div class="campo-draggable-columnas mt-4">
    </div>
    {{-- Renderizamos las columnas --}}

     {{-- Sección para asignar columnas a valor y etiqueta --}}
     <div id="zona-areas-enlace" class="d-none">
        <div class="drop-columna-texto-visible border p-3 mb-3 bg-light">
            <p class="text-center text-muted">Arrastra aquí la columna para el <strong>texto visible</strong></p>
        </div>

        <div class="drop-columna-valor-opcion border p-3 mb-3 bg-light">
            <p class="text-center text-muted">Arrastra aquí la columna para el <strong>valor de opción</strong></p>
        </div>
        <hr>
        <label for="" class="form-label">Visualizar como</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="formato_mostrar_opciones" id="radio-botones" value="botones"
          {{ ($filtros['text']['formato_mostrar_opciones'] ?? '') == 'botones' ? 'checked' : '' }}>

          <label class="form-check-label" for="radio-botones">Botones</label>        
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="formato_mostrar_opciones" id="radio-dropdown" value="dropdown"
          {{ ($filtros['text']['formato_mostrar_opciones'] ?? '') == 'dropdown' ? 'checked' : '' }}>
          <label class="form-check-label" for="radio-dropdown">Dropdown</label>
        </div>
     </div>  
    {{-- Sección para asignar columnas a valor y etiqueta --}}


    {{-- Área de drop para Select2 --}}
    <div class="area-select2 row d-none">
          <div class="col-sm-12 mt-3">
                <label for="" class="form-label text-primary">Buscar texto en los campos siguientes:</label>
                <div class="drop-campos-busqueda text-primary border border-primary pb-3 ps-3 drop-drop">
              
                    <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                    <p class="text-center">Arrastra columnas de tabla aquí</p>
                                       
                </div>
            </div>
            <div class="col-sm-12 mt-3">
                <label for="" class="form-label text-primary">Campos respuesta retorno:</label>
                <div class="drop-campos-respuesta text-primary border border-primary drop-drop">

                    <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                    <p class="text-center">Los resultados que verás como opciones</p>                
                    
                </div>
            </div>
            <div class="col-sm-12 mt-3">
                <label for="" class="form-label text-primary">Campo identificador:</label>
                <div class="drop-campo-identificador text-primary border border-primary drop-drop">
                   
                    <p class="text-center font-22"><i class="fadeIn animated bx bx-intersect"></i></p>
                    <p class="text-center">ID principal</p>
                 
                </div>
            </div>
            <button type="button" class="btn btn-danger mt-3 limpiarAreasDrop">Limpiar Select2</button>
    </div>
    {{-- Área de drop para Select2 --}}

    {{-- Agrega botones con dos inputs --}}
    <div class="area-botones-dropdown d-none mt-5">
      <label for="" class="form-label">Opciones disponibles como filtro:</label>
      <div class="input-group">
              <input type="text" class="form-control" id="inputValorBoton" placeholder="Valor del botón">          
              <input type="text" class="form-control" id="inputTextoBoton" placeholder="Texto visible">           
      </div>
      <div class="row">
        <div class="col-sm-12">
              <button type="button" class="btn btn-success w-100" id="btnAgregarBoton">Agregar</button>
        </div>
      </div>
      <div class="mt-4" id="zonaBotonesAgregados"></div>

      <input type="hidden" name="valores_boton" id="valoresBotonHidden">
      <input type="hidden" name="textos_boton" id="textosBotonHidden">
      
    </div>
    {{-- Agrega botones con dos inputs --}}

</div>

<script>
@push('text_filter_config')
   
      //Inicializar
      eventoTablaSeleccionada();
      ajaxObtenerColumnas($("#select_tabla").val());
      eventoChangeModoTexto();
      actualizarAreas();
      eventoChangeModoTexto();
      eventoClickAgregarOpcionBotones();
      eventoSwitchEnlazarTabla();
      //Checar si hay datos guardado
      cargarValores();
      cargarSelect2();
      eventoClickLimpiarSelect2();
  


    function eventoTablaSeleccionada(){
        $("#select_tabla").off();
        $("#select_tabla").on('change',function(){
            ajaxObtenerColumnas($(this).val());
        });
    }

     function eventoArrastrarColumna() {
        console.log("Arrastrando activada");
        $("body").find(".conjunto-arrastrable").off();
        $("body").find(".conjunto-arrastrable").draggable({
          handle: ".handle",
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
              width: original.outerWidth() - 30,
              height: original.outerHeight()
            });

            return clone;
          },
          revert: "invalid"
        });
      }


    function ajaxObtenerColumnas(tabla=""){
          $.ajax({
                  url: '{{ url("/ajax/columnas_tabla") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tabla:tabla,arrastrable: true},
                  success: function(response){
                      
                      $('body').find(".campo-draggable-columnas").html(response);

                    //   if(para=="checkbox"){
                    //     eventoArrastrarColumna();
                    //       activarDroppableColumnValue();
                    //     activarDroppableColumnOption();
                    //   }else{
                    //     //Activar las columnas arrastrables
                        eventoArrastrarColumna();
                        activarDroppableColumnValue();
                        activarDroppableColumnOption();
                        activarDroppableColumnaBusqueda();
                        //activarDroppableCamposConcatenados();
                        activarDroppableCamposRetorno();
                        activarDroppableCampoIdentificador();
                        activarDroppableColumnaTextoVisible();
                        activarDroppableColumnaValorOpcion();
                    //     campo_habilitar_concatenado();
                    //   }
                                        
                  }
          });
      }

      function activarDroppableColumnValue(){
            $( ".drop-column-value").off();
            $( ".drop-column-value").droppable({
              accept:'.conjunto-arrastrable',
              addClasses: false,
              drop: function( event, ui ) {
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });
                    let value = ui.draggable.find("select").val();

                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("valores");
                    droppedItem.find("select").remove();
                    droppedItem.find(".input-group").append('<input type="text" name="inputs['+indexInput($(this))+'][valor_columna_dropdown]" class="valor_columna_dropdown form-control" value="'+value+'" readonly>');
                    $(this).html(droppedItem); // Lo agregamos al área droppable       
              }
            });
      }
      function activarDroppableColumnOption(){
            $( ".drop-column-option").off();
            $( ".drop-column-option").droppable({
              accept:'.conjunto-arrastrable',
              addClasses: false,
              drop: function( event, ui ) {

                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });
                     let value = ui.draggable.find("select").val();
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("opciones");
                    droppedItem.find("select").remove();
                    droppedItem.find(".input-group").append('<input type="text" name="inputs['+indexInput($(this))+'][opcion_columna_dropdown]" class="opcion_columna_dropdown form-control" value="'+value+'" readonly>');
                    $(this).html(droppedItem); // Lo agregamos al área droppable       
              }
            });
      }

      function activarDroppableCamposRetorno(){
            $( ".drop-campos-respuesta").off();
            $( ".drop-campos-respuesta").droppable({
              accept:'.conjunto-arrastrable',
              addClasses: false,
              drop: function( event, ui ) {
       
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.css({
                    width: "100%",
                    height: "auto",
                    position: "relative",
                    top: "auto",
                    left: "auto"
                    });
                    let value = ui.draggable.find("select").val();
                    droppedItem.addClass("mt-3");
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("Retornar");
                    droppedItem.find("select").remove();
                    droppedItem.find(".input-group").append('<input type="text" name="respuesta[]" class="respuesta form-control" value="'+value+'" readonly>');
                    
                    // IMPORTANTE
                    if($(this).find(".campos_respuesta").length>0){
                       let current_val = $(this).find(".campos_respuesta").val();
                       let new_val = $(this).find(".campos_respuesta").val(current_val+","+value)
                    }else{
                      droppedItem.find(".input-group").append('<input type="hidden" name="campos_respuesta[]" class="form-control campos_respuesta" value="'+value+'" readonly>');
                    }

                    $(this).append(droppedItem); // Lo agregamos al área droppable       
              }
            });
      }
       function activarDroppableCampoIdentificador(){ // param select2
            $( ".drop-campo-identificador").off();
            $( ".drop-campo-identificador").droppable({
              accept:'.conjunto-arrastrable',
              addClasses: false,
              drop: function( event, ui ) {
        
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.css({
                        width: "100%",
                        height: "auto",
                        position: "relative",
                        top: "auto",
                        left: "auto"
                    });
                    let value = ui.draggable.find("select").val();
                    droppedItem.addClass("mt-3");
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("principal");
                    droppedItem.find("select").remove();
                    droppedItem.find(".input-group").append('<input type="text" name="principal" class="principal form-control" value="'+value+'" readonly>');                            
                    $(this).html(droppedItem); // Lo agregamos al área droppable       
              }
            });
      }

     

      function activarDroppableColumnaBusqueda(){
            $( ".drop-campos-busqueda").off();
            $( ".drop-campos-busqueda").droppable({
              accept:'.conjunto-arrastrable',
              addClasses: false,
              drop: function( event, ui ) {
     
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.css({
                    width: "100%",
                    height: "auto",
                    position: "relative",
                    top: "auto",
                    left: "auto"
                });

                    let value = ui.draggable.find("select").val();
                    droppedItem.addClass("mt-3");
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("buscar por");
                    droppedItem.find("select").remove();
                    droppedItem.find(".input-group").append('<input type="text" name="buscar_en[]" class="buscar_en form-control" value="'+value+'" readonly>');
                    
                    // concatenación
                    droppedItem.find(".input-group").append('<button type="button" class="btn btn-warning concatenado purple" data-concatenado="purple"><i class="lni lni-link"></i></button>');                
                    if($(this).find(".campos_concatenados").length>0){
                       let current_val = $(this).find(".campos_concatenados").val();
                       let new_val = $(this).find(".campos_concatenados").val(current_val+",concat:1:"+value);
                    }else{
                      droppedItem.find(".input-group").append('<input type="hidden" name="campos_concatenados[]" class="form-control campos_concatenados" value="concat:1:'+value+'" readonly>');
                    }
                    // concatenación

                    // IMPORTANTE Definición de los campos que buscarán valores
                    if($(this).find(".campos_busqueda").length>0){
                       let current_val = $(this).find(".campos_busqueda").val();
                       let new_val = $(this).find(".campos_busqueda").val(current_val+","+value)
                    }else{
                      droppedItem.find(".input-group").append('<input type="hidden" name="campos_busqueda[]" class="form-control campos_busqueda" value="'+value+'" readonly>');
                    }

                    $(this).append(droppedItem); // Lo agregamos al área droppable      
                    
                    // sólo si concatenar-habilitado
                    eventoClickConcatenado(); 
              }
            });
      }

      function eventoClickConcatenado(){
        // concatenación snippet

        $("body").find(".concatenado").off();
        $("body").find(".concatenado").click(function(){

          // {{-- 1. Sacar los valores de campos concatenados y el valor del input dentro del input-group --}}
          var campos_concatenados = $(this).closest(".drop-campos-busqueda").find(".campos_concatenados").val();
       

          arr_concatenados = [];
          if(campos_concatenados.length>0){
             arr_concatenados = campos_concatenados.split(",");
          }
         
   
          var val = $(this).closest(".input-group").find(".buscar_en").val();
          var arr = val.split(":");
          // {{-- 1. Sacar los valores de campos concatenados y el valor del input dentro del input-group --}}

          var colores_frecuencia = {
              "red":0,
              "purple":1,
              "orange":2,
              "blue":3,
              0:"red",
              1:"purple",
              2:"orange",
              3:"blue"
          };
          var btn_concatenado = $(this).closest(".drop-campos-busqueda").find(".concatenado");
          let conteo = btn_concatenado.length;
          let label = $(this).attr("data-concatenado");
          let index = colores_frecuencia[label];

          // Borrar el valor anterior
          let remove = arr_concatenados.indexOf("concat:"+colores_frecuencia[label]+":"+val);
          var new_arr = [];
          if (remove !== -1) {
              arr_concatenados.splice(remove, 1); // ✅ Modifica el array original correctamente
          }
          new_arr = arr_concatenados; // ✅ Ahora sí mantiene los valores correctos

          if(new_arr.length>0){

            $(this).closest(".drop-campos-busqueda").find(".campos_concatenados").val(new_arr.toString());
          }else{
            $(this).closest(".drop-campos-busqueda").find(".campos_concatenados").val("");
            new_arr = [];
          }
          
      
          // Borrar el valor anterior

          index++;
          if(index>conteo || index>3){
            index=0;
            $(this).html('<i class="lni lni-minus"></i>');
          }else{
            $(this).html('<i class="lni lni-link"></i>');
            new_arr.push("concat:"+index+":"+val);
            $(this).closest(".drop-campos-busqueda").find(".campos_concatenados").val(new_arr.toString());
          }

          $(this).attr("data-concatenado",colores_frecuencia[index]);
          $(this).removeClass(label).addClass(colores_frecuencia[index]);

        });
      }

      {{-- Para zona de text-filter --}}
      function actualizarAreas() {
          const modo = $('#opcionesFiltroTexto').val();

          const tablaEnlazadaActiva = $('#enlazarTabla').is(':checked');

          // Siempre ocultar las áreas visuales
          $('.area-select2, .area-botones-dropdown').addClass('d-none');

          // Solo mostrar si NO está activado "Extraer valores de tabla existente"
          if (!tablaEnlazadaActiva) {
              if (modo === 'select2') {
                  $('.area-select2').removeClass('d-none');
              } else if (modo === 'botones' || modo === 'dropdown') {
                  $('.area-botones-dropdown').removeClass('d-none');
              }
          }
      }


        function actualizarHiddenInputs() {
            let valores = [];
            let textos = [];

            $('#zonaBotonesAgregados .boton-opcion').each(function () {
                valores.push($(this).data('valor'));
                textos.push($(this).data('texto'));
            });

            $('#valoresBotonHidden').val(valores.join(','));
            $('#textosBotonHidden').val(textos.join(','));
        }

        function eventoClickAgregarOpcionBotones() {
            $('#btnAgregarBoton').off().on('click', function () {
                const valor = $('#inputValorBoton').val().trim();
                const texto = $('#inputTextoBoton').val().trim();

                if (valor === '' || texto === '') {
                    alert('Ambos campos son obligatorios.');
                    return;
                }

                if ($('#zonaBotonesAgregados').find(`.boton-opcion[data-valor="${valor}"]`).length > 0) {
                    alert('Este valor ya fue agregado.');
                    return;
                }

                const boton = $(`
                    <div class="d-inline-block me-2 mb-2 boton-opcion badge bg-dark p-2" data-valor="${valor}" data-texto="${texto}">
                        ${texto}
                        <button type="button" class="btn-close btn-close-white ms-2 eliminar-boton" aria-label="Eliminar"></button>
                    </div>
                `);

                $('#zonaBotonesAgregados').append(boton);
                actualizarHiddenInputs();
                $('#inputValorBoton, #inputTextoBoton').val('');
            });

            eventoClickEliminarBoton();
        }

        function eventoClickEliminarBoton() {
            $('#zonaBotonesAgregados').off('click', '.eliminar-boton').on('click', '.eliminar-boton', function () {
                $(this).closest('.boton-opcion').remove();
                actualizarHiddenInputs();
            });
        }

        function eventoChangeModoTexto() {
            $('#opcionesFiltroTexto').on('change', actualizarAreas);
        }

    function eventoSwitchEnlazarTabla() {
      $('#enlazarTabla').on('change', function () {
        const isChecked = $(this).is(':checked');

        // Mostrar u ocultar zona para enlazar columnas
        $('#zona-areas-enlace').toggleClass('d-none', !isChecked);
       

        // Mostrar u ocultar zonas visuales (select2, botones, etc.)
        $('.area-select2, .area-botones-dropdown').toggleClass('d-none', isChecked);
        $('#opcionesFiltroTexto').closest('.mb-3').toggleClass('d-none', isChecked);

        // Limpia campos si se desactiva el checkbox
        if (!isChecked) {
          $('#columna_valor_tabla').val('');
          $('#columna_texto_tabla').val('');
          $('.drop-area-valor, .drop-area-etiqueta').empty().append('<p class="mb-0"><i class="bx bx-move"></i> Arrastra aquí la columna</p>');
        }
          actualizarAreas();
      });
    }


   function activarDroppableColumnaTextoVisible() {
    $(".drop-columna-texto-visible").off().droppable({
        accept: '.conjunto-arrastrable',
        addClasses: false,
        drop: function (event, ui) {
            const droppedItem = ui.helper.clone().removeClass("ui-draggable ui-draggable-handle").css({
                top: "auto",
                left: "auto",
                position: "relative"
            });

            const value = ui.draggable.find("select").val();

            droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>')
                .removeClass("btn-primary").addClass("btn-success");

            droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success")
                .html("texto visible");

            droppedItem.find("select").remove();
            droppedItem.find(".input-group").append(
                '<input type="text" name="texto_opcion_tabla_enlazada" class="form-control" value="' + value + '" readonly>'
            );

            $(this).empty().append(droppedItem); // ← cambio aquí
        }
    });
}



    function activarDroppableColumnaValorOpcion() {
      $(".drop-columna-valor-opcion").off().droppable({
          accept: '.conjunto-arrastrable',
          addClasses: false,
          drop: function (event, ui) {

              const droppedItem = ui.helper.clone().css({
                  top: "auto",
                  left: "auto",
                  position: "relative"
              });

              const value = ui.draggable.find("select").val();

              droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>')
                  .removeClass("btn-primary").addClass("btn-success");
              droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success")
                  .html("valor");

              droppedItem.find("select").remove();
              droppedItem.find(".input-group").append(
                  '<input type="text" name="valor_opcion_tabla_enlazada" class="form-control" value="' + value + '" readonly>'
              );
              $(".drop-columna-valor-opcion").html("");

              $(this).empty().append(droppedItem);
          }
      });
    }

    function cargarValores(){
      // En el $(document).ready
      const valores = '{{ $filtros["text"]["valores_boton"] ?? "" }}'.split(',');
      const textos = '{{ $filtros["text"]["textos_boton"] ?? "" }}'.split(',');

      if (valores.length && textos.length && valores[0] !== '') {
          for (let i = 0; i < valores.length; i++) {
              const boton = $(`
                  <div class="d-inline-block me-2 mb-2 boton-opcion badge bg-primary p-2" data-valor="${valores[i]}" data-texto="${textos[i]}">
                      ${textos[i]}
                      <button type="button" class="btn-close btn-close-white ms-2 eliminar-boton" aria-label="Eliminar"></button>
                  </div>
              `);
              $('#zonaBotonesAgregados').append(boton);
          }

          $('#valoresBotonHidden').val(valores.join(','));
          $('#textosBotonHidden').val(textos.join(','));
      }

    }
    function limpiarAreasSelect2() {
        $('.drop-campos-busqueda').empty();
        $('.drop-campos-respuesta').empty();
        $('.drop-campo-identificador').empty();
    }

    function eventoClickLimpiarSelect2(){
      $('.limpiarAreasDrop').off();
      $('.limpiarAreasDrop').click(function(){
          limpiarAreasSelect2();
      })
    }


    function cargarValoresSelect2(filtro) {
          if (!filtro || filtro.mode !== "select2") return;

          // Limpiamos primero todo
          limpiarAreasSelect2();

          // Área buscar_en
          filtro.buscar_en.forEach((col, index) => {
              let concatenado = filtro.campos_concatenados?.[index] || "";
              let colorClass = index > 0 ? "purple" : "orange"; // visual
              let html = `
              <div class="conjunto-arrastrable mt-3">
                  <div class="input-group mb-3">
                      <button type="button" class="btn title btn-outline-success">buscar por</button>
                      <span type="button" class="handle btn float-end btn-success">
                          <i class="lni lni-checkmark-circle"></i>
                      </span>
                      <input type="text" name="buscar_en[]" class="buscar_en form-control" value="${col}" readonly>
                      <button type="button" class="btn btn-warning concatenado ${colorClass}" data-concatenado="${colorClass}">
                          <i class="lni lni-link"></i>
                      </button>
                      <input type="hidden" name="campos_concatenados[]" class="campos_concatenados" value="${concatenado}" readonly>
                      <input type="hidden" name="campos_busqueda[]" class="campos_busqueda" value="${filtro.buscar_en.join(',')}" readonly>
                  </div>
              </div>`;
              $('.drop-campos-busqueda').append(html);
          });

          // Área respuesta
          filtro.retornar.forEach((col) => {
              let nombreCol = `${filtro.tabla}.${col}`;
              let html = `
              <div class="conjunto-arrastrable mt-3">
                  <div class="input-group mb-3">
                      <button type="button" class="btn title btn-outline-success">Retornar</button>
                      <span type="button" class="handle btn float-end btn-success">
                          <i class="lni lni-checkmark-circle"></i>
                      </span>
                      <input type="text" name="respuesta[]" class="respuesta form-control" value="${nombreCol}" readonly>
                      <input type="hidden" name="campos_respuesta[]" class="campos_respuesta" value="${filtro.retornar.map(c => `${filtro.tabla}.${c}`).join(',')}" readonly>
                  </div>
              </div>`;
              $('.drop-campos-respuesta').append(html);
          });

          // Área principal
          let html = `
          <div class="conjunto-arrastrable mt-3">
              <div class="input-group mb-3">
                  <button type="button" class="btn title btn-outline-success">principal</button>
                  <span type="button" class="handle btn float-end btn-success">
                      <i class="lni lni-checkmark-circle"></i>
                  </span>
                  <input type="text" name="principal" class="principal form-control" value="${filtro.principal}" readonly>
              </div>
          </div>`;
          $('.drop-campo-identificador').append(html);
      }
      
      function cargarValoresTablaEnlazada(filtro) {
    if (!filtro || filtro.mode !== "tabla_enlazada") return;

    // Mostrar la zona de áreas
    $('#zona-areas-enlace').removeClass('d-none');

    let errores = [];

    // Texto visible
    if (filtro.texto_opcion_tabla_enlazada) {
        let html = `
        <div class="conjunto-arrastrable mt-3">
            <div class="input-group mb-3">
                <button type="button" class="btn title btn-outline-success">Texto visible</button>
                <input type="text" name="texto_opcion_tabla_enlazada" class="form-control" value="${filtro.texto_opcion_tabla_enlazada}" readonly>
            </div>
        </div>`;
        $('.drop-columna-texto-visible').append(html);
    } else {
        errores.push("⚠️ Falta la columna para el **Texto visible**.");
    }

    // Valor de opción
    if (filtro.valor_opcion_tabla_enlazada) {
        let html = `
        <div class="conjunto-arrastrable mt-3">
            <div class="input-group mb-3">
                <button type="button" class="btn title btn-outline-success">Valor de opción</button>
                <input type="text" name="valor_opcion_tabla_enlazada" class="form-control" value="${filtro.valor_opcion_tabla_enlazada}" readonly>
            </div>
        </div>`;
        $('.drop-columna-valor-opcion').append(html);
    } else {
        errores.push("⚠️ Falta la columna para el **Valor de opción**.");
    }

    // Visualización como botones o dropdown
    if (filtro.formato_mostrar_opciones === "botones") {
        $('#radio-botones').prop("checked", true);
    } else if (filtro.formato_mostrar_opciones === "dropdown") {
        $('#radio-dropdown').prop("checked", true);
    } else {
        errores.push("⚠️ Falta seleccionar el formato de visualización (botones o dropdown).");
    }

    // Mostrar alertas si hay errores
    if (errores.length > 0) {
        alert("Se encontraron algunos problemas al cargar el filtro enlazado:\n\n" + errores.join("\n"));
    }
}




    function cargarSelect2() {
        let filtroGuardado = @json($filtros["text"] ?? null);

        if (filtroGuardado) {
            if (filtroGuardado.mode === "select2") {
                cargarValoresSelect2(filtroGuardado);
            } else if (filtroGuardado.mode === "tabla_enlazada" && filtroGuardado.tabla_enlazada_activado === "true") {
                cargarValoresTablaEnlazada(filtroGuardado);
            }
        }
    }



  
      {{-- Para zona de text filter --}}

        


   
    
@endpush
</script>