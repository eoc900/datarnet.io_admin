@extends('inteligencia_artificial.layouts.index')

@section('content')
<div class="container">
    <h2 class="mb-4">Previsualizar archivo de configuración</h2>
    <input type="file" id="input-json" accept=".json" class="form-control mb-3">
    <div id="editor" style="height: 400px; width: 100%; border: 1px solid #ccc;"></div>
    <button id="guardar-archivo" class="btn btn-primary mt-3">Guardar y enviar</button>
</div>
@endsection

@section('scripts')

<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" crossorigin="anonymous"></script>
<script>
    let editor = ace.edit("editor");
    editor.setTheme("ace/theme/monokai");
    editor.session.setMode("ace/mode/json");

    // Leer archivo local
    document.getElementById('input-json').addEventListener('change', function(e) {
        let file = e.target.files[0];
        if (!file) return;

        let reader = new FileReader();
        reader.onload = function(e) {
            editor.setValue(e.target.result, -1);
        };
        reader.readAsText(file);
    });

  

    document.getElementById('guardar-archivo').addEventListener('click', function () {
    let contenido = editor.getValue();
    Swal.fire({
        title: '¿Estás listo para guardar?',
        text: "Se enviará el contenido al servidor. ¿Deseas continuar?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('ai.configuracion.guardar') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        contenido: contenido
                    },
                    success: function(response) {
                        Swal.fire('¡Guardado!', 'El archivo fue enviado exitosamente.', 'success');
                    },
                    error: function() {
                        Swal.fire('Error', 'Hubo un problema al enviar el archivo.', 'error');
                    }
                });
            }
        });
    });

</script>
@endsection
