@extends('sistema_cobros.materias_registradas.layouts.index')
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
    
        @if (isset($alumno) && $alumno!="")
     
            <div class="my-5 ">
                <a href="{{ route("definir_materias_alumno"); }}" class="btn btn-outline-primary "><span class="font-15">	<i class="lni lni-search"></i>
                </span>Buscar otros</a>
            </div>
            
            <h5><b>{{ $alumno->alumno }}</b></h5>
            <h5>{{ $alumno->sistema }} {{ $alumno->codigo_sistema }}</h5>
            <input name="id_sistema" type="hidden" value="{{ $alumno->id_sistema }}">

             <div class="row">
                @php
                    $materiasPorCuatrimestre = $materias_preparatoria->groupBy('cuatrimestre');
                @endphp

                @foreach($materiasPorCuatrimestre as $cuatrimestre => $materias)

                @php
                    $arreglo = [];
                @endphp
                <div class="col-sm-6">
                    <div class="card mb-4 bg-dark">
                        <div class="card-header text-white">
                            Cuatrimestre: {{ $cuatrimestre }}
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                @foreach($materias as $materia)
                                    <li class="list-group-item">
                                        {{ $materia->materia }}
                                        <small class="text-muted">(Clave: {{ $materia->clave }})</small>
                                    </li>
                                    @php
                                        array_push($arreglo,$cuatrimestre.":".$materia->id_materia);
                                    @endphp
                                @endforeach
                            </ul>
                            <input type="hidden" name="materias[]" value="{{ implode(",",$arreglo); }}">
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        @else
            <div class="mb-5">
            <label for="buscarAlumno">Selecciona el sistema</label>
            <x-select2 placeholder="Buscar alumno" id="buscarAlumno" name="id_alumno" />
            </div>
        @endif


       
            
       

  
        </div>
        <x-boton nombre_boton="Actualizar materias" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection