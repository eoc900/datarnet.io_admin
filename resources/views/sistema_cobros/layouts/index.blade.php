<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset("dashboard_resources/assets/plugins/input-tags/css/tagsinput.css");}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
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
    <script src="{{  asset("dashboard_resources/https://cdn.jsdelivr.net/npm/flatpickr");}}"></script>
   


    @if (isset($cuentas) && isset($renderSectionID) && $cuentas)
        <x-ajax-html-script :renderSectionID="$renderSectionID" :routeAjaxName="$routeAjaxName" :ajaxCallSuffix="$ajaxCallSuffix" :idCuenta="$cuentas[0]->id" 
            :classOnChange="$classOnChange"/>
    @endif
    
    <script>
        $(document).ready(function(){
   

            if($('#id_cuentas').val()!=undefined || $('#id_cuentas').val()!==""){
                var cuenta = $('#id_cuentas').val();
                renderTablaCargosCuenta(cuenta);
                renderTablaPagosCuenta(cuenta);
            }

            function renderTablaCargosCuenta(cuenta){
                console.log(cuenta);
                $.ajax({
                    url: '{{ url("/ajax/cargosCuenta") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id_cuenta: cuenta},
                    success: function(response){
                        $(".cargos_cuenta").html(response);
                    }
                });
            }

             function renderTablaPagosCuenta(cuenta){
                console.log(cuenta);
                $.ajax({
                    url: '{{ url("/ajax/pagosCuenta") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id_cuenta: cuenta},
                    success: function(response){
                        console.log("Los pagos realizados son:");
                        console.log(response);
                        $(".pagos_cuenta").html(response);
                    }
                });
            }

            $('#id_cuentas').change(function(){
                console.log("seleccionaste una opción.");
                renderTablaCargosCuenta($('#id_cuentas').val());
            });

        });
    </script>
   
    
</body>
</html>