<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
     <link href="{{ asset("dashboard_resources/assets/plugins/fullcalendar/css/main.min.css") }}" rel="stylesheet">
     <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    @include('general.partials.header')
    @include('general.partials.sidebar')

    @yield('content');

    @include('general.partials.scripts')
   
   
    
</body>
</html>