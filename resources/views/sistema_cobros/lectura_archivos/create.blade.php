@extends('sistema_cobros.lectura_archivos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
    @if(@session("resultados"))
    <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show">
    <div class="d-flex align-items-center">
        <div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span>
        </div>
        <div class="ms-3">
        <h6 class="mb-0 text-white">Operación exitosa</h6>
        <div class="text-white">{{ print_r(session('resultados'));}}</div>
        </div>
        </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endisset

<div class="card-header pt-3">
    <h5>Carga de archivos</h5>
</div>
<div class="card-body">
  
        @csrf
        <x-lista-mensajes/>
        <form action="{{ route('excel.read') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="file" accept=".xlsx,.xls" required>
            <button type="submit" class="btn btn-success">Cargar Archivo</button>
        </form>

           <x-boton nombre_boton="Crear contacto" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>

</div>
</div>
@endsection