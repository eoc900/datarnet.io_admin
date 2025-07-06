@extends('sistema_cobros.form_creator.layouts.show')
@section("content")
 

@include('components.sistema_cobros.response')

<div class="card">
    <div class="card-body">
        <a class="btn btn-primary" href="{{ url('tablas_modulos/'.$tabla_registros) }}">Registros</a>
    </div>
</div>


<div class="card">
    <div class="card-header pt-3">
        <h5>{{ $titulo ?? '' }}</h5>
        <p>{{ $descripcion ?? '' }}</p>
    </div>
    <div class="card-body mx-5">
        <form class="row" method="post" action="{{ isset($update) ? route($update, ['tabla' => $tabla, 'id' => $id]) : '' }}" enctype="multipart/form-data">
            @csrf
            <x-lista-mensajes/>
            <input type="hidden" name="identificador_action" value="{{ $hidden_identifier ?? '' }}">
            <input type="hidden" name="nombre_documento" value="{{ $nombre_documento ?? '' }}">
            
       
            {{-- USO: ITERACIÓN Para poner cada componente de formulario --}}
            @foreach ($inputs as $input)
                <div class="col-sm-6 mt-3">
                @if ($input["type"]=="text")
                    @include("components.form_creator.ejemplos_inputs.text",$input)
                @endif
                @if ($input["type"]=="date")
                    @include("components.form_creator.ejemplos_inputs.date",$input)
                @endif
                @if ($input["type"]=="datetime")
                    @include("components.form_creator.ejemplos_inputs.datetime",$input)
                @endif
                @if ($input["type"]=="select2")
                    @include("components.form_creator.ejemplos_inputs.select2",$input)
                @endif
                @if ($input["type"]=="dropdown")
                    @include("components.form_creator.ejemplos_inputs.dropdown",$input)
                @endif
                @if ($input["type"]=="radio")
                    @include("components.form_creator.ejemplos_inputs.radio",$input)
                @endif
                @if ($input["type"]=="email")
                    @include("components.form_creator.ejemplos_inputs.email",$input)
                @endif
                @if ($input["type"]=="file")
                    @include("components.form_creator.ejemplos_inputs.file",$input)
                @endif
                @if ($input["type"]=="checkbox")
                    @include("components.form_creator.ejemplos_inputs.checkbox",$input)
                @endif
                </div>
            @endforeach
             {{-- USO:  Para poner cada componente de formulario --}}
          


            <x-boton 
                nombre_boton="Actualizar registro" 
                type="submit" 
                classes="btn-submit btn btn-success float-end" 
                parentClass="col-12 pt-5 float-end"
            />
        </form>
    </div>
</div>



@endsection

