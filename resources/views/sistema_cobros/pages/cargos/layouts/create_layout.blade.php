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
            <x-script-select2 :select2="$select2" :idSelect2="$idSelect2">
                text: "Alumno: "+item.alumno +" -----> Sistema: "+item.codigo_sistema+" -----> Estatus: "+item.activo,
                id: item.id_alumno,
            </x-script-select2>
        });
    </script>
    
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
                        getCostosConceptos(id,$("#cuenta").val());
                    }
                });
            }

            function getCostosConceptos(alumno,cuenta=""){

                console.log("getCostos ejecutado");
                console.log("cuenta: "+cuenta);
                 console.log("alumno: "+alumno);
                $.ajax({
                    url: '/ajax/costosConceptos',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',id_alumno:alumno,id_cuenta:cuenta},
                    success:function(response){
                        renderDropdownCostos(response);
                    }
                });
            }

            function renderDropdownCuentas(html){
                $(".dropdown_cuentas").html(html);
            }

            function renderDropdownCostos(html){
                $(".dropdown_costos").html(html);
            }

            $("#{{ $idSelect2 }}").change(function(){
                var id_alumno = $(this).val();
                console.log("El id de alumno seleccionado es: "+id_alumno);
                getCuentas(id_alumno);
            });

            function eventoDropdownCuenta(){
                $("#cuenta").off();
                $("#cuenta").change(function(){
                    var id_alumno = $("#{{ $idSelect2 }}").val();
                    var id_cuenta = $("#cuenta").val();
                    getCostosConceptos(id_alumno,id_cuenta);
                });
            
            }

        });
    </script>


</body>
</html>