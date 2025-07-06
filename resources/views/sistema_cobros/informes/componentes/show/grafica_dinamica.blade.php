@php
    $chartId = 'grafica_' . uniqid();
    $config = $seccion["grafica"] ?? [];
    $datos = $seccion["resultados"] ?? collect();

    $tipo = $config['tipo'] ?? 'bar';
    $label = $config['label_columna'] ?? '';
    $label = Str::contains($label, '.') ? Str::after($label, '.') : $label;
    $valor = $config['valor_columna'] ?? '';
    $titulo = $config['titulo'] ?? 'Gráfica';
    $mostrarLeyenda = !empty($config['mostrar_leyenda']);
    $color = $config['color_personalizado'] ?? '#36A2EB';
    $stacked = !empty($config['stacked']);
    

    $labels = collect($datos)->map(fn($item) => $item->{$label} ?? null)->filter()->values()->toArray();
    $valores = collect($datos)->map(function($item) use ($valor) {
        return $item->{$valor} ?? null;
    })->filter()->values()->toArray();
    $seriesData = in_array($tipo, ['pie', 'donut'])
        ? $valores
        : [['name' => $valor, 'data' => $valores]];

    $labelsData = in_array($tipo, ['pie', 'donut']) ? $labels : [];
    $xaxisData = in_array($tipo, ['bar', 'line']) ? $labels : [];
    $stackedData = in_array($tipo, ['bar', 'line']) ? $stacked : false;

    // Generar colores distintos si es tipo pie/donut
    $coloresData = in_array($tipo, ['pie', 'donut'])
        ? collect($labelsData)->map(fn($_, $i) => "hsl(" . ($i * 90) . ", 85%, 40%)")->values()->toArray()
        : [$color];


@endphp

<div class="col-md-{{ $seccion["col"] }}">
<div class="card bg-light shadow">
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
</div>

@push('jquery_grafica')
@if(!empty($valores))
<script>
document.addEventListener("DOMContentLoaded", function () {
    const options = {
        series: @json($seriesData),
        chart: {
            type: '{{ $tipo }}',
            height: 350,
            @if(in_array($tipo, ['bar', 'line']))
            stacked: @json($stackedData),
            @endif
        },
        labels: @json($labelsData),
        xaxis: {
            categories: @json($xaxisData)
        },
        colors: @json($coloresData),
        title: {
            text: '{{ $titulo ?? 'Gráfica' }}'
        },
        @if(in_array($tipo, ['pie', 'donut']))
        legend: {
            show: {{ $mostrarLeyenda ? 'true' : 'false' }},
            formatter: function (seriesName, opts) {
                return opts.w.globals.labels[opts.seriesIndex];
            }
        },
        dataLabels: {
        enabled: true,
            formatter: function (val, opts) {
                const label = opts.w.globals.labels[opts.seriesIndex];
                const percent = val.toFixed(1); // cambia a .toFixed(0) si no quieres decimales
                return `${label}: ${percent}%`;
            }
        },
        tooltip: {
            y: {
                formatter: function (val, opts) {
                    const label = opts.w.globals.labels[opts.seriesIndex];
                    const percent = val.toFixed(1);
                    return `${label}: ${percent}%`;
                }
            }
        }
        @else
        legend: {
            show: {{ $mostrarLeyenda ? 'true' : 'false' }}
        }
        @endif
    };

    const chart = new ApexCharts(document.querySelector('#{{ $chartId }}'), options);
    chart.render();
});
</script>




@endif
@endpush
