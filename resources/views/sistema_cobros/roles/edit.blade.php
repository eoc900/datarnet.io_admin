@extends('general.layouts.index')
@section("content")

@include('components.sistema_cobros.response')
<x-form-in-card titulo="Editar rol" route="roles.update" accion="edicion" :obj="$obj">
    <x-lista-mensajes/>
    <div class="row">      
        <div class="form-group">
                <div class="col-12">
                    <label for="" class="form-label"></label>
                    <input type="text" class="form-control" name="name" value="{{ $obj->name??'' }}" placeholder="Nombre del rol" required="true" parentClass="col-12">            
                </div>            
        </div> 
        <div class="col-12 mt-5 ps-5">
            @foreach ($permisos as $permiso)
                <div>
                    <label>
                        <input type="checkbox" name="permisos[]" value="{{ $permiso->id }}"
                            @if(in_array($permiso->id, $rolPermisos)) checked @endif>
                        {{ $permiso->name }}
                    </label>
                </div>
            @endforeach
        </div>           
        <x-boton nombreBoton="Editar nombre del rol" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
    </div>
</x-form-in-card>


@endsection