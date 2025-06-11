@extends('sistema_cobros.sistemas_academicos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Seleccionar las materias que puede impartir</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('curriculas.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
    
        @if (isset($sistema) && $sistema!="")
     
            <div class="my-5 ">
                <a href="{{ route("curricula_sistema.definir_materias"); }}" class="btn btn-outline-primary "><span class="font-15">	<i class="lni lni-search"></i>
                </span>Buscar otros</a>
            </div>
            
            <h2>{{ $sistema->nombre }} {{ $sistema->codigo_sistema }}</h2>
            <input name="id_sistema" type="hidden" value="{{ $sistema->id }}">
        @else
            <div class="mb-5">
            <label for="buscarSistema">Selecciona el sistema</label>
            <x-select2 placeholder="Buscar sistema" id="buscarSistema" name="id_sistema" />
            </div>
        @endif


        <div class="row">
             <h5 class="mb-3">Currícula bachillerato:</h5>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                @foreach ($materias_preparatoria as $materia)
                    <div class="col">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="materia-{{ $materia->id }}" 
                                name="materia[]" 
                                value="{{ $materia->id }}"
                                @if (in_array($materia->id,$materias_asociadas))
                                    checked
                                @endif
                            >
                            <label class="form-check-label" for="materia-{{ $materia->id }}">
                                {{ $materia->materia}} ({{ $materia->clave }})
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
            
       

  
        </div>
        <x-boton nombre_boton="Actualizar materias" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection