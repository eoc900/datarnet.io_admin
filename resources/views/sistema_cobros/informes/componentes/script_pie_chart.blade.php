function loadPieChart(arr,selector="") {
  
    const data = arr;

    var options = {
        series: data.datasets[0].data,
        chart: { type: "pie", height: 350 },
        labels: data.labels
    };

    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}

function loadPieChartExample(example,selector="") {
     if (!example || !example.datasets || !example.datasets[0]) {
        console.error("Los datos de la gráfica no están en el formato correcto", example);
        return;
    }
    const data = example;
    var options = {
        series: data.datasets[0].data,
        chart: { type: "pie", height: 350 },
        labels: data.labels
    };
    $(selector).html("");
    var chart = new ApexCharts(document.querySelector(selector), options);
    chart.render();
}


