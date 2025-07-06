 $('#{{ $idSelect2 }}').on('select2:select', function (e) {
    console.log("Usuario seleccionado");
    console.log(e);
    {{ $slot }}
});