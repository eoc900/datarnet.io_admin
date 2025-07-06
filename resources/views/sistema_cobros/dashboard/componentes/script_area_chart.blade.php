async function loadAreaChart(arr,selector="") {
    {{-- const response = await fetch('/api/area-chart-data'); --}}
    const data = arr;

    var options = {
        series: [{ name: "Acumulado", data: data.datasets[0].data }],
        chart: { type: "area", height: 350 },
        xaxis: { categories: data.labels }
    };
    document.querySelector(selector).innerHTML = "";
    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}

function loadAreaChartExample(example,selector="") {
    if (!example || !example.datasets || !example.datasets[0]) {
        console.error("Los datos de la gráfica no están en el formato correcto", example);
        return;
    }
    const data = example;
    var options = {
        series: [{ name: "Acumulado", data: data.datasets[0].data }],
        chart: { type: "area", height: 350 },
        xaxis: { categories: data.labels }
    };

    document.querySelector(selector).innerHTML = "";
    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}

//loadAreaChart();
