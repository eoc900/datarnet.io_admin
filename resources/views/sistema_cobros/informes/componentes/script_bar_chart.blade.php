{{-- Cargando con apexcharts --}}

function loadBarChart(arr,selector="") {
    {{-- const response = await fetch('/api/bar-chart-data'); --}}
    const data = arr;

    var options = {
        series: [{ name: "Cantidad", data: data.datasets[0].data }],
        chart: { type: "bar", height: 350 },
        xaxis: { categories: data.labels }
    };

    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}

{{-- function loadBarChartExample(example,selector="") {
    console.log("loadBarChartExample");
    if (!example || !example.datasets || !example.datasets[0]) {
        console.error("Los datos de la gráfica no están en el formato correcto", example);
        return;
    }
    const data = example;

    var options = {
        series: [{ name: "Cantidad", data: data.datasets[0].data }],
        chart: { type: "bar", height: 350 },
        xaxis: { categories: data.labels }
    };

    console.log(options);

     document.querySelector(selector).innerHTML = "";
    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
} --}}



function loadBarChartExample(example, selector = "") {
    console.log("loadBarChartExample");
    if (!example || !example.datasets || !example.datasets[0]) {
        console.error("Los datos de la gráfica no están en el formato correcto", example);
        return;
    }
    const data = example;

    var options = {
        series: [{ name: "Cantidad", data: data.datasets[0].data }],
        chart: { type: "bar", height: 350 },
        xaxis: { categories: data.labels }
    };

    console.log(options); // Verifica las opciones en la consola

    document.querySelector(selector).innerHTML = "";
    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}





