@extends('sistema_cobros.tipos_correos.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Editar inscripción</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('inscripciones.update',$inscripcion->id) }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <x-lista-mensajes/>
        <div class="row">
             <div class="col-12">
               @php
                    $modalidades = [
                        ["id" => "Escolarizado", "option" => "Escolarizado"],
                        ["id" => "Semi-Escolarizado", "option" => "Semi-Escolarizado"]
                    ];
                @endphp

                <label for="sistema">Modalidad</label>
                <select name="modalidad" id="modalidad" class="form-control mt-3">
                    @foreach ($modalidades as $modalidad)
                        <option value="{{ $modalidad['id'] }}" {{ ($inscripcion->modalidad == $modalidad['id']) ? "selected" : "" }}>
                            {{ $modalidad['option'] }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="contenedor_inputs ps-5 pb-5">
                <x-dropdown-anio label="Selecciona el año" id="anio" name="anio" :selected="$anio"/>
                <x-dropdown-cuatrimestre label="Selecciona el cuatrimestre" id="cuatri" name="cuatri" :selected="$cuatri"/>
            </div>
           
        </div>
         <x-boton nombre_boton="Editar" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>


@endsection