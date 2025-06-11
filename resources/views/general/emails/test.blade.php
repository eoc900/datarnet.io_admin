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

         <h5 class="mb-4">Probar email</h5>
            <form method="post" action="{{ url('/emails/sendEmail') }}" enctype="multipart/form-data">
                @csrf
                <div class="col-md-6">
                    <label for="input1" class="form-label">Nombre Completo</label>
                    <input type="text" class="form-control" id="input1" placeholder="Nombre completo" name="nombre">
                </div>
                <div class="col-md-12">
                    <label for="input3" class="form-label">Telefono</label>
                    <input type="text" class="form-control" id="input3" placeholder="telefono" name="telefono">
                </div>
                <div class="col-md-12">
                    <label for="input4" class="form-label">Email</label>
                    <input type="email" class="form-control" id="input4" name="email">
                </div>
                <div class="col-md-12">
                    <label for="input11" class="form-label">Descripción</label>
                    <textarea class="form-control" id="input11" placeholder="Breve motivo del contacto." rows="3" name="descripcion"></textarea>
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