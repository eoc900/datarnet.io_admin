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
<script>
  $(document).ready(function () {
    let selectedItems = JSON.parse(localStorage.getItem("selectedItems")) || [];

    function updateLocalStorage() {
        localStorage.setItem("selectedItems", JSON.stringify(selectedItems));
    }

    function restoreCheckboxes() {
        $(".form-check-input").each(function () {
            let value = $(this).val();
            if (selectedItems.includes(value)) {
                $(this).prop("checked", true);
            }
        });
    }

    // Restaurar checkboxes al cargar la página
    restoreCheckboxes();

    // Delegar evento change a todos los checkboxes (incluidos los dinámicos)
    $(document).on("change", ".form-check-input", function () {
        let value = $(this).val();
        console.log("Checkbox cambiado:", value, $(this).is(":checked"));

        if ($(this).is(":checked")) {
            if (!selectedItems.includes(value)) {
                selectedItems.push(value);
            }
        } else {
            selectedItems = selectedItems.filter(item => item !== value);
        }
        updateLocalStorage();
    });

    // Evento para restaurar checkboxes tras la paginación
    $(document).on("click", ".pagination a", function (e) {
        setTimeout(() => {
            restoreCheckboxes();
        }, 500);
    });

    // Botón para enviar datos por AJAX
    $(".enviar").click(function () {
        console.log("Enviando datos:", selectedItems);
        $.ajax({
            url: "{{ route('generar_zip') }}",
            type: "POST",
            data: {_token:'{{csrf_token()}}', seleccionados: selectedItems },
            success: function (response) {
                alert("Datos enviados correctamente");
                console.log(response);
            },
            error: function (error) {
                console.error(error);
            }
        });
    });

});

</script>



</body>
</html>