@extends('administrador.tareas.layouts.create')
@section("content")

@include('general.partials.breadcrumb_top')
@include('general.partials.alertsTopSection')

<div class="col-12 col-md-8 offset-md-2">
<div class="card">
    <div class="card-body">

         <h5 class="mb-4">Actualizar información de usuario</h5>
             <form class="row g-3" method="post" action="{{ route($routeUpdate, $user->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="col-md-6 mt-3">
                    <label for="input1" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="input1" placeholder="Nombre" name="name" value="{{ $user->name }}">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="input2" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="input2" placeholder="Apellidos" name="lastname" value="{{ $user->lastname }}">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="input3" class="form-label">Correo</label>
                    <input type="text" class="form-control" id="input3" placeholder="Phone" name="email" value="{{ $user->email }}">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="input3" class="form-label">Telephone</label>
                    <input type="text" class="form-control" id="input3" placeholder="Phone" name="telephone" value="{{ $user->telephone }}">
                </div>
        
                 <div class="col-md-4 mt-3">
				        <label for="input9" class="form-label">Estado</label>
                            <select id="input21" class="form-select  pt-3" name="estado">
                            @foreach($estados as $estado)
                                <option {{ ($user->estado==$estado)? "selected":"" }} value="{{ $estado }}">{{ $estado }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-md-12 pt-3">
                    <div class="d-md-flex d-grid align-items-center gap-3 float-end">
                        <button type="submit" class="btn btn-success float-end px-4">Submit</button>
                    
                    </div>
                </div>
            </form>
    </div>
</div>
</div>

@endsection