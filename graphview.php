<?php
include('database/db_koneksi.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php
    $dataPoints = array(
        array("y" => 3373.64, "label" => "Germany"),
        array("y" => 2435.94, "label" => "France"),
        array("y" => 1842.55, "label" => "China"),
        array("y" => 1828.55, "label" => "Russia"),
        array("y" => 1039.99, "label" => "Switzerland"),
        array("y" => 765.215, "label" => "Japan"),
        array("y" => 612.453, "label" => "Netherlands")
    );

    $graphArray = array();
    $count = 0;
    $takePenjualan = mysqli_query($conn, "SELECT * FROM datapenjualan_tb ORDER BY MONTH(datapenjualan_tglShift), YEAR(datapenjualan_tglShift) ASC");

    while ($rows = mysqli_fetch_array($takePenjualan)) {
        $monthYear = date("M Y", strtotime($rows["datapenjualan_tglShift"]));

        // Check if the month is already in the $graphArray
        if (isset($graphArray[$monthYear])) {
            // If yes, add the totalPenjualan to the existing entry
            $graphArray[$monthYear]["y"] += $rows["datapenjualan_totalPenjualan"];
        } else {
            // If no, create a new entry for the month
            $graphArray[$monthYear]["label"] = $monthYear;
            $graphArray[$monthYear]["y"] = $rows["datapenjualan_totalPenjualan"];
        }
    }
    ?>

    <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                title: {
                    text: "Total Penjualan (Per bulan)"
                },
                data: [{
                    type: "column",
                    dataPoints: <?php echo json_encode(array_values($graphArray), JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
    <div id="chartContainer" style="height: 200px; width: 40%;"></div>

</body>

</html>