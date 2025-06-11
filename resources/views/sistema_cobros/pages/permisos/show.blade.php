@extends('sistema_cobros.pages.permisos.layouts.show_layout')
@section("content")

<div class="card">
    <div class="card-body pt-5">
        <h5>{{ $permiso->name }}</h5>

         @if ($users->isEmpty())
        <div class="alert alert-warning" role="alert">
            No hay usuarios con este permiso.
        </div>
        @else
        <a href="{{ route('tabla','permisos') }}" class="btn btn-secondary">Volver a la lista de permisos</a>
         <table class="table table-bordered mt-5">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Fecha de Creación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>

@endsection