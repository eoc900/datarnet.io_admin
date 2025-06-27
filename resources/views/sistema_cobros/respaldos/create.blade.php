@extends('sistema_cobros.respaldos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')

<div class="card">
    <div class="card-body p-5">
        <form action="{{ route('respaldo.generar') }}" method="POST">
            @csrf
            <h5>Selecciona las opciones de respaldo</h5>
            <label><input type="checkbox" name="respaldo[]" value="informes"> Informes</label><br>
            <label><input type="checkbox" name="respaldo[]" value="formularios"> Formularios</label><br>
            <label><input type="checkbox" name="respaldo[]" value="banners"> Banners de Formularios</label><br>
            <label><input type="checkbox" name="respaldo[]" value="archivos"> Documentos Excel</label><br>
            <label><input type="checkbox" name="respaldo[]" value="tablas"> Tablas SQL</label><br>
            <button type="submit" class="btn btn-primary mt-3">Generar respaldo</button>
        </form>
    </div>
</div>
@endsection