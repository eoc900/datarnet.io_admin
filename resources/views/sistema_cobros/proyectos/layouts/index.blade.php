<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />   
    <script src="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.js"></script>
    <link href="https://cdn.dhtmlx.com/gantt/edge/dhtmlxgantt.css" rel="stylesheet">
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
    <script>
        $(document).ready(function(){

        gantt.config.date_format = "%Y-%m-%d %H:%i:%s";
        gantt.init("gantt_here");
        gantt.load("/api/data");
        var dp = new gantt.dataProcessor("/api");
        dp.init(gantt);
        dp.setTransactionMode("REST");

        });
    </script>
</body>
</html>