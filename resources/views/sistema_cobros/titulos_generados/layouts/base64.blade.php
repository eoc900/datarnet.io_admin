<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
      <link href="{{  asset("dashboard_resources/assets/css/style.css");}}" rel="stylesheet">
</head>
<body>


<main class="main-wrapper">
<div class="main-content">
    @yield('content')
</div>
</main>


@include('general.partials.scripts')
<script>
$(document).ready(function () {
    window.onload = function() {
            window.location.href = "{{ $downloadUrl }}";
    };
});

</script>



</body>
</html>