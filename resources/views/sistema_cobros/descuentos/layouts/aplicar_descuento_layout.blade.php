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
                        console.log($('#cuenta').val());
                        getPagosPendientes($('#cuenta').val());
                        eventoDropdownCuenta();
                        
                    }
                });
            }

            function renderDropdownCuentas(html){
                $(".dropdownCuentas").html(html);
            }

            function getPagosPendientes(id){
                $.ajax({
                    url: '/ajax/pagos_pendientes',
                    type: 'post',
                    data:{_token: '{{csrf_token()}}',id_cuenta:id},
                    success:function(response){
                        $('.checkbox-pagos').html(response);
                        console.log(response);
                    }
                });
            }

            function eventoDropdownCuenta(){
                $("#cuenta").off();
                $("#cuenta").change(function(){
                    getPagosPendientes($('#cuenta').val());
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


             <x-script-select2 select2="/select2/descuentos" idSelect2="buscarDescuento">
                text: "Descuento: "+item.nombre +" -----> Tasa porcentual: "+item.tasa+" -----> Valor fijo: $"+item.monto,
                id: item.id,
            </x-script-select2>

            <x-snippet-on-change idChange="buscarDescuento">
                var id = e.params.data.id;
                console.log("haz seleccionado el descuento "+id);
            </x-snippet-on-change>
   

        });
    </script>

    <script>
        $(document).ready(function(){
            
     
        });
    </script>


</body>
</html>