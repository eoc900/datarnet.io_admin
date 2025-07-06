<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
      
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
    <script>
        $(document).ready(function(){
            function opcionesGraficas(obj){
                $.ajax({
                        url: '{{ url("/ajax/dropdown_graficas") }}',
                        method: "post",
                        data: {_token:'{{csrf_token()}}'},
                        success: function(response){
                            $(obj).html(response);
                            var index = obj.closest(".graph-box").index();
                            $(obj).prepend('<div class="graph_'+index+'"></div>');
                            $(obj).append('<div class="pt-5" id="area_select2_'+index+'"><label class="form-label">Buscar queries</label></div>');
                            eventoClickAddGraph(index);
                            ajaxSelect2(index);

                        } 
                });
            }

            function eventoClickAddGraph(){
                $(".add-graph").off();
                $(".add-graph").click(function(){
                    var index = $(this).closest(".graph-box").index();
                    var graph = $(this).closest(".input-group").find('[name="tipo_grafica[]"]').val();
                    console.log("graph:"+graph);
                    if(graph=="barchart"){
                            $.ajax({
                            url: '{{ url("/ajax/ejemplo_graficas") }}',
                            method: "post",
                            data: {_token:'{{csrf_token()}}',ejemplo: graph},
                            success: function(response){
                                console.log(response);
                                if (!response.datos || !response.datos.datasets || !response.datos.datasets[0]) {
                                    console.error("Los datos de la gráfica no están en el formato correcto", response);
                                    return;
                                }
                                loadBarChartExample(response.datos,".graph_"+index);
                            } 
                        });
                    }
                    if(graph==="linechart"){
                        console.log("linechart selected ");
                            $.ajax({
                            url: '{{ url("/ajax/ejemplo_graficas") }}',
                            method: "post",
                            data: {_token:'{{csrf_token()}}',ejemplo: graph},
                            success: function(response){
                                console.log(response);
                                if (!response.datos || !response.datos.datasets || !response.datos.datasets[0]) {
                                    console.error("Los datos de la gráfica no están en el formato correcto", response);
                                    return;
                                }
                                
                                loadLineChartExample(response.datos,".graph_"+index)
                            } 
                        });
                    }
                    if(graph=="piechart"){
                                $.ajax({
                                url: '{{ url("/ajax/ejemplo_graficas") }}',
                                method: "post",
                                data: {_token:'{{csrf_token()}}',ejemplo: graph},
                                success: function(response){
                                    console.log(response);
                                    if (!response.datos || !response.datos.datasets || !response.datos.datasets[0]) {
                                        console.error("Los datos de la gráfica no están en el formato correcto", response);
                                        return;
                                    }
                                    loadPieChartExample(response.datos,".graph_"+index);
                                    $(".graph_"+index).append("");
                                } 
                            });
                    }
                    if(graph=="areachart"){
                                $.ajax({
                                url: '{{ url("/ajax/ejemplo_graficas") }}',
                                method: "post",
                                data: {_token:'{{csrf_token()}}',ejemplo: graph},
                                success: function(response){
                                    console.log(response);
                                    if (!response.datos || !response.datos.datasets || !response.datos.datasets[0]) {
                                        console.error("Los datos de la gráfica no están en el formato correcto", response);
                                        return;
                                    }
                                    loadAreaChartExample(response.datos,".graph_"+index)
                                } 
                            });
                    }
                    });
            }

            function ajaxSelect2(index){
                $.ajax({
                    url: '/ajax/campo_select2',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id:"select2_"+index,placeholder:"Buscar queries",name:"query_name[]"},
                    success: function(response){
                            $("#area_select2_"+index).append(response);
                            activarSelect2(index);
                    }
                });
            }

            function activarSelect2(index){
                console.log($('#select2_'+index));
                 $('#select2_'+index).select2({
                    placeholder: "Buscar query",
                    ajax:{
                        type: "post",
                        dataType: "json",
                        url: "/select2/queries", 
                        data: function (params) {
                            var query = {
                                search: params.term,
                                _token: '{{csrf_token()}}',
                                type: 'public',
                            }

                            // Query parameters will be ?search=[term]&type=public
                            return query;
                        },
                        processResults: function (data) {
                            // Transforms the top-level key of the response object from 'items' to 'results'
                            console.log(data);
                                return {
                                        results: $.map(data, function (item) {
                                            return {
                                                text: item.nombre,
                                                id: item.id,
                                                nombre: item.nombre
                                            }
                                        })
                                }
                        }
                    }
                });
                // Evento change
                $('#select2_'+index).on('select2:select', function (e) {
                    let query = e.params.data.nombre;
                    let id = e.params.data.id;
                    let chart = $("body").find(".indicator-section").eq(index).find('[name="tipo_grafica[]"]').val();
                    console.log(query);
                    console.log(id);
                    console.log(chart);
                    // Traer estado de emparejamiento de query
                        // Una columna va estar en labels y otra va a estar en los valores
                    //ajaxDataQuery(id,chart,index);
                    ajaxDataQuery2(id,chart,index);
                    
                });
            }

            function ajaxDataQuery(id,chart="",index=0){
                $.ajax({
                    url: '/ajax/data_graficas',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id:id,chart:chart},
                    success: function(response){
                          if(response.chart=="areachart"){
                                loadAreaChartExample(response.resultados,".graph_"+index);
                          }
                    }
                });
            }

            function ajaxDataQuery2(id=0,chart="",index=0){
                console.log("AjaxDataQuery2");
                $.ajax({
                    url: '/ajax/query_graph',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id:id,tipo_grafica:chart},
                    success: function(response){
                        console.log(response);

                        if(response.tipo_grafica=="linechart"){
                            loadLineChartExample(response.datos,".graph_"+index);
                        }
                        if(response.tipo_grafica=="areachart"){
                            loadAreaChartExample(response.datos,".graph_"+index);
                        }
                        if(response.tipo_grafica=="piechart"){
                            loadPieChartExample(response.datos,".graph_"+index);
                        }
                        if(response.tipo_grafica=="barchart"){
                            loadBarChartExample(response.datos,".graph_"+index);
                        }
                    }
                });
            }


            function eventoClickAgregarIndicador(){
                $(".agregar-indicador").click(function(){
                        let amplitud = $("body").find('[name="amplitud"]').val();
                        let elemento = '<div class="'+amplitud+' graph-box p-3"><div class="card"><div class="card-body indicator-section"></div></div></div>';
                        $("body").find(".contenedor-seleccion").append(elemento);
                        opcionesGraficas($("body").find(".indicator-section").last());
                });
            }
 
            eventoClickAgregarIndicador();
            
           
            
            @stack('funciones_graficas')
        });
    </script>
</body>
</html>