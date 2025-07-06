<div class="col-md-6">
    <label class="form-label text-muted">Valor mínimo</label>
    <input type="number" step="any" name="reglas[{{ $index }}][min]" class="form-control" placeholder="Ej. 0">
</div>
<div class="col-md-6">
    <label class="form-label text-muted">Valor máximo</label>
    <input type="number" step="any" name="reglas[{{ $index }}][max]" class="form-control" placeholder="Ej. 100">
</div>
<div class="col-md-6">
    <label class="form-label text-muted">Dígitos exactos</label>
    <input type="number" name="reglas[{{ $index }}][digits]" class="form-control" placeholder="Ej. 4">
</div>
<div class="col-md-6">
    <label class="form-label text-muted">Dígitos entre</label>
    <input type="text" name="reglas[{{ $index }}][digits_between]" class="form-control" placeholder="Ej. 2,5">
</div>
