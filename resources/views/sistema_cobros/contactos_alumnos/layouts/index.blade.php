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

            function renderMultipleInputs(tipoInputs){

                $.ajax({
                    url: '{{ url("/add_multiple/correos_contactos_alumnos") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
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


            $('.agregar_correo').click(function(){
                    renderMultipleInputs();
            });

            // Seccion 2 multiple inputs

            function renderMultipleInputs2(tipoInputs){

                $.ajax({
                    url: '{{ url("/add_multiple/telefono") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        console.log(response);
                        $(".contenedor_inputs_2").append(response);
                        remove_inputs_event();
                    }
                });
            }
            $('.agregar_telefono').click(function(){
                    renderMultipleInputs2();
            });

              // Seccion 3 multiple inputs

            function renderMultipleInputs3(tipoInputs){

                $.ajax({
                    url: '{{ url("/add_multiple/direccion") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        console.log(response);
                        $(".contenedor_inputs_3").append(response);
                        remove_inputs_event();
                    }
                });
            }
            $('.agregar_direccion').click(function(){
                    renderMultipleInputs3();
            });

            <x-script-select2 select2="/select2/alumnos" idSelect2="buscarAlumno">
            text: "Alumno: "+item.alumno +" -----> Sistema: "+item.codigo_sistema+" -----> Estatus: "+item.activo,
            id: item.id_alumno,
            </x-script-select2>

             <x-snippet-on-change idChange="buscarAlumno">
                        var id = e.params.data.id;
                        console.log("haz seleccionado al alumno: "+id);
            </x-snippet-on-change>

        });
    </script>
</body>
</html>