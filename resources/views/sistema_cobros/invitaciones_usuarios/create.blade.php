@extends('sistema_cobros.invitaciones_usuarios.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
  
<div class="card">
<div class="card-header pt-3">
    <h5>Generar una invitación</h5>
</div>
<div class="card-body">
    <form class="row" method="post" action="{{ route('invitaciones_usuarios.store') }}" enctype="multipart/form-data">
        @csrf
        <x-lista-mensajes/>
        <div class="row">
    
            <div class="col-12">
                <x-campo-formulario label="Ingresa el correo del usuario" id="correo" name="correo" type="text"  placeholder="Correo (verifica que esté bien escrito)" required="true" parentClass="col-12"/>
            </div>

            <label class="form-label">Basic</label>
			<input type="text" class="form-control" data-role="tagsinput" value="{{ implode(',',$roles) }}" name="roles">

            <x-boton nombre_boton="Enviar invitación" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
        </div>
    </form>
</div>
</div>
@endsection