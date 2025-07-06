@extends('sistema_cobros.instalador.layouts.index')

@section('content')
<div class="container py-5">
    <h3 class="mb-4">Instalador de Archivos SQL</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form id="form-instalador" action="{{ route('instalador.sql.importar') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="carpeta_sql" class="form-label">Selecciona carpeta con archivos SQL</label>
            <input type="file" name="archivos_sql[]" class="form-control" webkitdirectory directory multiple required>
        </div>
  
            <div class="form-check mt-3">
                <input class="form-check-input" type="checkbox" name="sobrescribir" value="1" id="sobrescribir">
                <label class="form-check-label" for="sobrescribir">
                    Sobrescribir tablas si ya existen (DROP + CREATE)
                </label>
            </div>

 

        <div class="mt-4">
            <h5>Archivos detectados</h5>
            <ul id="lista-archivos" class="list-group"></ul>
        </div>

        <input type="hidden" name="orden_archivos" id="orden_archivos">

        <button type="submit" class="btn btn-primary mt-4">Ejecutar instalación</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    const inputArchivos = document.querySelector('[name="archivos_sql[]"]');
    const lista = document.getElementById('lista-archivos');

   inputArchivos.addEventListener('change', function () {
    if (this.files.length > 20) {
        Swal.fire({
            icon: 'error',
            title: '¡Demasiados archivos!',
            text: 'Máximo 20 archivos permitidos para ejecutar.',
            confirmButtonColor: '#d33'
        });
        this.value = ''; // limpia el input
        return;
    }

    lista.innerHTML = '';
    [...this.files].forEach((file, index) => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.draggable = true;
        li.dataset.nombre = file.name;
        li.innerHTML = `
        <div class="d-flex justify-content-between w-100 align-items-center">
            <span class="handle">${file.name}</span>
            <div>
                <span class="badge bg-secondary me-2">${index + 1}</span>
                <button type="button" class="btn btn-sm btn-outline-danger btn-eliminar">×</button>
            </div>
        </div>`;
        lista.appendChild(li);

        lista.addEventListener('click', function(e) {
            if (e.target.classList.contains('btn-eliminar')) {
                e.preventDefault();
                const li = e.target.closest('li');
                const nombreArchivo = li.querySelector('span.handle').textContent;

                Swal.fire({
                    title: '¿Eliminar archivo?',
                    text: `Estás por quitar "${nombreArchivo}" del listado.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed && li) {
                        li.remove();
                        actualizarOrden();
                        Swal.fire('Eliminado', `"${nombreArchivo}" fue eliminado del listado.`, 'success');
                    }
                });
            }
        });
    });
    actualizarOrden();
});


    function actualizarOrden() {
        const orden = [...lista.children].map(li => li.dataset.nombre);
        document.getElementById('orden_archivos').value = JSON.stringify(orden);
        [...lista.children].forEach((li, idx) => li.querySelector('.badge').innerText = idx + 1);
    }

    let dragSrcEl = null;

    lista.addEventListener('dragstart', e => {
        dragSrcEl = e.target;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', dragSrcEl.innerHTML);
    });

    lista.addEventListener('dragover', e => {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    });

    lista.addEventListener('drop', e => {
        e.preventDefault();
        if (e.target.closest('li') && dragSrcEl !== e.target.closest('li')) {
            const dropTarget = e.target.closest('li');
            const draggedHTML = dragSrcEl.innerHTML;
            dragSrcEl.innerHTML = dropTarget.innerHTML;
            dropTarget.innerHTML = draggedHTML;
            actualizarOrden();
        }
    });
</script>
@endpush