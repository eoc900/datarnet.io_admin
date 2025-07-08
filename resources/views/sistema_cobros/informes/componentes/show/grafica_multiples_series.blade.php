@php
    $chartId = 'grafica_' . uniqid();
    $config = $seccion["grafica"] ?? [];
    $datos = $seccion["resultados"] ?? collect();

    $tipo = $config['tipo'] ?? 'bar';
    $label = $config['label_columna'] ?? '';
    $label = Str::contains($label, '.') ? Str::after($label, '.') : $label;
    $series = $config['series'] ?? [];
    $titulo = $config['titulo'] ?? 'Gráfica';
    $mostrarLeyenda = !empty($config['mostrar_leyenda']);
    $color = $config['color_personalizado'] ?? ['#36A2EB']; // por defecto, como array
    $color = is_array($color) ? $color : (Str::contains($color, ',') ? explode(',', $color) : [$color]);

    $stacked = !empty($config['stacked']);

    $labels = collect($datos)->map(fn($item) => $item->{$label} ?? null)->filter()->values()->toArray();

    if (in_array($tipo, ['pie', 'donut'])) {
        $valores = collect($datos)->map(fn($item) => $item->{$series[0]} ?? 0)->values()->toArray();
        $labelsData = $labels;
        $seriesData = $valores;
        $xaxisData = [];
        $stackedData = false;
        $coloresData = collect($labels)->map(fn($_, $i) => "hsl(" . ($i * 90) . ", 85%, 40%)")->values()->toArray();
    } else {
        $labelsData = [];
        $xaxisData = $labels;
        $stackedData = $stacked;
        $coloresData = $color;
        $seriesData = collect($series)->map(function ($serieCol) use ($datos) {
            return [
                'name' => $serieCol,
                'data' => collect($datos)->map(fn($item) => $item->{$serieCol} ?? 0)->values()->toArray()
            ];
        })->toArray();
    }


@endphp


<div class="col-md-{{ $seccion["col"] }}">
<div class="card bg-light shadow">
    <div class="card-header pt-3">
        <h5>{{ $titulo }}</h5>
    </div>

    <div class="card-body mx-5 p-4 mb-5">
        @if(empty($labels) || empty($seriesData))
            <div class="alert alert-warning text-center">No hay datos suficientes para mostrar esta gráfica.</div>
        @else
            <div id="{{ $chartId }}"></div>
        @endif

    </div>
</div>
</div>

@push('jquery_grafica')
@if(!empty($seriesData))
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
        @if(in_array($tipo, ['pie', 'donut']))
        labels: @json($labelsData),
        colors: @json($coloresData),
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
                const percent = val.toFixed(1);
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
        xaxis: {
            categories: @json($xaxisData)
        },
        colors: @json($coloresData),
        legend: {
            show: {{ $mostrarLeyenda ? 'true' : 'false' }}
        }
        @endif,
        title: {
            text: '{{ $titulo }}'
        }
    };

    const chart = new ApexCharts(document.querySelector('#{{ $chartId }}'), options);
    chart.render();
});
</script>
@endif
@endpush
