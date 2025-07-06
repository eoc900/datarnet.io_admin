<!doctype html>
<html class="no-js" lang="es-mx">
<head>
    @include('landing_page.partials.head')
</head>
<body>
    @include('landing_page.partials.header')

    <main class="main-wrapper">
  
       
            @yield('content')

    </main>

    @include('landing_page.partials.scripts')

   
   
    
</body>
</html>