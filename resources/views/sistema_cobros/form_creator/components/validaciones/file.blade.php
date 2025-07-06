<div class="col-md-6">
    <label class="form-label text-muted">Tamaño máximo (KB)</label>
    <input type="number" name="reglas[{{ $index }}][max]" class="form-control" placeholder="Ej. 2048">
</div>
<div class="col-md-6">
    <label class="form-label text-muted">Extensiones permitidas (mimes)</label>
    <input type="text" name="reglas[{{ $index }}][mimes]" class="form-control" placeholder="jpg,png,webp">
</div>