@extends('sistema_cobros.carga_archivos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')

<div class="card">
<div class="card-body">
    {{ $datos_carpeta->nombre_directorio }}

    <div class="row">
        <div class="col-xl-9 mx-auto">
            <h6 class="mb-0 text-uppercase">Selecciona los archivos que quieres cargar </h6>
            <hr>
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('archivos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input id="image-uploadify" type="file" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>

                          <button type="submit" class="btn btn-grd-success float-end px-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
	
@endsection