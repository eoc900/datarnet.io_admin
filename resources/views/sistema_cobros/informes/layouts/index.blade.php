<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
  

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    
      
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script src="{{ asset('librerias_pdf/jspdf.umd.min.js') }}"></script>
    <script src="{{ asset('librerias_pdf/html2canvas.min.js') }}"></script>

    {{-- FILTROS --}}
    @stack("date_filter_config")
    @stack("listado-filtros")
    {{-- FILTROS --}}
   

    <script>
        $(document).ready(function(){
          
            @stack("text_filter_config")              
            @stack("funciones_sidebar")
            {{-- ELEMENTOS DE INFORME --}}
            @stack("insertar_espacio_configuracion") 
            {{-- ELEMENTOS DE INFORME --}}          
            @stack('funciones_graficas')
        });
    </script>
</body>
</html>