@extends('sistema_cobros.maestros.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Seleccionar las materias que puede impartir</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('maestros_materias.guardar_materias_definidas') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
    
        @if (isset($maestro) && $maestro!="")
     
            <div class="my-5 ">
                <a href="{{ route("maestros_materias.definir_materias"); }}" class="btn btn-outline-primary "><span class="font-15">	<i class="lni lni-search"></i>
                </span>Buscar otros</a>
            </div>
            
            <h2>{{ $maestro->nombre }} {{ $maestro->apellido_paterno }} {{ $maestro->apellido_materno }}</h2>
            <input name="maestro" type="hidden" value="{{ $maestro->id }}">
        @else
            <div class="mb-5">
            <label for="buscarMaestro">Selecciona el concepto</label>
            <x-select2 placeholder="Buscar usuario o rol" id="buscarMaestro" name="maestro" />
            </div>
        @endif


        <div class="row">
             <h5 class="mb-3">Currícula bachillerato:</h5>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                @foreach ($materias as $materia)
                    <div class="col">
                        <div class="form-check">
                            <input 
                                type="checkbox" 
                                class="form-check-input" 
                                id="materia-{{ $materia->id }}" 
                                name="materia[]" 
                                value="{{ $materia->id }}"
                                @if (in_array($materia->id,$maestro_materias))
                                    checked
                                @endif
                            >
                            <label class="form-check-label" for="materia-{{ $materia->id }}">
                                {{ $materia->materia}}
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