<div class="condicion grupo-condiciones border p-3 mb-3 shadow mt-2" data-tipo="grupo" data-index="{{ $index }}">
    @if($index > 0)
        <select name="where_logico_grupal[]" class="form-select mb-2" style="max-width: 100px;">
            <option value="AND">AND</option>
            <option value="OR">OR</option>
        </select>
    @endif

    <div class="contenido-grupo">
        {{-- Aquí irán condiciones simples agregadas dinámicamente --}}
    </div>
    <div class="mt-2 d-flex justify-content-between">
        <button type="button" class="btn btn-sm btn-outline-primary agregar-condicion-simple-grupo" data-index="{{ $index }}">+ condición</button>
        <button type="button" class="btn btn-sm btn-outline-danger eliminar-grupo">× eliminar grupo</button>
    </div>
</div>
