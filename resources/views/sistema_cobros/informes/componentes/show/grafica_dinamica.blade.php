@php
    $chartId = 'grafica_' . uniqid();
    $config = $seccion["grafica"] ?? [];
    $datos = $seccion["resultados"] ?? collect();

    $tipo = $config['tipo'] ?? 'bar';
    $label = $config['label_columna'] ?? '';
    $valor = $config['valor_columna'] ?? '';
    $titulo = $config['titulo'] ?? 'Gráfica';
    $mostrarLeyenda = !empty($config['mostrar_leyenda']);
    $color = $config['color_personalizado'] ?? '#36A2EB';
    $stacked = !empty($config['stacked']);

 $labels = collect($datos)->map(fn($item) => $item->{$label} ?? null)->filter()->values()->toArray();


$valores = collect($datos)->map(function($item) use ($valor) {
    return $item->{$valor} ?? null;
})->filter()->values()->toArray();


@endphp

<div class="card">
    <div class="card-header pt-3">
        <h5>{{ $titulo }}</h5>
    </div>

    <div class="card-body mx-5 p-4 mb-5">
        @if(empty($valores))
            <div class="alert alert-warning text-center">No hay datos suficientes para mostrar esta gráfica.</div>
        @else
            <div id="{{ $chartId }}"></div>
        @endif
    </div>
</div>

@push('jquery_grafica')
@if(!empty($valores))
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const options = {
            series: [{
                name: @json($valor),
                data: @json($valores)
            }],
            chart: {
                type: '{{ $tipo }}',
                height: 350,
                @if($tipo === 'bar' || $tipo === 'line')
                stacked: {{ $stacked ? 'true' : 'false' }},
                @endif
            },
            labels: @json($tipo === 'pie' || $tipo === 'donut' ? $labels : []),
            xaxis: {
                categories: @json($tipo === 'bar' || $tipo === 'line' ? $labels : [])
            },
            colors: ['{{ $color }}'],
            title: {
                text: '{{ $titulo }}'
            },
            legend: {
                show: {{ $mostrarLeyenda ? 'true' : 'false' }}
            }
        };

        const chart = new ApexCharts(document.querySelector('#{{ $chartId }}'), options);
        chart.render();
    });
</script>
@endif
@endpush
