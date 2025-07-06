@extends('sistema_cobros.instalador.layouts.index')

@section('content')
<div class="container mt-4">
    <h3>{{ $title }}</h3>

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <form action="{{ route('instalador.json.importar') }}" method="POST" enctype="multipart/form-data" id="form-json">
        @csrf

        <div class="mb-4">
            <label class="form-label">Subir archivos JSON de formularios</label>
            <input type="file" name="formularios_json[]" id="formularios_json" accept=".json" multiple class="form-control">
            <ul id="lista-formularios" class="list-group mt-2"></ul>
        </div>

        <div class="mb-4">
            <label class="form-label">Subir archivos JSON de informes</label>
            <input type="file" name="informes_json[]" id="informes_json" accept=".json" multiple class="form-control">
            <ul id="lista-informes" class="list-group mt-2"></ul>
        </div>

        <button class="btn btn-primary">Subir archivos</button>
    </form>
</div>

<script>
    function listarArchivos(inputId, listaId) {
        document.getElementById(inputId).addEventListener('change', function () {
            const lista = document.getElementById(listaId);
            lista.innerHTML = '';
            [...this.files].forEach(file => {
                const li = document.createElement('li');
                li.className = 'list-group-item';
                li.textContent = file.name;
                lista.appendChild(li);
            });
        });
    }

    listarArchivos('formularios_json', 'lista-formularios');
    listarArchivos('informes_json', 'lista-informes');
</script>
@endsection
