<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
      <link href="{{  asset("dashboard_resources/assets/plugins/fancy-file-uploader/fancy_fileupload.css");}}" rel="stylesheet">
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
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    @stack("cargar_configuracion")
    <!-- ACE Editor CDN -->

    @stack("ace")
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" crossorigin="anonymous"></script>


   
  @stack("cargar_configuracion")
    
</body>
</html>