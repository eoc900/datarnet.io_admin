<!-- resources/views/estructura_ai.blade.php -->
@extends('inteligencia_artificial.layouts.prompting')

@section('content')
<div class="container">
    <div id="loader-ia" class="text-center" style="display: none;">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Procesando...</span>
        </div>
        <p class="mt-2"><strong>Procesando solicitud...</strong></p>
    </div>


    <h2 class="mb-4">Generador de Estructura con IA</h2>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>{{ session('success.mensaje') }}</strong>
            @if(!empty(session('success.tablas_existentes')))
                <br>
                <small>Las siguientes tablas ya existían y no fueron creadas de nuevo:</small>
                <ul class="mb-0">
                    @foreach(session('success.tablas_existentes') as $tabla)
                        <li>{{ $tabla }}</li>
                    @endforeach
                </ul>
            @endif
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif


    <!-- Prompt inicial -->
    <form id="formulario-prompt" method="POST" action="{{ route('ia.generar') }}">
        @csrf
        <div class="mb-3">
            <label for="prompt_original" class="form-label">Describe tu negocio y qué deseas estructurar:</label>
            <textarea name="prompt_original" id="prompt_original" class="form-control" rows="5">{{ old('prompt_original', session('prompt')) }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Generar estructura</button>
    </form>

    <!-- Resultado IA -->
    <div id="resultado-json" class="mt-5" style="display: none;">
        <h4>Resultado generado</h4>
        <div id="editor_json" style="height: 400px; width: 100%; border: 1px solid #ccc;"></div>
        <input type="hidden" name="json_generado" id="json_generado">

        <div class="mt-3">
            <button id="btn-aprobar" class="btn btn-primary">Aprobar estructura</button>
            <button id="btn-sugerir-cambios" class="btn btn-warning">Sugerir cambios</button>
        </div>
    </div>

    <!-- Campo dinámico para sugerencias -->
    <form id="form-sugerencias" method="POST" action="{{ route('ia.complementar') }}">
        @csrf
        <input type="hidden" name="prompt_original_hidden" id="prompt_original_hidden">
        <input type="hidden" name="json_original_hidden" id="json_original_hidden">

        <div id="campo_feedback" class="mt-4" style="display: none;">
            <label for="sugerencia_usuario" class="form-label">¿Qué deseas modificar o complementar?</label>
            <textarea name="sugerencia_usuario" id="sugerencia_usuario" class="form-control" rows="4">{{ old('sugerencia_usuario') }}</textarea>
            <button type="submit" class="btn btn-primary mt-2">Enviar mejora</button>
        </div>
    </form>


    <!-- Formulario de aprobación de estructura -->
    <form id="form-aprobar-estructura" method="POST" action="{{ route('ia.aprobar') }}">
        @csrf
        <input type="hidden" name="estructura" id="estructura_aprobada">
    </form>

</div>
@endsection

@push('ace')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.12/ace.js" crossorigin="anonymous"></script>
@endpush

@push('cargar_configuracion')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editor = ace.edit("editor_json");
        editor.setTheme("ace/theme/github");
        editor.session.setMode("ace/mode/json");
        editor.setReadOnly(true);

        // Mostrar sugerencia
        document.getElementById("btn-sugerir-cambios").addEventListener("click", function () {
            document.getElementById("campo_feedback").style.display = "block";
            document.getElementById("prompt_original_hidden").value = document.getElementById("prompt_original").value;
            document.getElementById("json_original_hidden").value = editor.getValue();
        });

        // Mostrar resultado si se cargó desde el backend
        @if(session('json'))
            document.getElementById("resultado-json").style.display = "block";
            editor.setValue(JSON.stringify(@json(session('json')), null, 2), -1);
        @endif

        // Mostrar loader al enviar cualquiera de los formularios
        document.getElementById("formulario-prompt").addEventListener("submit", function() {
            document.getElementById("loader-ia").style.display = "block";
        });

        document.getElementById("form-sugerencias").addEventListener("submit", function() {
            document.getElementById("loader-ia").style.display = "block";
        });


        document.getElementById("btn-aprobar").addEventListener("click", function () {
            const jsonActual = editor.getValue();
            try {
                // Validar que el contenido sea JSON válido
                JSON.parse(jsonActual);
                document.getElementById("estructura_aprobada").value = jsonActual;
                document.getElementById("loader-ia").style.display = "block";
                document.getElementById("form-aprobar-estructura").submit();
            } catch (e) {
                alert("El contenido del editor no es un JSON válido. No se puede aprobar.");
            }
        });
        
    });
</script>
@endpush
