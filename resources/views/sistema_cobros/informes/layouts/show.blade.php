<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">
    <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <style>
       @media print, (max-width: 9999px) {
            .seccion {
                width: 100%;
                max-width: 190mm;
                margin: 0 auto;
                page-break-after: always;
                position: relative;
            }
            
            /* Reset de estilos que pueden afectar la renderización */
            .seccion * {
                max-width: 100% !important;
                transform: none !important;
            }
            .seccion-pdf .row {
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
      
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


    @stack("jquery")

  
            @stack('jquery_grafica')

    
    @stack("funciones_show_date_filter")

    <script>
        $(document).ready(function(){
            @stack('filtros_funciones_show')
        });
    </script>

</body>
</html>