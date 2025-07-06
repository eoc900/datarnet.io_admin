<div class="offset-md-2 col-md-8">
<div class="card shadow mt-5">
<div class="card-body ps-4 pe-4 pt-5">
    <h5 class="mb-4">{{ $titulo }}</h5>
    <form action="{{ ($accion=="edicion")? route($route, $obj->id):route($route) }}" method="post" id="{{ $id }}" enctype="multipart/form-data">
        @if ($accion=="edicion")
            @method('put')
        @endif
        @csrf
        {{ $slot }}
    </form>
 </div>
 </div>
 </div>