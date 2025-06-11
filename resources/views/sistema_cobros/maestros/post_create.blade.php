@extends('sistema_cobros.alumnos.layouts.index')
@section("content")

    @if (isset($alumno))
    
   
    <div class="card">
        <div class="card-body">
            <div class="alert alert-{{ ($enviado)?success :danger; }}"></div>
            <div class="row">
                <div class="col-sm-6 border-end pt-3 text-center">
                    <h5>¿Deseas crear otro registro de alumno?</h5>
                    <a href="{{ route('alumnos.create'); }}" class="btn btn-info mt-5 text-white"><i class="lni lni-user"></i> Crear otro alumno</a>
                </div>
                <div class="col-sm-6 text-center pt-3 pb-3">
                    <h5>Continuar con inscripción del alumno:</h5>
                    <h3>{{ $alumno->alumno; }}</h3>
                    <a href="{{ route('alumnos.show',$alumno->id_alumno); }}" class="btn btn-primary mt-3"><i class="lni lni-write"></i> Inscripción</a>
                </div>
            </div>
        </div>
    </div>
     @endif

@endsection