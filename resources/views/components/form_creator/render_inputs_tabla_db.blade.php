
@if (isset($columnas))

<input type="hidden" name="tabla_enlazada_inputs" value="true">

@foreach($columnas as $columna)


<div class="card">
    <div class="card-body d-flex">
        <div class="btn-group">
            <button type="button" class="btn btn-outline-primary">{{ $columna["nombre"] }}</button>
            <button type="button" class="btn btn-dark">Tipo Dato: {{ $columna["tipo"] }}</button>
        </div>
        @include('components.form_creator.dropdown_select_input_type')
    </div>
</div>


@endforeach
@endif

