<div class="row">
    <form action="{{ url($urlRoute) }}" id="formSearch">
        @method('GET')
        @csrf
        <div class="row">
        <div class="col-md-5">
            <div class="position-relative d-flex justify-content-start mt-5">
                <input class="form-control px-5 " type="search" placeholder="{{ $placeholder }}" id="{{ $idInputSearch }}" value="{{ $value }}" name="search">
                <span class="material-icons-outlined position-absolute ms-3 translate-middle-y start-0 top-50 fs-5">search</span>
                <button class="btn btn-primary" id="{{ $idBotonBuscar }}">{{ $botonBuscar }}</button>
            </div>
        </div>

        @if(count($filtrosBusqueda)>0)
        <div class="col-md-5 offset-md-2">
        <div class="d-flex align-items-center gap-2 justify-content-lg-end mt-3">
             <div class="input-group position-relative justify-content-start mb-3 d-flex">
                  <x-dropdown-formulario label="Buscar por" id="filtroBusqueda" :options="$filtrosBusqueda" value-key="key" option-key="option" simpleArray="true" name="filtro" />
            </div>
        </div>
        </div>   
        @endif
        </div>
    </form>
</div>

<h3>{{ $tituloTabla }}</h3>