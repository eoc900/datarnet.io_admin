<!DOCTYPE html>
<html lang="en">
<head>
    @include('general.partials.head')
      <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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

    @stack('buscar_una_columna')

    <script>
      $(document).ready(function(){
        @if(isset($columnas) && !isset($id_tabla))
          buscarSolaColumna();
        @endif



        function eventoEsForanea(){
          $('.checkbox-foranea').off();
          $('.checkbox-foranea').on('change', function() {
            if ($(this).is(':checked')) {
              console.log("es foranea");
              var tabla = $(this).closest("tr").find(".on_table").val();
              var index = $(this).closest("tr").find(".on_table").attr("data-index");
              var obj = $(this).closest("tr").find(".on_row");
              ajaxColumnasTabla(tabla,obj,index);

            }
          });

          $('.on_table').off();
          $('.on_table').on('change', function () {
            var tabla = $(this).val();
            var index = $(this).attr("data-index");
            var obj = $(this).closest("tr").find(".on_row");
            ajaxColumnasTabla(tabla,obj,index);
        });
        }

         const esDesdeExcel = {!! json_encode($excel ?? false) !!};
        function ajaxColumnasTabla(tabla, append_on,index="", excel = esDesdeExcel){
          console.log("tabla: "+tabla);
          console.log("index: "+index);
              $.ajax({
              url: '/ajax/columnas_tabla', // Ajusta esta URL
                        method: 'POST',
                        data: {
                            _token:'{{csrf_token()}}', // CSRF para Laravel
                            tabla: tabla,
                            only_columnas:true,
                            index: index,
                            excel: excel

                        },
                        success: function(response) {
                            console.log('encontramos las siguientes columnas:', response);
                            // Necesitamos
                            $(append_on).html(response);
                        }
              });
        }

        eventoEsForanea();

      });
    </script>
</body>
</html>