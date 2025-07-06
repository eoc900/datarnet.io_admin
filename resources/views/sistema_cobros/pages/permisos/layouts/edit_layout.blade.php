<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
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
</body>
</html>