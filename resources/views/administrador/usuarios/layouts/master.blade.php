<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
</head>
<body>


    <main class="main-wrapper pt-5">
        <div class="main-content">
       
            @yield('content')
        </div>
    </main>

    @include('general.partials.scripts')
 
   
   
    
</body>
</html>