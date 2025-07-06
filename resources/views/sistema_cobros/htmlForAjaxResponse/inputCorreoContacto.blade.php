@if($tipos_correos)

    <div class="multiple_inputs shadow mt-3">
        <button type="button" class="remove_inputs btn btn-danger"><i class="lni lni-trash"></i></button>
        <label class="mt-4">Correo del contacto</label>
        <input type="text" name='correo[]' class="form-control">
        <label class="mt-4">Seleccionar la categoría para este correo</label>
        <select name="tipo_correo[]" class="form-control">
        @foreach ($tipos_correos as $tipo_correo)
            <option value="{{ $tipo_correo->id }}">{{ $tipo_correo->tipo_correo }}</option>
        @endforeach
        </select>
    </div>
@endif