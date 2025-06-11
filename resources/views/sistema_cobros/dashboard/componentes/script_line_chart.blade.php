async function loadLineChart(arr,selector="") {
    const data = arr;

    var options = {
        series: [{ name: "Tendencia", data: data.datasets[0].data }],
        chart: { type: "line", height: 350 },
        xaxis: { categories: data.labels }
    };

    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}

function loadLineChartExample(example,selector="") {

    if (!example || !example.datasets || !example.datasets[0]) {
        console.error("Los datos de la gráfica no están en el formato correcto", example);
        return;
    }
    const data = example;
    var options = {
        series: [{ name: "Tendencia", data: data.datasets[0].data }],
        chart: { type: "line", height: 350 },
        xaxis: { categories: data.labels }
    };
    document.querySelector(selector).innerHTML = "";
    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}