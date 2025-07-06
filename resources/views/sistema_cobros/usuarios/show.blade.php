@extends('general.layouts.index')

@section('content')
    <div class="container">
        <div class="card p-5">
            <div class="card-header">
                   <h5>Nombre: <b>{{ $role->name }}</b></h5>
            </div>
            <div class="card-body">
                 <p>Permisos Asignados:</p>
                @if($permissions)
                <ul class="pt-3">
                    @foreach($permissions as $permission)
                        <li>{{ $permission->name }}</li>
                    @endforeach
                </ul>
                @endif

                <div class="alert alert-warning">
                    No hay permisos asignados a este rol.
                </div>

                <a href="{{ route('roles.index')}}" class="btn btn-primary">Volver a la lista de roles</a>

            </div>            
        </div>
    </div>
@endsection
