@extends('administrador.maestro.layouts.carga_documentos')
@section("content")
<div class="row row-cols-1 row-cols-xl-2">
    <div class="col">
        <div class="card rounded-4">
            <div class="row g-0 align-items-center">
            <div class="col-md-4 border-end">
                <div class="p-3 align-self-center">
                <img src="assets/images/gallery/09.png" class="w-100 rounded-start" alt="...">
                </div>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                        <h5 class="card-title">{{ $nombre_archivo }}</h5>
                        <p class="card-text">{{ $descripcion }}</p>
                        <div class="mt-4 d-flex align-items-center justify-content-between">
                            <button class="btn btn-grd btn-grd-primary d-flex gap-2 px-3 border-0"><i class="material-icons-outlined">document</i>Download</button>
                        </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection