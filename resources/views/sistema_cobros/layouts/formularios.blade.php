<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   
    <link href="{{ asset("dashboard_resources/assets/plugins/input-tags/css/tagsinput.css");}}" rel="stylesheet">
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
            @if (isset($select2))
                @switch($select2)
                    @case("/select2/conceptos")
                         <x-script-select2 :select2="$select2" :idSelect2="$idSelect2">
                        text: "Concepto: "+item.codigo_concepto +"| Plantel: "+item.codigo_escuela+" | Periodo de referencia: "+item.periodo+" | Costo: "+item.costo,
                        id: item.id_concepto,
                        costo: item.costo,
                        periodo: item.periodo
                        </x-script-select2>
                        
                    @break
                    @case("/select2/alumnos")
                        <x-script-select2 :select2="$select2" :idSelect2="$idSelect2">
                        text: "Alumno: "+item.alumno +" -----> Sistema: "+item.codigo_sistema+" -----> Estatus: "+item.activo,
                        id: item.id_alumno,
                        </x-script-select2>

                    @break
                    @case("/select2/costos_conceptos")
                        <x-script-select2 :select2="$select2" :idSelect2="$idSelect2">
                        text: "Concepto: "+item.codigo_concepto +" -> Sistema: "+item.codigo_sistema+" -> Periodo: "+item.periodo+" -> Costo: $"+item.costo,
                        id: item.id,
                        </x-script-select2>
                    @break
                
                    @default
                        
                @endswitch
               
            @endif

             @if(isset($select2_2) && isset($idSelect2_2))
                        <x-script-select2 :select2="$select2_2" :idSelect2="$idSelect2_2">
                        text: "Alumno: "+item.alumno +" -----> Cuenta: "+item.cuatrimestre+" -----> Estatus: "+item.activa,
                        id: item.id,
                        periodo: item.cuatrimestre
                        </x-script-select2>

             @endif

             @if(isset($select2_2) && isset($idSelect2_2) && $idSelect2_2=="cuentas")
                        <x-snippet-on-change :idChange="$idSelect2_2">
                            var selectedValue = e.params.data.periodo;
                            
                              $('#periodo').val(selectedValue).trigger('change');
                            $(".tag-periodo").html('Periodo: '+selectedValue);
                        </x-snippet-on-change>
             @endif

             @if (isset($idSelect2) && $select2=='/select2/conceptos')
                    <x-snippet-on-change :idChange="$idSelect2">
                            var selectedValue = e.params.data.periodo;
                            if(selectedValue!="Sin referencia"){
                                $("#costo_concepto").prepend('<div class="alert alert-warning">Recuerda: Selecciona una fecha diferente en los siguientes inputs (seleccionada:'+selectedValue+')</div>')
                                console.log("hola");
                            }
                            
                          
                    </x-snippet-on-change>
             @endif

        });
    </script>


    <script>
        $(document).ready(function(){

        var id_escuela = $("#id_escuela").val();
        console.log(id_escuela);
        getSistemas(id_escuela);

        function getSistemas(id){
            var sistema = "";
            @if(isset($accion) && $accion=="edicion" && isset($concepto))
                sistema = "{{ $concepto->sistema_academico; }}";
            @endif
            $.ajax({
                url: '/ajax/sistemas_ac_escuela',
                type: 'post',
                data:{_token: '{{csrf_token()}}',id_escuela:id, seleccionado: sistema},
                success:function(response){
                    console.log(response);
                    renderDropdownSistemas(response);
                }
            });
        }

        function renderDropdownSistemas(html){
            $(".dropdown_sistemas").html(html);
        }

        $("#id_escuela").change(function(){
            var id_escuela = $(this).val();
            getSistemas(id_escuela);
        });

        })
    </script>
   
   
    
</body>
</html>