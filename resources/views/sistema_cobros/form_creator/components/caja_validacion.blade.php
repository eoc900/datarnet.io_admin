<div class="caja-validacion border border-primary rounded p-3 mt-4 shadow-sm bg-light-subtle row g-3" data-index="{{ $index ?? '' }}">
    <div class="col-12">
        <h6 class="text-primary fw-bold mb-3">
            <i class="bi bi-shield-check me-1"></i> Validaciones para este campo
        </h6>
    </div>

    @include('sistema_cobros.form_creator.components.validaciones_basicas', ["index" => $index ?? ''])

    <div class="valores_reglas_contenedor col-12 mt-2">
        {{-- Se poblará con llamada AJAX cada que haya un cambio en select .tipos_reglas --}}
    </div>
</div>
