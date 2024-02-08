var chartBarang = new CanvasJS.Chart("graphObat", {
    title: {
        text: "Total Barang Masuk"
    },
    data: [{
        type: "column",
        dataPoints: <?php echo json_encode(array_values($graphArrayBarang), JSON_NUMERIC_CHECK); ?>
    }]
});

var chart = new CanvasJS.Chart("chartContainer", {
    title: {
        text: "Total Penjualan (Per bulan)"
    },
    data: [{
        type: "column",
        dataPoints: <?php echo json_encode(array_values($graphArrayPenjualan), JSON_NUMERIC_CHECK); ?>
    }]
});

chart.render();
chartBarang.render();
