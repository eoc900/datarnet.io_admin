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
                    url: '{{ url("/add_multiple/correos_alumno") }}',
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

            //direccion
            function renderMultipleInputs2(tipoInputs){

                $.ajax({
                    url: '{{ url("/add_multiple/direccion") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        $(".contenedor_inputs_2").append(response);
                        remove_inputs_event();
                    }
                });
            }

            $('.agregar_direccion').click(function(){
                console.log("agregando bloque de formulario...");
                    renderMultipleInputs2();
            });

            //telefono
            function renderMultipleInputs3(tipoInputs){

                $.ajax({
                    url: '{{ url("/add_multiple/telefono") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}'},
                    success: function(response){
                        $(".contenedor_inputs_3").append(response);
                        remove_inputs_event();
                    }
                });
            }

            // correo de bienvenida
            function bienvenida(alumno){
                 $.ajax({
                    url: '{{ url("/enviar_bienvenida") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',alumno: alumno},
                    success: function(response){
                       console.log(response);
                    }
                });
            }
            $('.reenviar_bienvenida').click(function(){
                bienvenida("{{ (isset($alumno))?$alumno->id_alumno:' '; }}");
            });

            $('.agregar_telefono').click(function(){
                console.log("agregando bloque de formulario...");
                    renderMultipleInputs3();
            });

        });
    </script>
</body>
</html>