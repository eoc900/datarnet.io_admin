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
    <h2 class="mb-4">Cargar estructura</h2>
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

    <h4>Resultado generado</h4>
    <div id="editor_json" style="height: 500px; width: 100%; border: 1px solid #ccc;"></div>
    <div class="mt-3">
            <button id="btn-aprobar" class="btn btn-primary">Aprobar estructura</button>
    </div>


      <!-- Formulario de aprobación de estructura -->
    <form id="form-aprobar-estructura" method="POST" action="{{ route('ia.aprobar') }}">
        @csrf
        <input type="hidden" name="estructura" id="estructura_aprobada">
    </form>
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
            //editor.setReadOnly(true);


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



