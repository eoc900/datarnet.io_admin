<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
   
    <link href="{{ asset("dashboard_resources/assets/plugins/input-tags/css/tagsinput.css");}}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("centro_estudios/assets/css/font-awesome-pro.css");}}">
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
            function bringRolesUsuario(id){
                $.ajax({
                    url: '{{ url("/ajax/rolesUsuario") }}',
                    method: "post",
                    data: {_token:'{{csrf_token()}}',id_usuario: id},
                    success: function(response){
                        console.log(response);
                        $(".listado_roles").html(response);
                        clickDelete();
                    }
                })
            }
            function clickDelete(){
                $('.eliminar-rol').off();
                $('.eliminar-rol').click(function(){
                    let rol = $(this).parent('.role-box').attr("data-role");
                    let id = $('.usuario').val();
                    console.log("rol");
                    console.log(rol);
                    console.log("usuario");
                    console.log(id);
                    $.ajax({
                        url: '{{ url("/eliminar/rol") }}',
                        method: "post",
                        data: {_token:'{{csrf_token()}}',user_id: id, rol: rol},
                        success: function(response){
                            location.replace(location.href);
                        } 
                    })
                });
                
            }

            @if (isset($select2))
                @switch($select2)
                    @case("/select2/usuarios")
                         <x-script-select2 :select2="$select2" :idSelect2="$idSelect2">
                        text: "Usuario: "+item.usuario,
                        id: item.id,
                        usuario: item.usuario
                        </x-script-select2>

                        <x-select2-on-select :idSelect2="$idSelect2" >
                                $(".usuario_seleccionado").html("Haz seleccionado a: "+e.params.data.usuario);
                                $(".usuario_seleccionado").attr("data-usuario",e.params.data.id);
                                $(".usuario").val(e.params.data.id);
                                bringRolesUsuario(e.params.data.id);
                        </x-select2-on-select>
                    @break
                   
                
                    @default
                        
                @endswitch
               
            @endif

          

        });
    </script>
   
   
    
</body>
</html>