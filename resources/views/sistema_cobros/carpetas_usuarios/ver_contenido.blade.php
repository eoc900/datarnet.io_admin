@extends('sistema_cobros.carpetas_usuarios.layouts.index')
@section("content")

<a href="{{ url()->previous() }}" class="btn btn-primary mb-5">Regresar</a>
 @include('components.sistema_cobros.response')
<div class="card">
    <div class="card-body">
       

             <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h6 class="mb-0 text-uppercase">Selecciona los archivos que quieres cargar </h6>
                    <hr>
                    <div class="card">
                        <div class="card-body">
                            <form method="post" action="{{ route('cargar') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="ruta" value="{{ $ruta }}">
                                <input id="image-uploadify" type="file" name="archivo[]" accept=".xlsx,.xls,image/*,.doc,audio/*,.docx,video/*,.ppt,.pptx,.txt,.pdf" multiple>
                                <button type="submit" class="mt-3 btn btn-success float-end cargar">Cargar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

             <div class="row">
                @foreach ($subdirectorios as $subdirectorio)
                <div class="col-4">
                    <div class="card cursor-pointer" style="width: 18rem;" data-pointer="{{ $subdirectorio }}">
                    <img src="{{ asset("dashboard_resources/assets/images/card_directory.jpg"); }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-title">{{ $subdirectorio }}</p>
                    
                    </div>
                    </div>
                </div>
                @endforeach
                @foreach ($files as $file)
                <div class="col-4">
                    <div class="card cursor-pointer" style="width: 18rem;">
                    <img src="{{ asset("dashboard_resources/assets/images/file.jpg"); }}" class="card-img-top" alt="...">
                    <div class="card-body">
                        <p class="card-title">{{ $file }}</p>
                    
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
    </div>
</div>


@endsection