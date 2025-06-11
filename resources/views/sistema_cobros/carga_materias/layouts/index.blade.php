<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
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

            function tablaInscripciones(id_alumno){

                $.ajax({
                    url: '{{ url("/add_multiple/tabla_inscripciones") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',alumno:id_alumno},
                    success: function(response){
                        console.log(response);
                        $(".tabla_inscripciones").html(response);
                        eventoCargarClickMateria();
                        eventoAgregarMateria2();

                    }
                });
            }

            
            function renderMultipleInputs(tipoInputs){

                $.ajax({
                    url: '{{ url("/add_multiple/materias_sistema") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id_sistema:"{{ (isset($alumno) && $alumno!=false)?$alumno->id_sistema_academico:""; }}"},
                    success: function(response){
                        console.log(response);
                        $(".contenedor_inputs").append(response);
                        remove_inputs_event();
                    }
                });
            }
            function renderMultipleInputs2(sistema){

                $.ajax({
                    url: '{{ url("/add_multiple/materias_sistema") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id_sistema:sistema},
                    success: function(response){
                        console.log(response);
                        $(".contenedor_inputs").append(response);
                        remove_inputs_event();
                    }
                });
            }
            function remove_inputs_event(){
                $('.remove_inputs').off();
                $('.remove_inputs').click(function(){
                    $(this).closest('.multiple_inputs').remove();
                });
            }

            function eventoAgregarMateria(){
                $('.agregar_materias').off();
                 $('.agregar_materias').click(function(){
                        renderMultipleInputs();
                });
            }
            function eventoAgregarMateria2(){
                $('.agregar_materias').off();
                 $('.agregar_materias').click(function(){
                        renderMultipleInputs2($("#id_sistema").val());
                });
            }
           
            function eventoCargarClickMateria(){
                $(".cargar_materias").off();
                 $(".cargar_materias").click(function(){
                    $(".inscripciones").find("tr.bg-info").removeClass("bg-info");
                    $(this).closest("tr").addClass("bg-info");

                    let periodo = $(this).attr("data-periodo");
                    let inscripcion = $(this).attr("data-inscripcion");
                    $(".periodo_seleccionado").html(periodo);
                    $("#id_inscripcion").val(inscripcion);
                    $("#periodo").val(periodo);
                });
            }

            eventoAgregarMateria();
            eventoCargarClickMateria();
           
            

           
            // Seccion 2 multiple inputs

            
            <x-script-select2 select2="/select2/alumnos" idSelect2="buscarAlumno">
            text: "Alumno: "+item.alumno +" -----> Sistema: "+item.codigo_sistema+" -----> Estatus: "+item.activo,
            id: item.id_alumno,
            </x-script-select2>

             <x-snippet-on-change idChange="buscarAlumno">
                        var id = e.params.data.id;
                        tablaInscripciones(id);
            </x-snippet-on-change>

        });
    </script>
</body>
</html>