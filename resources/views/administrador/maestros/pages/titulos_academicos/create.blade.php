@extends('administrador.maestros.layouts.index')
@section("content")

 <main class="main-wrapper">
    <div class="main-content">
        <h5 class="mb-4">Enlazar un título académico</h5>
        <div class="card">
            <div class="card-body">
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
    
             <form action="{{ route('titulos_academicos.store') }}" method="POST">
                    @csrf
                    <div>
                        <label for="id_maestro">Maestro:</label>
                    
                        <select class="select2-maestro form-control" data-tags="true" data-placeholder="Select an option" data-allow-clear="true" id="maestro">
                        </select>
                    </div>
                    <input type="hidden" id="maestro_id" name="id_maestro" value="" class="id_master">
                    <div class="row">
                    <div class="col-md-6 pt-3">
                        <label for="grado_academico">Grado Académico:</label>
                        <select class="form-select" name="grado_academico" id="grado_academico">
                            <option value="bachillerato">Bachillerato</option>
                            <option value="licenciatura">Licenciatura</option>
                            <option value="ingenieria">Ingeniería</option>
                            <option value="maestría">Maestría</option>
                            <option value="doctorado">Doctorado</option>
                            <option value="diplomado">Diplomado</option>
                        </select>
                    </div>

                    <div class="col-md-12 pt-3">
                        <label for="nombre_titulo">Nombre del Título:</label>
                        <input class="form-control"  type="text" name="nombre_titulo" id="nombre_titulo" required>
                    </div>

                    <div class="col-md-6 pt-3">
                        <label for="nombre_universidad">Nombre de la Universidad:</label>
                        <input class="form-control"  type="text" name="nombre_universidad" id="nombre_universidad" required>
                    </div>

                    <div class="col-md-6 pt-3">
                        <label for="calificacion">Calificación:</label>
                        <input class="form-control"  type="number" name="calificacion" id="calificacion" step="0.01" required>
                    </div>

                    <div class="col-md-6 pt-3">
                        <label for="pais">País:</label>
                        <input class="form-control"  type="text" name="pais" id="pais" required>
                    </div>

                    <div class="col-md-6 pt-3">
                        <label for="inicio">Fecha de Inicio:</label>
                        <input class="form-control"  type="date" name="inicio" id="inicio" required>
                    </div>

                    <div class="col-md-6 pt-3">
                        <label for="conclusion">Fecha de Conclusión:</label>
                        <input class="form-control"  type="date" name="conclusion" id="conclusion" required>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-grd-success float-end px-4">Submit</button>
            </form>
            </div>
        </div>
    </div>
 </main>
 @endsection