<!doctype html>
<html class="no-js" lang="es-mx">
<head>
@include('landing_page.partials.head')
</head>
<body>
@include('landing_page.partials.header')


    
        @yield('content')

@include('landing_page.partials.footer')
@include('landing_page.partials.scripts')

   
   
    
</body>
</html>