@extends('pdfs.layouts.ver_cuenta_layout')
@section("content")



<div class="card">
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session("success"))
        <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show">
    <div class="d-flex align-items-center">
        <div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span>
        </div>
        <div class="ms-3">
        <h6 class="mb-0 text-white">Operación exitosa</h6>
        <div class="text-white">{{ (session('success'))}}</div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card-header">
    <h5>Generar documento pdf</h5>
</div>
<div class="card-body">
    <label for="buscarAlumno">Buscar alumno</label>
    <x-select2 placeholder="Buscar alumno por nombre" id="buscarAlumno" name="id_alumno" />

    
</div>
</div>

<form action="{{ url('/download/cuenta'); }}" method="post">
@csrf

<div class="d-flex mt-3 mb-3">
    <div class="dropdownCuentas mt-3" id="dropdownCuentas">
    </div>
    <button type="submit" class="btn btn-success descargar d-none mt-5 float-end" >Descargar esta cuenta</button>
</div>
</form>

<div class="d-flex mt-3 mb-3">
    <button class="btn btn-success enviar d-none mt-5 float-end" id="enviar">Envío automático</button>
</div>


<div class="card mb-5 pb-5">
    <div class="card-body" id="preview_cuenta">
        Selecciona una cuenta para pre-visualizar los datos de cuenta...
    </div>
</div>





@endsection