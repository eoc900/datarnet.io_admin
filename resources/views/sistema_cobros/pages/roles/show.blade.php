@extends('sistema_cobros.layouts.index')

@section('content')
    <div class="container">
        <div class="card p-5">
        <h5>Detalles del Rol: <b></b>{{ $role->name }}</h5>
        <h3>Permisos Asignados:</h3>
        <ul>
            @forelse($permissions as $permission)
                <li>{{ $permission->name }}</li>
            @empty
                <li>No hay permisos asignados a este rol.</li>
            @endforelse
        </ul>

        <a href="{{ url('/tabla/roles') }}" class="btn btn-primary">Volver a la lista de roles</a>
        </div>
    </div>
@endsection
