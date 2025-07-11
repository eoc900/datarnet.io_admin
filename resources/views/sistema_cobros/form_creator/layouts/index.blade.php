<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

      
</head>
<body>
    @include('general.partials.header')
    @include('general.partials.sidebar')

      <main class="main-wrapper">
        <div class="main-content">
            @yield('content')
        </div>
    </main>


    @include('general.partials.scripts')

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    @include('sistema_cobros.form_creator.scripts.validaciones_inputs_scripts')
    @include('sistema_cobros.form_creator.scripts.alertas_inputs',["arreglo"=>["conf_avanzada","slug"]])
    @include('sistema_cobros.form_creator.scripts.eventos_inputs')
    @stack('funciones_modal_parametros')

   
    <script>
      $(document).ready(function(){

      @stack('form_creator_top_section')
     
      @include('sistema_cobros.form_creator.scripts.funciones.validaciones')

      function ajaxSeleccionInputType(){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorInputSelection") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}'},
                  success: function(response){
                      $(".contenedor_campos").append(response);
                      eventoClickAgregarCampo();
                  }
          });
      }
      function eventoClickAgregarCampo(){
          $(".agregar-campo").off();
          $(".agregar-campo").click(function(){
                let index = $('.configuracion-input').length;
                console.log(index);
                let input_segment = $(this).closest(".input-segment");
                let input_type = input_segment.find(".input-type").val();

                
                switch(input_type){
                  case "dropdown":
                    ajaxDropdownConfig(input_segment,index);
                  break;
                  case "select2":
                    ajaxSelect2Config(input_segment,index);
                  break;
                  case "radio":
                    ajaxRadioConfig(input_segment,index);
                  break;
                  case "date":
                    ajaxDateConfig(input_segment,index);
                  break;
                  case "time":
                    ajaxTimeConfig(input_segment,index);
                  break;
                  case "datetime":
                    ajaxDatetimeConfig(input_segment,index);
                  break;
                  case "text":
                    ajaxTextConfig(input_segment,index);
                  break;
                  case "email":
                    ajaxEmailConfig(input_segment,index);
                  break;
                  case "file":
                    ajaxFileConfig(input_segment,index);
                  break;
                  case "checkbox":
                    ajaxCheckboxConfig(input_segment,index);
                  break;
                  case "hidden":
                    ajaxHiddenInputConfig(input_segment);
                  break;
                  case "multi-item":
                    alert("Input no aplica para formularios enlazados con tablas");
                    ajaxMultiItemConfig(input_segment,true);
                  break;
                  default:
                    alert("Input no reconocido");
                }

                arreglaIndexInputs();


          });
      }
      function ajaxDropdownConfig(inputSegment,index,enlaceTabla=false,subcampo=false,){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorDropdownInputConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo, index:index},
                  success: function(response){
                  
                    //Subcampo
                    if(subcampo){
                        console.log("ajaxDropdownCofig subcampo:"+subcampo);
                        $('#contenido-subcampo').html('');
                        console.log(response);
                        console.log($(inputSegment));
                        $(inputSegment).append(response);
                        eventoClickSeleccionarTabla(true);
                        return;
                    }

                    if(!enlaceTabla){
                        var segment = $(inputSegment).find(".campos-configuracion"); // Donde se agrega la configuración de cada input
                        segment.append(response);
                        // Se selecciona una tabla de referencia en la configuración
                        eventoClickSeleccionarTabla();
                        eventoClickPrevisualizar();
                        removeConfigInput();
                        
                    }
                    if(enlaceTabla){
                      inputSegment.html(response);
                      eventoClickSeleccionarTabla();
                      eventoClickPrevisualizar();
                      removeConfigInput();
                    }

                    // Para configuración de validación
                    activarValidacionCheckbox();
                
                  }
          });
      }
      function ajaxSelect2Config(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorSelect2InputConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){

                    if(subcampo){
                      $('#contenido-subcampo').html('');
                      console.log(response);
                      console.log($(inputSegment));
                      $(inputSegment).append(response);
                      eventoClickSeleccionarTabla(true);
                      eventoArrastrarTabla(true);
                      activarDroppableTabla(true);
                      return;
                    }
                      
                    $(inputSegment).find(".campos-configuracion").append(response);
                    // Se selecciona una tabla de referencia en la configuración
                    eventoClickSeleccionarTabla();
                    eventoArrastrarTabla();
                    activarDroppableTabla();
                    eventoClickPrevisualizarSelect2();
                    removeConfigInput();
                    // Para configuración de validación
                    activarValidacionCheckbox();
                  }
          });
      }
      function ajaxRadioConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorRadioConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){

                    if(subcampo){
                      $('#contenido-subcampo').html('');
                      $(inputSegment).append(response);
                      eventoClickAgregarRadio(true);
                      return;
                    }
                      
                    $(inputSegment).find(".campos-configuracion").append(response); // Donde se agrega la configuración de cada input
                    // Se selecciona una tabla de referencia en la configuración
                    eventoClickAgregarRadio();
                    eventoClickPrevisualizarRadio();
                    removeConfigInput();
                    // Para configuración de validación
                    activarValidacionCheckbox();

                  }
          });
      }
      function ajaxDateConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorDateConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){

                  if(subcampo){
                    $('#contenido-subcampo').html('');
                    $(inputSegment).append(response);
                    return;
                  }
                      
                  var segment = $(inputSegment).find(".campos-configuracion"); // Donde se agrega la configuración de cada input
                  segment.append(response);
                  // Asignar el atributo a name="inputs[i][]"
                  let index = $(".contenedor_campos").find(".configuracion-input").length;
                  $("body").find(".configuracion-input").eq(index-1).find(".formato-fecha").attr("name","inputs["+(index-1)+"][formato_fecha]");
                    // Se selecciona una tabla de referencia en la configuración
                  eventoClickPrevisualizarDate();
                  removeConfigInput();
                  // Para configuración de validación
                  activarValidacionCheckbox();
                  
                  }
          });
      }
      function ajaxTimeConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorTimeConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){

                  if(subcampo){
                    $('#contenido-subcampo').html('');
                    $(inputSegment).append(response);
                    return;
                  }
                      
                  var segment = $(inputSegment).find(".campos-configuracion"); // Donde se agrega la configuración de cada input
                  segment.append(response);
                  // Asignar el atributo a name="inputs[i][]"
                  let index = $(".contenedor_campos").find(".configuracion-input").length;
                  $("body").find(".configuracion-input").eq(index-1).find(".formato-fecha").attr("name","inputs["+(index-1)+"][formato_fecha]");
                    // Se selecciona una tabla de referencia en la configuración
                  eventoClickPrevisualizarTime();
                  removeConfigInput();
                  // Para configuración de validación
                  activarValidacionCheckbox();
                  
                  }
          });
      }
      function ajaxDatetimeConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorDatetimeConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){
                  
                  if(subcampo){
                    $('#contenido-subcampo').html('');
                    $(inputSegment).append(response);
                    return;
                  }
                  
                  var segment = $(inputSegment).find(".campos-configuracion"); // Donde se agrega la configuración de cada input
                  segment.append(response);

                  // Asignar el atributo a name="inputs[i][]"
                  let index = $(".contenedor_campos").find(".configuracion-input").length;
                  $("body").find(".configuracion-input").eq(index-1).find(".formato-fecha").attr("name","inputs["+(index-1)+"][formato_fecha]");
                    // Se selecciona una tabla de referencia en la configuración
                  eventoClickPrevisualizarDatetime();
                  removeConfigInput();
                  // Para configuración de validación
                  activarValidacionCheckbox();
                  
                  }
          });
      }
      function ajaxTextConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorTextConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){
                      
                    if(subcampo){
                      $('#contenido-subcampo').html('');
                      $(inputSegment).append(response);
                      return;
                    }
                    $(inputSegment).find(".campos-configuracion").append(response); // Donde se agrega la configuración de cada input
                    // Se selecciona una tabla de referencia en la configuración
                      // Asignar el atributo a name="inputs[i][]"
                    let index = $(".contenedor_campos").find(".configuracion-input").length;
                    $("body").find(".configuracion-input").eq(index-1).find(".input-text").attr("name","inputs["+(index-1)+"][placeholder]");
                    eventoClickPrevisualizarText();
                    removeConfigInput();
                    // Para configuración de validación
                    activarValidacionCheckbox();
                    

                  }
          });
      }
      function ajaxEmailConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorEmailConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){
                    if(subcampo){
                      $('#contenido-subcampo').html('');
                      $(inputSegment).append(response);
                      return;
                    }                      
                    $(inputSegment).find(".campos-configuracion").append(response); // Donde se agrega la configuración de cada input
                    // Se selecciona una tabla de referencia en la configuración
                      // Asignar el atributo a name="inputs[i][]"
                    let index = $(".contenedor_campos").find(".configuracion-input").length;
                    $("body").find(".configuracion-input").eq(index-1).find(".input-text").attr("name","inputs["+(index-1)+"][placeholder]");
                    eventoClickPrevisualizarEmail();
                    removeConfigInput();
                    // Para configuración de validación
                    activarValidacionCheckbox();
                    

                    
                  }
          });
      }
      function ajaxFileConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorFileConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){
                    if(subcampo){
                      $('#contenido-subcampo').html('');
                      $(inputSegment).append(response);
                      return;
                    }
                    $(inputSegment).find(".campos-configuracion").append(response); // Donde se agrega la configuración de cada input
                    // Se selecciona una tabla de referencia en la configuración
                      // Asignar el atributo a name="inputs[i][]"
                    let index = $(".contenedor_campos").find(".configuracion-input").length;
                    $("body").find(".configuracion-input").eq(index-1).find(".file_type").attr("name","inputs["+(index-1)+"][file_type][]");
                    $("body").find(".configuracion-input").eq(index-1).find(".storage_directory").attr("name","inputs["+(index-1)+"][storage_directory]");
                    $("body").find(".configuracion-input").eq(index-1).find(".file_size").attr("name","inputs["+(index-1)+"][file_size]");
                    eventoClickPrevisualizarFile();
                    removeConfigInput();
                    // Para configuración de validación
                    activarValidacionCheckbox();
                    
                  
                  }
          });
      }
      function ajaxCheckboxConfig(inputSegment,index,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorCheckboxConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo,index:index},
                  success: function(response){

                    if(subcampo){
                      $('#contenido-subcampo').html('');
                      $(inputSegment).append(response);
                      return;
                    }
                      
                    $(inputSegment).find(".campos-configuracion").append(response); // Donde se agrega la configuración de cada input
                    // Se selecciona una tabla de referencia en la configuración
                      // Asignar el atributo a name="inputs[i][]"
                    
                    let index =  $(".contenedor_campos").find(".configuracion-input").length-1;
                    var select2 = $("body").find(".configuracion-input").eq(index).find(".select2");
                    var enlazado = $("body").find(".configuracion-input").eq(index).find(".checkbox-enlazado");
                    select2.attr("name","inputs["+index+"][tabla_checkbox]");
                    enlazado.attr("name","inputs["+index+"][enlazado]");


                    eventoClickAgregarCasilla();
                    eventoClickPrevisualizarCheckbox();
                    eventoEnlazarCheckbox();
                    select2TablaModuloEnlazarCheckbox(select2);
                    removeConfigInput();
                    // Para configuración de validación
                    activarValidacionCheckbox();
                    

                  }
          });
      }

       function ajaxHiddenInputConfig(inputSegment,subcampo=false){ 
          $.ajax({
                  url: '{{ url("/ajax/formCreatorHiddenInputConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',es_subcampo:subcampo},
                  success: function(response){
                      
                    if(subcampo){
                      $('#contenido-subcampo').html('');
                      $(inputSegment).append(response);
                      return;
                    }
                    $(inputSegment).find(".campos-configuracion").append(response); // Donde se agrega la configuración de cada input
                    // Se selecciona una tabla de referencia en la configuración
                      // Asignar el atributo a name="inputs[i][]"
                    let index = $(".contenedor_campos").find(".configuracion-input").length;                   
                    removeConfigInput();
                    

                  }
          });
      }
      {{-- Para el tema de multi-item --}}
      function ajaxMultiItemConfig(inputSegment){ 
          let index =  $(".contenedor_campos").find(".configuracion-input").length;
          $.ajax({
                  url: '{{ url("/ajax/formCreatorMultiItemConfig") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',index:index},
                  success: function(response){
                
                        var segment = $(inputSegment).find(".campos-configuracion"); // Donde se agrega la configuración de cada input
                        segment.append(response);
                        removeConfigInput();
                        eventoClickAgregarSubCampo();
                        // Se selecciona una tabla de referencia en la configuración     
                        // Para configuración de validación
                                                                       
                  }
          });
      }
      function eventoClickAgregarSubCampo(){
        $('.agregar-subcampo').off();
        $('.agregar-subcampo').on('click', function () {
            const indexPadre = $(this).data('index'); // i
            const inputSegment = $(this).closest('.configuracion-input'); // contenedor general
            const index = inputSegment.index('.contenedor_campos .configuracion-input');
            const input_type = inputSegment.find('.opciones-subcampo').val();
            console.log(input_type);

            // Guardar el índice para uso posterior (modal, etc.)
            $('#indexPadreMultiItem').val(indexPadre);

            // Renderizar la configuración del campo hijo dentro del modal
            switch (input_type) {
                case "dropdown":
                    ajaxDropdownConfig('#contenido-subcampo',index,false,true);
                    break;
                case "select2":
                    ajaxSelect2Config('#contenido-subcampo',index,true);
                    break;
                case "radio":
                    ajaxRadioConfig('#contenido-subcampo',index,true);
                    break;
                case "date":
                    ajaxDateConfig('#contenido-subcampo',index,true);
                    break;
                case "time":
                    ajaxTimeConfig('#contenido-subcampo',index,true);
                    break;
                case "datetime":
                    ajaxDatetimeConfig('#contenido-subcampo',index,true);
                    break;
                case "text":
                    ajaxTextConfig('#contenido-subcampo',index,true);
                    break;
                case "email":
                    ajaxEmailConfig('#contenido-subcampo',index,true);
                    break;
                case "file":
                    ajaxFileConfig('#contenido-subcampo',index,true);
                    break;
                case "checkbox":
                    ajaxCheckboxConfig('#contenido-subcampo',index,true);
                    break;
                case "hidden":
                    ajaxHiddenInputConfig('#contenido-subcampo',true);
                    break;
                case "multi-item":
                    ajaxMultiItemConfig('#contenido-subcampo',true);
                    break;
                default:
                    alert("Tipo de campo no reconocido");
                    return;
            }

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('modal-subcampo'));
            modal.show();
        });

      }

      function guardarSubcampo(){
        $('#guardar-subcampo').off();
        $('#guardar-subcampo').on('click', function () {
            const indexPadre = $('#indexPadreMultiItem').val(); // inputs[i]
            const subIndex = $(`.campos-hijos[data-index="${indexPadre}"] .subcampo`).length; // inputs[i][campos][x]

            const nuevoSubcampo = $('<div class="subcampo border p-3 mb-3 rounded bg-light shadow-sm"></div>');

            $('#contenido-subcampo').find('input, select, textarea').each(function () {
                const oldName = $(this).attr('name'); // Ej: tipo_subcampo
                const value = $(this).val();
                if (!oldName) return;

                // Transforma nombre: tipo_subcampo → type
                const finalKey = oldName.replace('_subcampo', '');

                // Crea nuevo input con nombre estructurado
                const newName = `inputs[${indexPadre}][campos][${subIndex}][${finalKey}]`;
                const hiddenInput = $(`<input type="hidden" name="${newName}">`).val(value);

                nuevoSubcampo.append(hiddenInput);
            });

            // Agrega un resumen visual simple del tipo de subcampo
            const tipo = $('#contenido-subcampo').find('[name="tipo_subcampo"]').val() ?? '';
            const nombre = $('#contenido-subcampo').find('[name="nombre_subcampo"]').val() ?? '';
            const resumen = $(`<div class="mb-2"><strong>${tipo}</strong> - <code>${nombre}</code></div>`);
            nuevoSubcampo.prepend(resumen);

            // Insertar en el DOM
            $(`.campos-hijos[data-index="${indexPadre}"]`).append(nuevoSubcampo);

            // Limpiar y cerrar modal
            $('#contenido-subcampo').html('');
            bootstrap.Modal.getInstance(document.getElementById('modal-subcampo')).hide();
        });


      }




      {{-- Para el tema de multi-item --}}



     
      function ajaxObtenerColumnas(objeto,tabla="",para="",subcampo=false){
          $.ajax({
                  url: '{{ url("/ajax/columnas_tabla") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tabla:tabla,arrastrable: true},
                  success: function(response){
                      console.log("ajaxObtenerColumnas subcampo: "+subcampo);
                      objeto.find(".campo-draggable-columnas").html(response);

                      if(para=="checkbox"){
                        eventoArrastrarColumna();
                        activarDroppableColumnValue(subcampo);
                        activarDroppableColumnOption(subcampo);
                      }else{
                        //Activar las columnas arrastrables
                        eventoArrastrarColumna();
                        activarDroppableColumnValue(subcampo);
                        activarDroppableColumnOption(subcampo);
                        activarDroppableColumnaBusqueda(subcampo);
                        //activarDroppableCamposConcatenados();
                        activarDroppableCamposRetorno(subcampo);
                        activarDroppableCampoIdentificador(subcampo);
                        campo_habilitar_concatenado();
                      }
                      
                  
                  }
          });
      }

      function ajaxCargarEjemploDropdown(tipo_input="",tabla="",value="",option="",label="",name=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,tabla:tabla,value: value,option:option,label:label,name:name},
                  success: function(response){
                      
                    $("body").find(".previsualizacion").html(response);
                  
                  }
          });
      }

       function ajaxCargarEjemploSelect2(tipo_input="",tabla="",buscar_en="",retornar="",designar_principal="",label="",name="",campos_concatenados=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',
                          tipo_input:tipo_input,
                          tabla:tabla,
                          buscar_en: buscar_en,
                          retornar: retornar,
                          principal: designar_principal,
                          label:label,
                          name:name,
                          campos_concatenados:campos_concatenados},
                  success: function(response){
                      
                  $("body").find(".previsualizacion").html(response);
                  
                  }
          });
      }
      function ajaxCargarEjemploRadio(tipo_input="",label="",name="",opciones=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,opciones:opciones,label:label,name:name},
                  success: function(response){
                    $("body").find(".previsualizacion").html(response);
                  }
          });
      }
      function ajaxCargarEjemploDate(tipo_input="",label="",name="",formato=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,formato_fecha:formato,label:label,name:name},
                  success: function(response){
                    $("body").find(".previsualizacion").html(response);
                  }
          });
      }
      function ajaxCargarEjemploDatetime(tipo_input="",label="",name="",formato=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,formato_fecha:formato,label:label,name:name},
                  success: function(response){
                    $("body").find(".previsualizacion").html(response);
                  }
          });
      }
      function ajaxCargarEjemploText(tipo_input="",label="",name="",placeholder=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,placeholder:placeholder,label:label,name:name},
                  success: function(response){
                    $("body").find(".previsualizacion").html(response);
                  }
          });
      }
      function ajaxCargarEjemploEmail(tipo_input="",label="",name="",placeholder=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,placeholder:placeholder,label:label,name:name},
                  success: function(response){
                    $("body").find(".previsualizacion").html(response);
                  }
          });
      }
      function ajaxCargarEjemploFile(tipo_input="",label="",name="",formatos="",file_size=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,label:label,name:name,formatos:formatos,file_size:file_size},
                  success: function(response){
                    $("body").find(".previsualizacion").html(response);
                  }
          });
      }
      function ajaxCargarEjemploCheckbox(tipo_input="",label="",name="",valores="",textos=""){
          $.ajax({
                  url: '{{ route("previsualizacion") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',tipo_input:tipo_input,label:label,name:name,valores:valores,textos:textos},
                  success: function(response){
                    $("body").find(".previsualizacion").html(response);
                  }
          });
      }

      function previsualizacionDropdown(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let table = $(obj).find('.tabla_dropdown').val();
        let name = $(obj).find('[name="name[]"]').val();
        let value = $(obj).find('.valor_columna_dropdown').val();
        let option = $(obj).find('.opcion_columna_dropdown').val();
        if (label && name && value && option && table) {
            ajaxCargarEjemploDropdown("dropdown",table,value,option,label,name);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionSelect2(obj){ // busqueda en un sólo objeto de configuración
        let label = $(obj).find('[name="label[]"]').val();
        let table = $(obj).find('.tabla_fuente').val();
        let name = $(obj).find('[name="name[]"]').val();
        let buscarPor = $(obj).find('.campos_busqueda').val();
        let camposRespuesta = $(obj).find('.campos_respuesta').val();
        let campos_concatenados = $(obj).find(".campos_concatenados").val();
        let principal = $(obj).find('.principal').val();
        if (label && name && table && buscarPor && camposRespuesta && principal && campos_concatenados) {
           ajaxCargarEjemploSelect2("select2",table,buscarPor,camposRespuesta,principal,label,name,campos_concatenados);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionRadio(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let name = $(obj).find('[name="name[]"]').val();
        let opciones = $(obj).find('.opciones_radio').val();
        if (label && name && opciones) {
            ajaxCargarEjemploRadio("radio",label,name,opciones);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionDate(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let name = $(obj).find('[name="name[]"]').val();
        let formato = $(obj).find('.formato-fecha').val();
        if (label && name && formato) {
            ajaxCargarEjemploDate("date",label,name,formato);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionTime(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let name = $(obj).find('[name="name[]"]').val();
        let formato = $(obj).find('.formato-fecha').val();
        if (label && name && formato) {
            ajaxCargarEjemploDatetime("time",label,name,formato);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionDatetime(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let name = $(obj).find('[name="name[]"]').val();
        let formato = $(obj).find('.formato-fecha').val();
        if (label && name && formato) {
            ajaxCargarEjemploDatetime("datetime",label,name,formato);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionText(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let name = $(obj).find('[name="name[]"]').val();
        let placeholder = $(obj).find('.input-text').val();
        if (label && name && placeholder) {
            ajaxCargarEjemploText("text",label,name,placeholder);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionEmail(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let name = $(obj).find('[name="name[]"]').val();
        let placeholder = $(obj).find('.input-text').val();
        if (label && name && placeholder) {
            ajaxCargarEjemploEmail("email",label,name,placeholder);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionFile(obj){
        let label = $(obj).find('[name="label[]"]').val();
        let name = $(obj).find('[name="name[]"]').val();
        let tipos_archivos = $(obj).find('.file_type').val();
        let file_size = $(obj).find('.file_size').val();


        let selected = [];
        $(obj).find('.file_type:checked').each(function () {
          selected.push($(this).val());
        });


        if (label && name && selected.length>0) {
            ajaxCargarEjemploFile("file",label,name,selected,file_size);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }
      function previsualizacionCheckbox(obj){
        let name = $(obj).find('[name="name[]"]').val();
        let label = $(obj).find('[name="label[]"]').val();
        let valores = $(obj).find(".valores_checkbox").val();
        let textos = $(obj).find(".textos_checkbox").val();

        if (name && valores && textos) {
            ajaxCargarEjemploCheckbox("checkbox",label,name,valores,textos);
        }else{
            alert("Por favor llena todos los campos para poder ver la previsualización");
        }
      }

      

      function eventoClickPrevisualizar(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input"); // contenedor de configuración
            previsualizacionDropdown(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarSelect2(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionSelect2(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarRadio(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionRadio(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarDate(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionDate(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarTime(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionTime(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarDatetime(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionDatetime(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarText(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionText(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarEmail(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionEmail(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarFile(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionFile(obj); // VARÍA
        });
      }
      function eventoClickPrevisualizarCheckbox(){
        $('.previsualizar-btn').off();
        $('.previsualizar-btn').click(function(){
            var obj = $(this).closest(".configuracion-input");
            previsualizacionCheckbox(obj); // VARÍA
        });
      }


      function activarDroppableColumnValue(subcampo=false){
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
                    if(subcampo){
                      droppedItem.find(".input-group").append('<input type="text" name="valor_columna_dropdown" class="valor_columna_dropdown form-control" value="'+value+'" readonly>');
                    }else{
                      droppedItem.find(".input-group").append('<input type="text" name="inputs['+indexInput($(this))+'][valor_columna_dropdown]" class="valor_columna_dropdown form-control" value="'+value+'" readonly>');
                    }
                    
                    $(this).html(droppedItem); // Lo agregamos al área droppable 
                    arreglaIndexInputs();      
              }
            });
      }
      function activarDroppableColumnOption(subcampo=false){
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
                     if(subcampo){
                      droppedItem.find(".input-group").append('<input type="text" name="opcion_columna_dropdown" class="opcion_columna_dropdown form-control" value="'+value+'" readonly>');
                     }else{
                      droppedItem.find(".input-group").append('<input type="text" name="inputs['+indexInput($(this))+'][opcion_columna_dropdown]" class="opcion_columna_dropdown form-control" value="'+value+'" readonly>');
                     }
                    
                    $(this).html(droppedItem); // Lo agregamos al área droppable      
                    arreglaIndexInputs(); 
              }
            });
      }
      function activarDroppableTabla(subcampo=false){
            $( ".drop-tabla").off();
            $( ".drop-tabla").droppable({
              accept:'.conjunto-arrastrable-tabla',
              addClasses: false,
              drop: function( event, ui ) {
                  
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });
                    let value = ui.draggable.find("select").val();
                    console.log("valor de tabla: "+value);
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-outline-success");
                    droppedItem.find("select").remove();
                    droppedItem.find(".seleccionar-tabla").remove();
                     if(subcampo){
                        droppedItem.append('<input type="text" name="tabla_fuente" class="tabla_fuente form-control" value="'+value+'" readonly>');
                     }else{
                        droppedItem.append('<input type="text" name="inputs['+indexInput($(this))+'][tabla_fuente]" class="tabla_fuente form-control" value="'+value+'" readonly>');
                     }
                    
                    $(this).html(droppedItem); // Lo agregamos al área droppable       
              }
            });
      }
      function activarDroppableColumnaBusqueda(subcampo=false){
            $( ".drop-campos-busqueda").off();
            $( ".drop-campos-busqueda").droppable({
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
                    droppedItem.addClass("mt-3");
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("buscar por");
                    droppedItem.find("select").remove();
                    
                    // Identificar si es subcampo
                    if(subcampo){
                      droppedItem.find(".input-group").append('<input type="text" name="buscar_en" class="buscar_en form-control" value="'+value+'" readonly>');
                     }else{
                      droppedItem.find(".input-group").append('<input type="text" name="inputs['+indexInput($(this))+'][buscar_en]" class="buscar_en form-control" value="'+value+'" readonly>');
                     }
                    
                    
                    // concatenación
                    droppedItem.find(".input-group").append('<button type="button" class="btn btn-warning concatenado purple" data-concatenado="purple"><i class="lni lni-link"></i></button>');                
                    if($(this).find(".campos_concatenados").length>0){
                       let current_val = $(this).find(".campos_concatenados").val();
                       let new_val = $(this).find(".campos_concatenados").val(current_val+",concat:1:"+value);
                    }else{
                      if(subcampo){
                        droppedItem.find(".input-group").append('<input type="hidden" name="campos_concatenados" class="form-control campos_concatenados" value="concat:1:'+value+'" readonly>');
                      }else{
                        droppedItem.find(".input-group").append('<input type="hidden" name="inputs['+indexInput($(this))+'][campos_concatenados]" class="form-control campos_concatenados" value="concat:1:'+value+'" readonly>');
                      }
                    }
                    // concatenación

                    // IMPORTANTE Definición de los campos que buscarán valores
                    if($(this).find(".campos_busqueda").length>0){
                       let current_val = $(this).find(".campos_busqueda").val();
                       let new_val = $(this).find(".campos_busqueda").val(current_val+","+value)
                    }else{
                       if(subcampo){
                          droppedItem.find(".input-group").append('<input type="hidden" name="campos_busqueda" class="form-control campos_busqueda" value="'+value+'" readonly>');
                       }else{
                          droppedItem.find(".input-group").append('<input type="hidden" name="inputs['+indexInput($(this))+'][campos_busqueda]" class="form-control campos_busqueda" value="'+value+'" readonly>');
                       }                      
                    }

                    $(this).append(droppedItem); // Lo agregamos al área droppable      
                    
                    // sólo si concatenar-habilitado
                    eventoClickConcatenado(); 
              }
            });
      }


      function activarDroppableCamposRetorno(subcampo=false){
            $( ".drop-campos-respuesta").off();
            $( ".drop-campos-respuesta").droppable({
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
                    droppedItem.addClass("mt-3");
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("Retornar");
                    droppedItem.find("select").remove();

                    //Identificar si es subcampo
                    if(subcampo){
                      droppedItem.find(".input-group").append('<input type="text" name="respuesta" class="respuesta form-control" value="'+value+'" readonly>');
                    }else{
                      droppedItem.find(".input-group").append('<input type="text" name="inputs['+indexInput($(this))+'][respuesta]" class="respuesta form-control" value="'+value+'" readonly>');
                    }
                    
                    
                    // IMPORTANTE
                    if($(this).find(".campos_respuesta").length>0){
                       let current_val = $(this).find(".campos_respuesta").val();
                       let new_val = $(this).find(".campos_respuesta").val(current_val+","+value)
                    }else{
                      if(subcampo){
                        droppedItem.find(".input-group").append('<input type="hidden" name="campos_respuesta" class="form-control campos_respuesta" value="'+value+'" readonly>');
                      }else{
                        droppedItem.find(".input-group").append('<input type="hidden" name="inputs['+indexInput($(this))+'][campos_respuesta]" class="form-control campos_respuesta" value="'+value+'" readonly>');
                      }
                      
                    }

                    $(this).append(droppedItem); // Lo agregamos al área droppable       
              }
            });
      }
       function activarDroppableCampoIdentificador(subcampo=false){ // param select2
            $( ".drop-campo-identificador").off();
            $( ".drop-campo-identificador").droppable({
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
                    droppedItem.addClass("mt-3");
                    droppedItem.find(".handle").html('<i class="lni lni-checkmark-circle"></i>');
                    droppedItem.find(".handle").removeClass("btn-primary").addClass("btn-success");
                    droppedItem.find(".title").removeClass("btn-outline-dark").addClass("btn-outline-success").html("principal");
                    droppedItem.find("select").remove();

                    //Identificar subcampo
                    if(subcampo){
                      droppedItem.find(".input-group").append('<input type="text" name="principal" class="principal form-control" value="'+value+'" readonly>');
                    }else{
                      droppedItem.find(".input-group").append('<input type="text" name="inputs['+indexInput($(this))+'][principal]" class="principal form-control" value="'+value+'" readonly>');
                    }
                    
                    
                  
                    $(this).html(droppedItem); // Lo agregamos al área droppable       
              }
            });
      }


      // function eventoArrastrarColumna(){
      //   console.log($("body").find(".conjunto-arrastrable"));
      //   $("body").find(".conjunto-arrastrable").off();
      //   $("body").find(".conjunto-arrastrable").draggable({
      //         handle: ".handle",
      //         helper: function(event) {
      //           var original = $(this);
      //           var clone = original.clone().css({
      //               width: original.outerWidth()-30,
      //               height: original.outerHeight()
      //           })
      //           return clone;
      //         },
      //         revert: "invalid"
      //   });
      // }
      function eventoArrastrarColumna() {
      
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

      function eventoArrastrarTabla(){

        $("body").find(".conjunto-arrastrable-tabla").off();
        $("body").find(".conjunto-arrastrable-tabla").draggable({
              handle: ".handle",
              helper: function(event) {
                var original = $(this);
                var clone = original.clone().css({
                    width: original.outerWidth()-30,
                    height: original.outerHeight()
                })
                return clone;
              },
              revert: "invalid"
        });
      }

      function eventoClickAgregarRadio(subcampo=false){
        // Para agregar input de opción radio y evento eliminar
        $("body").find(".agregar-radio").off();
        $("body").find(".agregar-radio").click(function(){

            var input_group = $(this).closest(".input-group").clone();

            input_group.find(".agregar-radio").removeClass("btn-primary").removeClass("agregar-radio").addClass("btn-danger").addClass("remove").html("x");
            let input = input_group.find(".append-input");
            let value = input.val();
            input.attr("readonly",true);
            let conf_contenedor = $(this).closest(".configuracion-input");

            conf_contenedor.find(".opciones-radio").append(input_group);
            agregarEArregloInput(conf_contenedor.find('.opciones_radio'), value);
            if(subcampo){
              conf_contenedor.find('.opciones_radio').attr("name","opciones_radio");
            }else{
              conf_contenedor.find('.opciones_radio').attr("name","inputs["+indexInput(conf_contenedor)+"][opciones_radio]");
            }
            
            arreglaIndexInputs();
            conf_contenedor.find(".remove").click(function(){
                let contenedor_opciones = $(this).closest(".");
                let new_group = $(this).closest(".input-group");
                let value = new_group.find(".append-input").val();
       
                eliminarEArregloInput(contenedor_opciones.find('.opciones_radio'), value);
                $(this).closest(".input-group").remove();
                
            })
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

      function eventoClickSeleccionarTabla(es_subcampo=false){
        $(".seleccionar-tabla").off();
        $(".seleccionar-tabla").click(function(){
            console.log("eventoClickSeleccionarTabla es_subcampo: "+es_subcampo);
            let tabla_contenedor = $(this).closest(".seleccion-tabla");
            let tabla = tabla_contenedor.find('.tabla-form-creator').val();
            var index = $(this).closest(".configuracion-input").index('.configuracion-input');
            console.log("lenght: "+$(this).closest(".configuracion-input").index())
            console.log($(this).closest(".configuracion-input"));
            console.log($("body").find(".configuracion-input"));
            if(es_subcampo){
              tabla_contenedor.find('.tabla-form-creator').attr("name",'tabla_dropdown');
            }else{
              tabla_contenedor.find('.tabla-form-creator').attr("name",'inputs['+index+'][tabla_dropdown]');
            }
            
            
            ajaxObtenerColumnas(tabla_contenedor,tabla,"",es_subcampo);
            arreglaIndexInputs();
        });
      }

      function agregarEArregloInput(inputSelector, valueToAdd){
          var input = $(inputSelector);
          var currentValues = input.val().split(',').map(v => v.trim()).filter(v => v !== ""); // Limpiar valores vacíos
          input.attr("name",'inputs['+indexInput()+'][opciones_radio]');
          if (!currentValues.includes(valueToAdd)) {
              currentValues.push(valueToAdd);
              input.val(currentValues.join(',')); // Sin espacios extra
          }
      }

      function eliminarEArregloInput(inputSelector, valueToRemove){
          var input = $(inputSelector);
          var currentValues = input.val().split(',').map(v => v.trim()); // Limpiar espacios
          
          var newValues = currentValues.filter(v => v !== valueToRemove); // Filtrar el valor a eliminar
          input.val(newValues.join(',')); // Sin espacios extra
      }

      function indexInput(obj=""){
        let conteo = $(obj).closest(".configuracion-input").index();
        console.log("conteo de configuracion-input: "+conteo);
        return conteo-2; // porque hay dos elementos extras en .campos_configuracion 
      }
      function campo_habilitar_concatenado(){
        $(".concatenar-habilitado").off();
        $(".concatenar-habilitado").change(function() {
          let isChecked = $(this).prop("checked");
          //console.log(isChecked);
          $(this).prop("checked", !isChecked);
        });
      }
      function arreglaIndexInputs(){

        $(".configuracion-input").each(function(index,element){
              $(element).find('input').each(function(i, input) {
                  let $input = $(input); // Convierte el input a un objeto jQuery
                  let name = $input.attr('name'); // Obtiene el valor del atributo "name"

                  // Verifica si el atributo "name" contiene la palabra "inputs" y un número entre corchetes
                  if (name && name.includes('inputs') && name.match(/\[\d+\]/)) {
                      // Reemplaza el número entre corchetes por el índice del contenedor
                      let nuevoName = name.replace(/\[\d+\]/, '[' + index + ']');
                      $input.attr('name', nuevoName); // Actualiza el atributo "name"
                  }
              });
        });

      }

      function removeConfigInput(){
        $(".remove-conf-input").off();
        $(".remove-conf-input").click(function(){
          $(this).closest(".configuracion-input").slideUp(1000,function(){
            $(this).remove();
            arreglaIndexInputs();
          });
        })
      }

      

      function select2TablaModuloEnlazarCheckbox(select2Obj){
        $(select2Obj).select2({
                placeholder: 'Selecciona una tabla',    
                 width: '100%',       
                ajax:{
                    type: "post",
                    dataType: "json",
                    url: "/select2/tablas_modulos",
                    data: function (params){
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
                        console.log("valores del select2");
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
        $(select2Obj).on('select2:select', function (e) {
          console.log("Tabla seleccionada");
          console.log(e.params.data.id);
          // Cuando seleccionas una tabla se tiene que esconder la sección de configuración
          // Mostrar un dropdown de columnas de esa tabla
          ajaxObtenerColumnas(select2Obj.closest(".contenedor-tablas-disponibles"),e.params.data.id,"checkbox");
        });
      }

      function ajaxRenderizarCampos(tabla=""){
         $.ajax({
                  url: '{{ url("/ajax/renderInputs") }}',
                  method: "post",
                  data: {_token:'{{csrf_token()}}',id: tabla},
                  success: function(response){
                      $(".contenedor_campos").html(response);
                      eventoClickAgregarCampo();
                  }
          });
      }      

      function eventoEnlazarCheckbox(){
        $('.enlazar-checkbox-btn').off();
        $('.enlazar-checkbox-btn').change(function() {
            console.log("cambió el enlazar checkbox");
            var parent = $(this).closest(".form-switch");
            var input_container = $(this).closest(".configuracion-input");
            if ($(this).is(':checked')) {
                console.log("está checado");
                parent.find(".checkbox-enlazado").val("true");
                input_container.find(".contenedor-tablas-disponibles").removeClass("d-none");
                input_container.find(".seccion-drop").removeClass("d-none");
                input_container.find(".info-no-enlazable").addClass("d-none");
            } else {
                console.log("no está checado");
                parent.find(".checkbox-enlazado").val("false");
                input_container.find(".contenedor-tablas-disponibles").addClass("d-none");
                input_container.find(".seccion-drop").addClass("d-none");
                input_container.find(".info-no-enlazable").removeClass("d-none");
            }
        });
      }

    function eventoClickAgregarCasilla() {
    $(".agregar-casilla").off();
    $(".agregar-casilla").click(function () {
        console.log("Evento click reconocido en agregar-casilla");

        var conf_input = $(this).closest(".configuracion-input");
        var input_group = $(this).closest(".input-group");

        let current_index = conf_input.index() - 2; // Ajuste del índice
        console.log("El index del componente configuracion input es el siguiente: " + current_index);

        // Asignar los name dinámicos
        var valores = conf_input.find(".valores_checkbox").attr('name', 'inputs[' + current_index + '][valores_checkbox]');
        var textos = conf_input.find(".textos_checkbox").attr('name', 'inputs[' + current_index + '][textos_checkbox]');

        // Obtener los valores actuales
        let current_valores = conf_input.find(".valores_checkbox").val();
        let current_textos = conf_input.find(".textos_checkbox").val();

        // Obtener los nuevos valores
        let nuevo_valor = input_group.find(".valor_checkbox").val();
        let nuevo_texto = input_group.find(".texto_checkbox").val();

        // Solo agregar si hay valor y texto
        if (nuevo_valor.trim() !== "" && nuevo_texto.trim() !== "") {
            // Agregar coma si ya hay contenido
            let nuevos_valores = current_valores ? current_valores + "," + nuevo_valor : nuevo_valor;
            let nuevos_textos = current_textos ? current_textos + "," + nuevo_texto : nuevo_texto;

            // Actualizar los inputs hidden
            conf_input.find(".valores_checkbox").val(nuevos_valores);
            conf_input.find(".textos_checkbox").val(nuevos_textos);

            // Agregar el elemento visual 
            var checkbox = '<div class="input-group"><input type="text" value="'+nuevo_valor+'" class="form-control">'+
                          '<input type="text" value="'+nuevo_texto+'" class="form-control"><button type="button" class="btn btn-danger"><i class="lni lni-circle-minus"></i></button></div>'
            conf_input.find(".opciones-checkbox").append(checkbox);

            // Aquí puedes clonar si lo deseas
            alert("Casilla agregada correctamente. Aquí se puede clonar la interfaz si lo deseas.");
        } else {
            alert("Por favor, completa tanto el texto como el valor del checkbox.");
        }
    });
}

// Config de tabla en formulario no enlazado
let tablaFueEnviada = false;
function loaderColumnasDB(heading,desc,type){
   $.ajax({
    url:'/loader',
    type:'POST',
    data:{_token: '{{csrf_token()}}',heading:heading,descripcion:desc,type:type},
      success:function(response){
        $(".contenido_config_cols").addClass("d-none");
        $(".contenido_preloader").html(response);
    }
  });
}
function convertirLlave(cadena) {
    if (!cadena.includes(".")) return cadena;

    const [primera, segunda] = cadena.split(".");
    return `modulo_${primera}_${segunda}`;
}
function llavesForaneasMultiItem() {
  // Recolectar valores por índice
  var valores = {}; // Aquí irá algo como {0: "valor1", 1: "valor2", ...}

  $(".contenido_config_cols").find('.llave-foranea-multi-item').each(function(index, el) {
    let input_index = $(el).attr("data-input-index"); // por ejemplo "0", "1"
    let value = $(el).val();
    valores[input_index] = value; // Aquí sí usamos input_index como clave
  });

  // Iterar sobre cada .configuracion-input y agregar input hidden
  $('.configuracion-input').each(function(index, el) {
    if (valores[index] !== undefined) {
      $(el).prepend('<input type="hidden" name="inputs[' + index + '][llave_foranea]" value="' + convertirLlave(valores[index]) + '">');
    }
  });
}


function eventoEnviarColumnasDB(){
    // Submit formulario de modal
    $("#crear_tabla_con_formulario").on("submit", function(e){
      e.preventDefault(); // prevenir envío por defecto
      loaderColumnasDB("Creando nueva tabla","Se está creando una nueva tabla en la base de datos","loading");

      $.ajax({
          url: "{{ route('modal_crear_tabla') }}",
          type: "POST",
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: $(this).serialize(),
          success: function(response){
              console.log(response);
              setTimeout(() => {
                  loaderColumnasDB("Tabla creada","Nueva tabla agregada a la base de datos.","complete")
                  
              }, 2000);

              tablaFueEnviada = true;
              // Submit de evento de formulario
              llavesForaneasMultiItem();
              $('#guardar_formulario').submit();

          },
          error: function(xhr){
              console.error("Error:", xhr.responseText);
          }
      });
  });

}

function submitFormularioModal(){
  $(".generar-tabla-db").click(function(){
      $("#crear_tabla_con_formulario").submit(); 
  });
}

function ajaxTiposDatosDropdown(name,index,tabla_asociada="",callback){
  $.ajax({
    url:'{{ route("ajax.tipos_datos") }}',
    type:'POST',
    data:{_token: '{{csrf_token()}}',
          name:name,
          index:index,
          tabla: tabla_asociada
        },
      success:function(response){
        callback(response);
    }
  });
}

function agregarColumnasFormulario() {
    $(".campos_agregados").html("");

    let nombre_tabla = $("#nombre_documento").val(); // Nombre de la tabla padre
    let contenidoPadre = "";
    let contenidoHijasPorTabla = {};
    let peticiones = [];
    let columnas_padre = [];

    // 1. Inputs padre
    $("body").find(".configuracion-input:not(.subcampo)").each(function(index, el) {
        let name = $(el).find('input[name="name[]"]').val();
        if (!name) return;
        columnas_padre.push(name);
        peticiones.push(new Promise(resolve => {
            ajaxTiposDatosDropdown(name, index, nombre_tabla, function(html) {
                contenidoPadre += html;
                resolve();
            });
        }));
    });

    // 2. Inputs hijo (multi-item)
    $("body").find(".configuracion-input").each(function(index, el) {

        // si es un tipo multi-item
        if($(el).hasClass('subcampo')){
          let tabla_hija = $(el).find('input[name$="[tabla_hija]"]').val();
          if (!tabla_hija) {
              console.warn("No se encontró el nombre de tabla hija");
              return;
          }

            let opciones = `<option value="${nombre_tabla}.id">id_default</option>`;
            columnas_padre.forEach(col => {
                opciones += `<option value="${nombre_tabla}.${col}">${nombre_tabla}.${col}</option>`;
            });

          let contenedorId = `contenedor_hija_${index}`;
          contenidoHijasPorTabla[contenedorId] = `
              <tr class="table-active">
                <td colspan="5" class="fw-bold text-success">
                  Configuración de tabla hija: ${tabla_hija}
                  </td>
                  <td class="text-end text-muted fw-bold pt-2">Asociar con</td>
                  <td colspan="2">
                  <select name="campos[${tabla_hija}][${index}][llave_foranea_padre]" class="form-select form-select-sm llave-foranea-multi-item" data-input-index="${index}">
                      ${opciones}
                  </select>
              </td>
              </tr>
          `;

        let subcampos = $(el).find('input[name$="[name]"]');
        if (subcampos.length > 0) {
            subcampos.each(function(i) {
                let nombre = $(this).val();
                if (!nombre) return;

                peticiones.push(new Promise(resolve => {
                    ajaxTiposDatosDropdown(nombre, i, tabla_hija, function(html) {
                        contenidoHijasPorTabla[contenedorId] += html;
                        resolve();
                    });
                }));
            });
        }
      }
    });

    // 3. Esperar todas las peticiones AJAX y luego renderizar todo
    Promise.all(peticiones).then(() => {
        $(".campos_agregados").append(`
            <tr class="table-active">
                <td colspan="9" class="fw-bold text-primary">
                    Configuración de tabla: ${nombre_tabla}
                </td>
            </tr>
        `);
        $(".campos_agregados").append(contenidoPadre);

        for (const contenedor in contenidoHijasPorTabla) {
            $(".campos_agregados").append(contenidoHijasPorTabla[contenedor]);
        }
        eventoEsForanea();
    });

    // Refrescar nombre del archivo
    $(".nombre_archivo").val($("#nombre_documento").val());
}




// Antes de enviar configurar el formulario
// 1. Mostrar modal de configuración
function previoAEnvio(){
   
 
   $('#guardar_formulario').on('submit', function(event){

    if(!tablaFueEnviada){
        event.preventDefault();
        if($("#enlazarTabla").is(':checked')){
         //alert("No deberíamos mostrar el formulario de configuración");
            tablaFueEnviada = true;
           // $(this).submit(); // Esto volverá a ejecutar el evento, pero ya no lo bloqueará
          return;
        }
        agregarColumnasFormulario();
        var modal = new bootstrap.Modal(document.getElementById('miModalFormulario'));
        modal.show();
        return;
    }
   
   });
  
}

function eventoEsForanea(){
  $('.checkbox-foranea').off();
  $('.checkbox-foranea').on('change', function() {
    if ($(this).is(':checked')) {
      console.log("es foranea");
      var tabla = $(this).closest("tr").find(".on_table").val();
      var index = $(this).closest("tr").find(".on_table").attr("data-index");
      var main = $(this).closest("tr").find(".on_table").attr("data-main");
      var obj = $(this).closest("tr").find(".on_row");
      ajaxColumnasTabla(tabla,obj,index,main);

    }
  });

  $('.on_table').off();
  $('.on_table').on('change', function () {
    var tabla = $(this).val();
    var index = $(this).attr("data-index");
    var main = $(this).attr("data-main");
    var obj = $(this).closest("tr").find(".on_row");
    ajaxColumnasTabla(tabla,obj,index,main);
});
}

function ajaxColumnasTabla(tabla, append_on,index="",main=""){

      $.ajax({
       url: '/ajax/columnas_tabla', // Ajusta esta URL
                method: 'POST',
                data: {
                    _token:'{{csrf_token()}}', // CSRF para Laravel
                    tabla: tabla,
                    only_columnas:true,
                    index: index,
                    main:main,
                    multi_item: true,
                    multi_item_index: index,
                    multi_item_tabla: main
                },
                success: function(response) {
                    console.log('encontramos las siguientes columnas:', response);
                    // Necesitamos
                    $(append_on).html(response);
                }
      });
}

      // function pruebaFormulario(){
      //   $('#guardar_formulario').on('submit', function(event) {
      //       event.preventDefault();
      //       let isChecked = $('[name="enlazar_tabla"]').prop('checked'); // Retorna true o false
      //       console.log(isChecked ? "Activado" : "Desactivado"); 
      //       // let nombre = $('input[name="nombre"]').val();
      //       // if (nombre === '') {
      //       //     event.preventDefault(); // Evita el envío si el campo está vacío
      //       //     alert('Por favor, llena el campo antes de enviar.');
      //       // }
      //   });
      // }
      // pruebaFormulario();

      eventoEnlazarTabla();
      select2TablaModulo();
      previoAEnvio(false);
      eventoEnviarColumnasDB();
      submitFormularioModal();
      guardarSubcampo();

    

      ajaxSeleccionInputType();
      @stack('funciones_editar')




      });
    </script>
</body>
</html>