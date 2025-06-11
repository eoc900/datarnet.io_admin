@extends('sistema_cobros.carga_materias.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Carga de materias</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('carga_materias.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
    
            @if($alumno==false)
            <div class="col-12 mt-5">
                <label for="buscarAlumno">Buscar alumno</label>
                <x-select2 placeholder="Buscar alumno por nombre" id="buscarAlumno" name="id_alumno" />
            </div>

            <div class="tabla_inscripciones">
                {{-- carga_materias/layouts/index --}}
            </div>
         
            @endif



            @if($alumno && $inscripciones)

                <div class="mb-5 mt-4 ps-5 pe-5">
                <h4><b>Nombre: </b>{{ $alumno->alumno }}</h4>
                <p><b>Matrícula: </b>{{ $alumno->matricula }}</p>
                <p><b>Sistema: </b>{{ $alumno->codigo_sistema }} </p>
                <p><b>Escuela: </b>{{ $alumno->codigo_escuela }}  </p>
                </div>
      
                <div class="ps-5 pe-5">
                <table class="table table-striped table-bordered inscripciones">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>ID Inscripción</th>
                        <th>Período</th>
                        <th>Total de Materias</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Datos dinámicos -->
                    @foreach ($inscripciones as $index => $inscripcion)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $inscripcion->tipo_inscripcion }}</td>
                        <td>{{ $inscripcion->periodo }}</td>
                        <td>{{ $inscripcion->materias_inscritas }}</td>
                        <td><button type="button" class="btn btn-primary cargar_materias" data-inscripcion="{{ $inscripcion->id}}" data-periodo="{{ $inscripcion->periodo}}">Cargar materias +</button></td>
                    </tr>
                    @endforeach
                </tbody>
                </table>

                <p>Periodo seleccionado: <span class="text-danger periodo_seleccionado"> Aún no seleccionas un periodo</span></p>
                <input type="hidden" name="id_inscripcion" id="id_inscripcion" value="">
                <input type="hidden" name="periodo" id="periodo" value="">
                </div>

                
                <div class="contenedor_inputs ps-5 pb-5">
                    
                    <label class="mt-4">Selecciona una materia</label>
                    <select name="materias[]" class="form-control">
                    @foreach ($materias as $materia)
                        <option value="{{ $materia->id }}">{{ $materia->materia }} | Cuatrimestre: {{ $materia->cuatrimestre }} | Créditos: {{ $materia->creditos }} </option>
                    @endforeach
                    </select>
                </div>
            @endif

            <button type="button" class="agregar_materias btn btn-primary mt-4">+ Agregar materia</button>
            <x-boton nombre_boton="Crear contacto" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>
@endsection