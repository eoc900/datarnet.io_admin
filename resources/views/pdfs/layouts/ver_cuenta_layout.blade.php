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

            function getCuentas(id){
                $.ajax({
                    url: '/ajax/cuentasAlumno',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',id_alumno:id},
                    success:function(response){
                        renderDropdownCuentas(response);
                        eventoDropdownCuenta();
                        previewCuenta($("#cuenta").val());
                    }
                });
            }

            function previewCuenta(id_c,id_a=""){
                $.ajax({
                    url: '/ajax/preview_cuenta',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',id_cuenta:id_c,id_alumno:id_a},
                    success:function(response){
                        renderDocumentCuenta(response);
                    }
                });
            }

            function renderDropdownCuentas(html){
                $(".dropdownCuentas").html(html);
            }
            function renderDocumentCuenta(html){
                $("#preview_cuenta").html(html);
                $('.descargar').removeClass('d-none');
                $('#enviar').removeClass('d-none');
                eventoEnviar();
            }

            function eventoDropdownCuenta(){
                $("#cuenta").off();
                $("#cuenta").change(function(){
                    console.log("Haz seleccionado la cuenta: "+$(this).val());
                    previewCuenta($(this).val());
                });
            }


            function enviarCuenta(id_c){
                $.ajax({
                    url: '/download/envio_cuenta',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',cuenta:id_c},
                    success:function(response){
                        renderDocumentCuenta(response);
                    }
                });
            }

            function eventoEnviar(){
                $('#enviar').off();
                $('#enviar').click(function(){
                    enviarCuenta($('#cuenta').val());
                });
            }
            




            <x-script-select2 select2="/select2/alumnos" idSelect2="buscarAlumno">
            text: "Alumno: "+item.alumno +" -----> Sistema: "+item.codigo_sistema+" -----> Estatus: "+item.activo,
            id: item.id_alumno,
            </x-script-select2>

            <x-snippet-on-change idChange="buscarAlumno">
                        var id = e.params.data.id;
                        console.log("haz seleccionado al alumno: "+id);
                        getCuentas(id);
            </x-snippet-on-change>
        });
    </script>
</body>
</html>