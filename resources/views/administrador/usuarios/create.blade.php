@extends('administrador.tareas.layouts.create')
@section("content")

<!--breadcrumb-->
<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
    <div class="breadcrumb-title pe-3">{{ $breadcrumb_title }}</div>
    <div class="ps-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0 p-0">
                <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb_second }}</li>
            </ol>
        </nav>
    </div>
</div>

 @include('general.partials.alertsTopSection')

<div class="col-12 col-md-8 offset-md-2">
<div class="card">
    <div class="card-body">

         <h5 class="mb-4">Crear un nuevo usuario</h5>
            <form method="post" action="{{ route($routeStore) }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6 mt-3">
                    <label for="input1" class="form-label">Nombre</label>
                    <input type="text" class="form-control" id="input1" placeholder="Nombre" name="name">
                </div>
                <div class="col-md-6 mt-3">
                    <label for="input2" class="form-label">Apellidos</label>
                    <input type="text" class="form-control" id="input2" placeholder="Apellidos" name="lastname">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="input3" class="form-label">Correo</label>
                    <input type="text" class="form-control" id="input3" placeholder="Phone" name="email">
                </div>
                <div class="col-md-12 mt-3">
                    <label for="input3" class="form-label">Telephone</label>
                    <input type="text" class="form-control" id="input3" placeholder="Phone" name="telephone">
                </div>
                <div class="col-md-4 mt-3">
				<label for="input9" class="form-label">Categoría Usuario</label>
                    <select id="input9" class="form-select" name="user_type">
                        @foreach ($categorias as $categoria)
                            <option {{ ($categorias[count($categorias)-1]==$categoria)?"selected":'' }} value="{{ $categoria }}">{{ $categoria }}</option>
                        @endforeach
                    </select>
                </div>
                 <div class="col-md-4 mt-3">
				<label for="input9" class="form-label">Estado</label>
                    <select id="input9" class="form-select" name="estado">
                        @foreach ($estados as $estado)
                            <option value="{{ $estado }}">{{ $estado }}</option>
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