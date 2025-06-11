@extends('sistema_cobros.descuentos.layouts.create_layout')
@section('content')

    @if(session('success'))
        <div class="alert alert-success border-0 bg-grd-success alert-dismissible fade show">
          <div class="d-flex align-items-center">
            <div class="font-35 text-white"><span class="material-icons-outlined fs-2">check_circle</span>
            </div>
            <div class="ms-3">
              <h6 class="mb-0 text-white">Operación exitosa</h6>
              <div class="text-white">{{ (session('success'))}}</div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
     @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
      @endif

<x-form-in-card titulo="Crear un nuevo descuento" route="descuentos.store">
    <div class="row">

    <x-campo-formulario id="nombre" label="Nombre de descuento" name="nombre" type="text" placeholder="Nombre del descuento" required="true" parentClass="col-12"/>
    
    <div class="col-12 mt-3">
        <label for="descripcion">Descripción de descuento</label>
         <textarea name="descripcion" id="descripcion" cols="30" rows="5" class="form-control mt-2" placeholder="Decribe a qué conceptos aplica este descuento, dá información descriptiva."></textarea>
    </div>

    <div class="col-6 pt-3">
        <label for="tasa">Tasa (en decimales: 0-1)</label>
        <input type="number" step="0.01" id="tasa" name="tasa" class="form-control" placeholder=".10">
    </div>
    <div class="col-6 pt-3">
        <label for="monto">Monto (Número entero)</label>
        <input type="number" step="25" id="monto" name="monto" class="form-control" placeholder="150">
    </div>

    <div class="col-12 pt-3">
      @php
          $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
      @endphp
      <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo" />
    </div>
    
    
          
  

    <x-boton nombre_boton="Agregar descuento" type="submit" classes="btn-submit btn btn-primary float-end" parentClass="col-12 pt-5 float-end"/>
    </div>
</x-form-in-card>

@endsection