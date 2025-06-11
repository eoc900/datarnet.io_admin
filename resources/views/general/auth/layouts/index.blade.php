<!DOCTYPE html>
<html lang="es-mx">
<head>
    @include('general.partials.head')
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
        $("#show_hide_password a").on('click', function (event) {
          event.preventDefault();
          if ($('#show_hide_password input').attr("type") == "text") {
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass("bi-eye-slash-fill");
            $('#show_hide_password i').removeClass("bi-eye-fill");
          } else if ($('#show_hide_password input').attr("type") == "password") {
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass("bi-eye-slash-fill");
            $('#show_hide_password i').addClass("bi-eye-fill");
          }
        });
        $("#password_confirmation a").on('click', function (event) {
          event.preventDefault();
          if ($('#password_confirmation input').attr("type") == "text") {
            $('#password_confirmation input').attr('type', 'password');
            $('#password_confirmation i').addClass("bi-eye-slash-fill");
            $('#password_confirmation i').removeClass("bi-eye-fill");
          } else if ($('#password_confirmation input').attr("type") == "password") {
            $('#password_confirmation input').attr('type', 'text');
            $('#password_confirmation i').removeClass("bi-eye-slash-fill");
            $('#password_confirmation i').addClass("bi-eye-fill");
          }
        });
      });
    </script>

</body>
</html>