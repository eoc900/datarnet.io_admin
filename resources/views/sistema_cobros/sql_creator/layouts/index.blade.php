<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
     
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">

      
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
     <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
   
    <script>
      $(document).ready(function(){

        function eventoChangeWhereOperator(){
          $(".where_operator").off();
          $(".where_operator").on("change", function(){

          if($(this).val()=="between"){
            var current_num = $(this).closest(".where-group").index();
            console.log("El número de este elemento es: "+current_num);
            console.log($(".valores-where").find(".where_values").eq(current_num));
            var conjuntos_valores = $(".valores-where").find(".where_values").eq(current_num);
            conjuntos_valores.find(".segundo_valor").removeClass("d-none");
            conjuntos_valores.find(".and").removeClass("d-none");
          }else{
            var current_num = $(this).closest(".where-group").index();
            console.log("El número de este elemento es: "+current_num);
            console.log($(".valores-where").find(".where_values").eq(current_num));
            var conjuntos_valores = $(".valores-where").find(".where_values").eq(current_num);
            conjuntos_valores.find(".segundo_valor").addClass("d-none");
            conjuntos_valores.find(".and").addClass("d-none");
          }
           


          });
         

        }

        function eventoRemoverObjetoTabla(){
          $("body").find(".remove-tabla").off();
          $("body").find(".remove-tabla").click(function(){
              $(this).closest(".objeto_tabla").remove();
          });
        }
        function eventoRemoverObjetoColumna(){
          console.log("Quitar objeto de columna");
          console.log($("body").find(".remove-columna"));
          $("body").find(".remove-columna").off();

          $("body").find(".remove-columna").click(function(){
            console.log("Remove columna click reconocido");
              $(this).closest(".objeto_columna").remove();
          });
        }

        function agregarObjetoTabla(name,value){
          if($('[data-tabla="'+value+'"]').length>0){
            console.log();
            console.log('[value="'+value+'"]');
            return;
          }
          var boton = `<div class="input-group mb-3 objeto_tabla" data-tabla="${value}"><input type="text" class="form-control" name="${name}" value="${value}" readonly>
            <button type="button" class="remove-tabla btn btn-danger float-end"><i class="lni lni-close"></i></button></div>`;
            $(".seccion_tablas").append(boton);
            eventoRemoverObjetoTabla();
        }

        function agregarObjetoColumna(name,value){
          if($('[data-columna="'+value+'"]').length>0){
            return;
          }
          var boton = `<div class="objeto_columna"><div class="input-group mb-3" data-columna="${value}"><span class="handle btn btn-info"><i class="fadeIn animated bx bx-move"></i></span><input type="text" class="form-control columna" name="${name}" value="${value}" readonly>
            <button type="button" class="remove-columna btn btn-danger float-end"><i class="lni lni-close"></i></button></div></div>`;
            $(".seccion_columnas").append(boton);
            eventoRemoverObjetoColumna();
          
            // Evento para activar arrastrable
            //$("body").find(".objeto_columna").off();
            $("body").find(".objeto_columna").draggable({
              handle: ".handle",
              helper: "clone",
              revert: "invalid"
            });
          
        }
       
        function activarDroppableJoinLeft(){
            $( ".drop-column-left").droppable({
              accept:'.objeto_columna',
              addClasses: false,
              drop: function( event, ui ) {
                  console.log(ui);
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });

                    $(droppedItem).find(".columna").attr("name","columna_izquierda[]");

                    $(this).append(droppedItem); // Lo agregamos al área droppable

                    ajaxDropdownJoins();
              }
            });
        }

        function activarDroppableColumnaWhere(){

          $( ".columna-where").droppable({
              accept:'.objeto_columna',
              addClasses: false,
              drop: function( event, ui ) {
                  console.log(ui);
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });

                    $(droppedItem).find(".columna").attr("name","columna_where[]");

                    $(this).append(droppedItem); // Lo agregamos al área droppable
                    ajaxDropdownWhereOperators();
                    ajaxWhereValue();
                    if($(".columna-where").length<2){
                        ajaxWhereLogicalOperators("first");
                    }else{
                        ajaxWhereLogicalOperators("and");
                    }
                   
                    
              }
            });
            
        }

        function activarDroppableFuncionesAgregadas(){
             $( ".convertir-columna").droppable({
              accept:'.objeto_columna',
              addClasses: false,
              drop: function( event, ui ) {
                  console.log(ui);
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });

                    var columna = $(droppedItem).find(".columna").val();
                    funcionesAgregadas(columna);

                    // Tenemos que quitar la columna en columnas
                    console.log($("body").find('[data-columna="'+columna+'"]'));
                    let contenedor = $("body").find('[data-columna="'+columna+'"]');
                    contenedor.closest(".objeto_columna").remove();
              }
            });
        }


        function activarGroupby(){

          $( ".agrupaciones").droppable({
              accept:'.objeto_columna',
              addClasses: false,
              drop: function( event, ui ) {
                  console.log(ui);
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });

                    $(droppedItem).find(".columna").attr("name","agrupar_por[]");
                    $(droppedItem).find(".remove-columna").remove();

                    // Agregar la opción de fechas
                    $(droppedItem).find(".input-group").append('<button type="button" class="btn btn-warning funcion_fecha">Aplicar función de fechas</button>')
                   
                    $(this).append(droppedItem); // Lo agregamos al área droppable
                    activarClickFuncionDeFechas();
              }
            });
        }

        function activarClickFuncionDeFechas(){
          $("body").find(".funcion_fecha").off();
          $("body").find(".funcion_fecha").click(function(){
            var contenedor = $(this).closest(".input-group");
            console.log("conteo de name=es_fecha "+contenedor.find('[name="es_fecha[]"]').length);
            if(contenedor.find('[name="es_fecha[]"]').length==0){
                // Obtener el valor de la columna y buscarlo en columnas seleccionadas para borrarlo

                contenedor.append('<input type="hidden" value="true" name="es_fecha[]">');
                ajaxRetornarSelectFuncionFechas(contenedor);
                return;
            }
            if(contenedor.find('[name="es_fecha[]"]').length>0){
                let val = contenedor.find('[name="es_fecha[]"]').val();
                let newVal = (val=="true")?"false":"true";
                
                if(newVal=="false"){
                    contenedor.find('[name="es_fecha[]"]').remove();
                    contenedor.find('.dropdown_funcion_fecha').remove();
                }
            }
           

          });
        }
        function ajaxRetornarSelectFuncionFechas(append_in){
              $.ajax({
                    url: '{{ url("/ajax/selectFuncionFechas") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        $(append_in).append(response);
                    }
            });
        }

        function funcionesAgregadas(columna){ // SUM, AVG, etc.
            $.ajax({
                    url: '{{ url("/ajax/dropdownFuncionesAgregadas") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',columna:columna},
                    success: function(response){
                        $(".convertir-columna").append(response);
                    }
            });
        }



        function ajaxDropdownJoins(){
            $.ajax({
                    url: '{{ url("/ajax/dropdownJoins") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        $(".seccion-dropdowns").append(response);
                    }
            });
        }

        function ajaxDropdownWhereOperators(){
            $.ajax({
                    url: '{{ url("/ajax/dropdownWhereOperators") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        $(".operadores-where").append(response);
                    }
            });
        }

        function ajaxWhereValue(){
            $.ajax({
                    url: '{{ url("/ajax/whereValueInput") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        $(".valores-where").append(response);
                    }
            });
        }

        function ajaxWhereLogicalOperators(op=" "){ {{-- comentario [" ","and","or"] --}}
         
          $.ajax({
                    url: '{{ url("/ajax/dropdownWhereLogicOperators") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',logical: op},
                    success: function(response){
                      console.log("response: "+response);
                        $(".operadores_logicos").append(response);
                          eventoChangeWhereOperator();
                         console.log("operador logico");
                    }
            });
        }



        function activarDroppableJoinRight(){
            $( ".drop-column-right").droppable({
              accept:'.objeto_columna',
              addClasses: false,
              drop: function( event, ui ) {
                  console.log(ui);
                   let droppedItem = ui.helper.clone(); // Clonamos el elemento
                    droppedItem.removeClass("ui-draggable ui-draggable-handle").css({
                        top: "auto",
                        left: "auto",
                        position: "relative"
                    });
                    $(droppedItem).find(".columna").attr("name","columna_derecha[]");
                    $(this).append(droppedItem); // Lo agregamos al área droppable
              }
            });
        }


        function obtenerColumnas(tabla=""){
            $.ajax({
                    url: '{{ url("/ajax/columnas_tabla") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',tabla:tabla},
                    success: function(response){
                        console.log(response);
                        $(".contenedor_columnas").html(response);
                        eventoClickColumna();
                    }
            });
        }

        $(".seleccionar_tabla").click(function(){
            var tabla = $("#opciones_tabla").val();
            console.log(tabla);
            obtenerColumnas(tabla);
            agregarObjetoTabla("tabla[]",tabla);
        });

        function eventoClickColumna(){
          $(".seleccionar_columna").off();
           $(".seleccionar_columna").click(function(){
            var columna = $("#opciones_columnas").val();
            console.log(columna);
            agregarObjetoColumna("columna[]",columna);
        });
        }
       
        activarDroppableFuncionesAgregadas();
        activarDroppableJoinLeft();
        activarDroppableJoinRight();
        activarDroppableColumnaWhere();
        activarGroupby();


      });
    </script>
</body>
</html>