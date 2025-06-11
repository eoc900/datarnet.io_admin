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

           

           
            // Seccion 2 multiple inputs

            
            <x-script-select2 select2="/select2/usuarios" idSelect2="buscarUsuario">
            text: "Usuario: "+item.usuario +" -----> Estado: "+item.estado,
            id: item.id,
            </x-script-select2>

             <x-snippet-on-change idChange="buscarUsuario">
                        var id = e.params.data.id;
                        console.log("has seleccionado al siguiente usuario");
            </x-snippet-on-change>

        });
    </script>
</body>
</html>