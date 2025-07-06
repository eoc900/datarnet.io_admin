@extends('sistema_cobros.archivos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
<div class="container">
    <h2>Editar {{ ucfirst($tipo) }}: {{ $nombreArchivo }}</h2>
    <a href="{{ route('descargar.configuracion', ['tipo' => $tipo, 'nombreArchivo' => $nombreArchivo]) }}" class="btn btn-primary mb-5 float-end">
    Descargar archivo
    </a>

    <form method="POST" id="editar_archivo" action="{{ route('actualizar.archivo') }}">
        @csrf
        <input type="hidden" name="tipo" value="{{ $tipo }}">
        <input type="hidden" name="nombreArchivo" value="{{ $nombreArchivo }}">
        <input type="hidden" name="contenidoJson" id="contenidoJson">

        <div id="editor" style="height: 500px; width: 100%; border: 1px solid #ccc;">{!! $contenidoJson !!}</div>

        <button type="submit" class="btn btn-success mt-3 float-end">Guardar Cambios</button>
    </form>
</div>

@push("ace")
    <script>
    $(document).ready(function(){
        var editor = ace.edit("editor");
        editor.session.setMode("ace/mode/json");
        editor.setTheme("ace/theme/github");
        editor.session.setUseWorker(true); // para validación de JSON
        editor.setOptions({
            fontSize: "14px",
            wrap: true
        });

        function beforeSubmit() {
            document.getElementById('contenidoJson').value = editor.getValue();
        }

        $('#editar_archivo').on('submit', function(e) {
            e.preventDefault(); // Evita que se envíe
            console.log('Formulario bloqueado con jQuery.');
            beforeSubmit();
            
            // Aquí puedes hacer validaciones o pruebas
            // Por ejemplo, verificar que el JSON sea válido
            try {
                let contenido = $('#contenidoJson').val();
                JSON.parse(contenido); // Lanza error si es inválido
                console.log("JSON válido, podrías enviarlo manualmente si quieres.");

                // Si quieres enviarlo después de validar, descomenta esto:
                this.submit();
            } catch (err) {
                alert("El JSON no es válido. Revisa la sintaxis.");
            }
        });  
    })
    
</script>
@endpush





@endsection