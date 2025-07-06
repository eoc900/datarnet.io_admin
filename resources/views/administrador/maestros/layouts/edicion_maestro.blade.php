  <!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
     <link href="{{ asset("dashboard_resources/assets/plugins/bs-stepper/css/bs-stepper.css") }}" rel="stylesheet">
</head>
<body>
    @include('general.partials.header')
    @include('general.partials.sidebar')

    @yield('content');

    @include('general.partials.scripts')
    @include('administrador.maestros.componentes.edicion')
    
</body>
</html>
  
