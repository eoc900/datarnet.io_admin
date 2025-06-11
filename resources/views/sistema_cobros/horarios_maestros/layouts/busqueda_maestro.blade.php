<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
        <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
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
    <script src="{{  asset("dashboard_resources/assets/plugins/fullcalendar/js/main.min.js");}}"></script>

    <script>
      $(document).ready(function(){

            <x-script-select2 select2="/select2/maestros" idSelect2="buscarMaestro">
            text: "Maestro: "+item.maestro +" -----> Estatus: "+((item.activo)?"Activo":"Suspendido"),
            id: item.id,
            </x-script-select2>

             <x-snippet-on-change idChange="buscarMaestro">
                        var id = e.params.data.id;
                        console.log("haz seleccionado al maestro: "+id);
                        window.location.href = "/disponibilidad/" + id;
            </x-snippet-on-change>

      });
    </script>
</body>
</html>