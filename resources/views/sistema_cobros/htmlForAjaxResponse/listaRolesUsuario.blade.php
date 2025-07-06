@if (isset($datos))

    @foreach ($datos as $rol)
        <div class="d-flex hidden bg-light flex-row shadow mt-3 role-box" data-role="{{ $rol->role}}">
                    <p class="rol me-5 mt-3 flex-grow-1  text-center">{{ $rol->role }}</p>
                    <button class="btn btn-danger eliminar-rol">Eliminar rol</button>
        </div>
    @endforeach
@endif