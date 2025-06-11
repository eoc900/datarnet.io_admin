<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{ asset("dashboard_resources/assets/plugins/input-tags/css/tagsinput.css");}}" rel="stylesheet">
    <link href="{{ asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
</head>
<body>
    @include('general.partials.header')
    @include('general.partials.sidebar')

      <main class="main-wrapper">
        <div class="main-content">
            @include('general.partials.indexTopSection')
            @yield('content')
        </div>
    </main>

    @include('general.partials.scripts')
    @include('general.partials.dynamicTableScript')
   
    
</body>
</html>