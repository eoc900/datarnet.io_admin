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

            <x-script-select2 select2="/select2/alumnos" idSelect2="buscarAlumno">
            text: "Alumno: "+item.nombre+" Código: "+item.codigo_sistema+" -----> Estatus: "+((item.activo)?"Activo":"Suspendido"),
            id: item.id_alumno,
            </x-script-select2>

             <x-snippet-on-change idChange="buscarAlumno">
                        var id = e.params.data.id;
                        console.log("haz seleccionado el sistema: "+id);
                        window.location.href = "/curricula_alumnos/definir_materias/" + id;
            </x-snippet-on-change>


        });
    </script>
</body>
</html>