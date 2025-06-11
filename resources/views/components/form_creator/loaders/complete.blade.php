<div class="text-center">
    <h2 class="mb-3">{{ $heading ?? 'Procesando...' }}</h2>
    <p class="mb-4 text-muted">{{ $descripcion ?? 'Por favor espera mientras se completa la operación.' }}</p>
    <img src="{{ asset('dashboard_resources/assets/images/loaders/complete.png') }}" alt="Completado..." class="loader-gif">
  </div>
