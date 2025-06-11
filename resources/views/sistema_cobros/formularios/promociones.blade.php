

@if ($accion=="edicion")
    <div class="container">
    <h1>Editar Promoción</h1>

    <form action="{{ route('promociones.update', $promocion->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $promocion->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="breve_descripcion" class="form-label">Breve Descripción</label>
            <input type="text" class="form-control" id="breve_descripcion" name="breve_descripcion" value="{{ old('breve_descripcion', $promocion->breve_descripcion) }}" required>
        </div>

        <div class="mb-3">
            <label for="banner_1200x700" class="form-label">Banner 1200x700</label>
            <input type="file" class="form-control" id="banner_1200x700" name="banner_1200x700">
            @if ($promocion->banner_1200x700)
                <img src="{{ asset('storage/' . $promocion->banner_1200x700) }}" alt="Banner 1200x700" class="img-fluid mt-2" width="200">
            @endif
        </div>

        <div class="mb-3">
            <label for="banner_300x250" class="form-label">Banner 300x250</label>
            <input type="file" class="form-control" id="banner_300x250" name="banner_300x250">
            @if ($promocion->banner_300x250)
                <img src="{{ Storage::url($promocion->banner_300x250); }}" alt="Banner 300x250" class="img-fluid mt-2" width="200">
            @endif
        </div>

        <div class="mb-3">
            <label for="inicia_en" class="form-label">Fecha de Inicio</label>
            <input type="datetime-local" class="form-control" id="inicia_en" name="inicia_en" value="{{ old('inicia_en', $promocion->inicia_en) }}" required>
        </div>

        <div class="mb-3">
            <label for="caducidad" class="form-label">Fecha de Caducidad</label>
            <input type="datetime-local" class="form-control" id="caducidad" name="caducidad" value="{{ old('caducidad', $promocion->caducidad) }}" required>
        </div>

        <div class="col-6 pt-3">
            @php
                $opciones = array(["id"=>0,"option"=>"Desactivado"],["id"=>1,"option"=>"Activo"])
            @endphp
            <x-dropdown-formulario label="Asignar como" id="activo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="activo"  :selected="$promocion->activo"/>
        </div>

        <div class="col-12 pt-3">
        @php
            $opciones = array(["id"=>"fijo","option"=>"Fijo Parcial"],["id"=>"porcentaje","option"=>"Tasa porcentaje"],);
        @endphp
        <x-dropdown-formulario label="Tipo de promoción" id="tipo" :options="$opciones" value-key="id" option-key="option" simpleArray="true" name="tipo" :selected="$promocion->tipo"/>
        </div>
    

        <button type="submit" class="btn btn-primary">Actualizar Promoción</button>
    </form>
</div>
@endif