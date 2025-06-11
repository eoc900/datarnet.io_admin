@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@if(session('mensajes'))
<div class="alert alert-info">
    @foreach ( session('mensajes') as $mensaje)
        @if ($mensaje["type"]=="success")
            <p><span class="text-success me-5"><i class="fadeIn animated bx bx-caret-right"></i></span>{{ $mensaje["message"] }}</p>
        @endif
        @if ($mensaje["type"]=="error")
            <p><span class="text-danger me-5"><i class="fadeIn animated bx bx-upside-down"></i></span>{{ $mensaje["message"] }}</p>
        @endif
    @endforeach
</div>
@endif