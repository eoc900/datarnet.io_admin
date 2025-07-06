<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
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
        });
    </script>
    
</body>
</html>