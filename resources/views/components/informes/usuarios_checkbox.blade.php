@php
    use App\Models\User;

    $usuarios = User::with('roles')
        ->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'Administrador tecnológico');
        })->get();
@endphp


@if($usuarios->count() >0)
<div class="mb-3">
    <label class="form-label fw-bold">Usuarios permitidos:</label>
    <div class="row">
        @foreach ($usuarios as $usuario)
            <div class="col-md-12">
                <div class="form-check">
                    <input
                        type="checkbox"
                        class="form-check-input"
                        name="usuarios_permitidos[]"
                        value="{{ $usuario->id }}"
                        id="usuario_{{ $usuario->id }}"
                    >
                    <label class="form-check-label" for="usuario_{{ $usuario->id }}">
                        {{ $usuario->name }} ({{ $usuario->email }})
                    </label>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif
