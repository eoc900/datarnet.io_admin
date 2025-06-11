@extends('administrador.usuarios.layouts.master')
@section("content")

    <div class="card col-md-8">
        <div class="card-body">
        @include('general.partials.alertsTopSection')  
        <h2>Bienvenido</h2>
        <form method="post" action="{{ url('/usuarios/registerMain') }}" enctype="multipart/form-data" class="row">
        @csrf
        <div class="col-md-6 mt-3">
            <label for="input1" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="input1" placeholder="Nombre" name="name">
        </div>
        <div class="col-md-6 mt-3">
            <label for="input1" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="input1" placeholder="Nombre" name="lastname">
        </div>
        <div class="col-md-12 mt-3">
            <label for="input4" class="form-label">Email</label>
            <input type="email" class="form-control" id="input4" name="email">
        </div>
        <div class="col-md-12 mt-3">
            <label for="input5" class="form-label">Password</label>
            <input type="password" class="form-control" id="input5" name="password">
        </div>
        <div class="col-md-12 mt-3">
            <label for="input5" class="form-label">Codigo Maestro</label>
            <input type="password" class="form-control" id="input5" name="master_code">
        </div>
        <div class="col-md-12">
            <div class="d-flex d-grid align-items-end gap-3 float-end">
                <button type="submit" class="btn btn-grd-primary px-4 text-white mt-5 float-right">Registrarme</button>
            </div>
        </div>
        </form>

        </div>
    </div>
   



@endsection