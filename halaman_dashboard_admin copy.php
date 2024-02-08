<?php
include('database/db_koneksi.php');
session_start();

if (!isset($_SESSION["login_admin"])) {
    header("Location: index.php");
    exit;
}


// var_dump($_SESSION["user_pegawai"]);
?>
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

$graphArrayPenjualan = array();
$count = 0;
$takePenjualan = mysqli_query($conn, "SELECT * FROM datapenjualan_tb ORDER BY MONTH(datapenjualan_tglShift), YEAR(datapenjualan_tglShift) ASC");

while ($rows = mysqli_fetch_array($takePenjualan)) {
    $monthYear = date("M Y", strtotime($rows["datapenjualan_tglShift"]));

    // Check if the month is already in the $graphArray
    if (isset($graphArrayPenjualan[$monthYear])) {
        // If yes, add the totalPenjualan to the existing entry
        $graphArrayPenjualan[$monthYear]["y"] += $rows["datapenjualan_totalPenjualan"];
    } else {
        // If no, create a new entry for the month
        $graphArrayPenjualan[$monthYear]["label"] = $monthYear;
        $graphArrayPenjualan[$monthYear]["y"] = $rows["datapenjualan_totalPenjualan"];
    }
}
?>
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

$graphArrayBarang = array();
$count = 0;

$takePenjualan = mysqli_query($conn, "SELECT dataobat_namaObat, SUM(dataobat_jlhStockMasuk) as totalStock
                                      FROM dataobat_tb
                                      GROUP BY dataobat_namaObat");

while ($rows = mysqli_fetch_array($takePenjualan)) {
    $graphArrayBarang[$count]["label"] = $rows["dataobat_namaObat"];
    $graphArrayBarang[$count]["y"] = $rows["totalStock"];
    $count++;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <!-- Icon CSS -->
    <script src="https://kit.fontawesome.com/604f0994f6.js" crossorigin="anonymous"></script>
    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <title>Dashboard Admin</title>
    <script>
        window.onload = function () {
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

            chartBarang.render();
            chart.render();
        };

    </script>
</head>

<body>
    <div class="container">
        <div class="nav-top">
            <div class="nav-head-img">
                <img src="image/logo_navbar.png" alt="">
            </div>
            <p class="nav-text-describe">Sistem Persedian dan Penjualan Obat</p>
            <div class="nav-top-contents">
                <ul>
                    <li class="nav-bar-content" style="text-transform: uppercase;">Halo,
                        <?php echo $_SESSION['admin_login']; ?>
                    </li>
                    <li class="nav-bar-content" id="dateNow"></li>
                </ul>
            </div>
            <script src="dateFunction.js"></script>
        </div>
        <div class="nav-side">
            <ul>
                <li><span><i class="fa-solid fa-house"></i></span><a href="halaman_dashboard.php"
                        id="dashboardMenu">Dashboard</a></li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="halaman_databarang_logs.php">Log
                        Obat</a>
                </li>
                <li><span><i class="fa-regular fa-money-bill-1"></i></span><a href="halaman_datapenjualan_logs.php">Log
                        Penjualan</a></li>
                <li><span><i class="fa-solid fa-people-arrows"></i></span><a href="halaman_dataperusahaan_logs.php">Log
                        Perusahaan</a></li>
                <li><span><i class="fa-solid fa-user"></i></span><a href="halaman_datapegawai.php">Data Pegawai</a></li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a
                        href="halaman_databarangkeluar_logs.php">Log
                        Barang Keluar</a></li>
                <li><span><i class="fa-solid fa-power-off"></i></span><a href="login_proses/logout_proses.php"
                        onclick="return confirm('Apakah anda yakin ingin keluar?')">Keluar</a>
                </li>
            </ul>
        </div>
        <div class="dashboard-container" style="height: 200vh;">
            <div class="dashboard-header-container">
                <div class="dashboard-text">
                    <div class="text-logo">
                        <i class="fa-solid fa-house"></i>
                    </div>
                    <p>Dashboard Admin</p>
                </div>
            </div>
            <?php
            $sqlCount = "SELECT SUM(dataobat_jlhStockMasuk) as total FROM dataobat_tb";
            $takeCountDObat = mysqli_query($conn, $sqlCount);

            if ($takeCountDObat) {
                $result = mysqli_fetch_assoc($takeCountDObat);
                $totalObatMasuk = $result['total'];
            } else {
                $totalObatMasuk = "Error fetching count";
            }
            ?>
            <div class="content-wrapper">
                <div class="box-items">
                    <div class="item-desc">
                        <div class="text-desc">
                            <p>
                                <?php echo $totalObatMasuk; ?>
                            </p>
                            <p>Total Obat Masuk</p>
                        </div>
                        <div class="item-logo">
                            <i class="fa-solid fa-capsules"></i>
                        </div>
                    </div>
                    <a href="halaman_databarang.php" class="link-to">
                        <p>Lihat Data Obat</p>
                    </a>
                </div>
                <?php
                $sqlSumTotalPenjualan = "SELECT SUM(datapenjualan_totalPenjualan) as totalP FROM datapenjualan_tb";
                $sumQuery = mysqli_query($conn, $sqlSumTotalPenjualan);

                if ($sumQuery) {
                    $resultPenjualan = mysqli_fetch_assoc($sumQuery);
                    $totalSum = $resultPenjualan['totalP'];
                } else {
                    $totalSum = "Error fetching data";
                }
                ?>
                <div class="box-items">
                    <div class="item-desc">
                        <div class="text-desc">
                            <p style="font-size: 25px;">
                                <?php echo 'Rp ' . number_format($totalSum, 0, ',', '.'); ?>
                            </p>
                            <p>Total Penjualan</p>
                        </div>
                        <div class="item-logo">
                            <i class="fa-solid fa-cash-register"></i>
                        </div>
                    </div>
                    <a href="" class="link-to">
                        <p>Lihat Data Penjualan</p>
                    </a>
                </div>
                <?php
                $sqlCountPerusahaan = "SELECT COUNT(DISTINCT perusahaan_kode) as total from perusahaan_tb";
                $takeCountPerusahaan = mysqli_query($conn, $sqlCountPerusahaan);

                if ($takeCountPerusahaan) {
                    $resultPerusahan = mysqli_fetch_assoc($takeCountPerusahaan);
                    $totalPerusahaan = $resultPerusahan['total'];
                } else {
                    $totalPerusahaan = "Error fecthing data";
                }
                ?>
                <div class="box-items">
                    <div class="item-desc">
                        <div class="text-desc">
                            <p>
                                <?php echo $totalPerusahaan; ?>
                            </p>
                            <p>Jumlah Perusahaan</p>
                        </div>
                        <div class="item-logo">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <a href="" class="link-to">
                        <p>Lihat Data Perusahaan</p>
                    </a>
                </div>
                <?php

                $sqlCountOnlinePegawai = "SELECT COUNT(pegawai_status) as total_online from pegawai_tb WHERE pegawai_status = 1 AND rules = 'user'";
                $takeCountOnlinePegawai = mysqli_query($conn, $sqlCountOnlinePegawai);

                if ($takeCountOnlinePegawai) {
                    $resultPerusahan = mysqli_fetch_assoc($takeCountOnlinePegawai);
                    $totalOnlinePegawai = $resultPerusahan['total_online'];
                } else {
                    $totalOnlinePegawai = "Error fecthing data";
                }
                ?>
                <div class="box-items">
                    <div class="item-desc">
                        <div class="text-desc">
                            <p>
                                <?php echo $totalOnlinePegawai; ?>
                            </p>
                            <p>Pegawai Online</p>
                        </div>
                        <div class="item-logo">
                            <i class="fa-solid fa-users"></i>
                        </div>
                    </div>
                    <a href="" class="link-to">
                        <p>Lihat Data User Online</p>
                    </a>
                </div>
                <div id="graphObat" style="height: 200px; width: auto;"></div>
                <div id="chartContainer" style="height: 200px; width: 95%;"></div>
            </div>
            <script type="text/javascript" src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
            <!-- <div class="graph-container-admin">
                <div class="wrapperss">
                    <div id="graphObat" style="height: 200px; width: 40%;"></div>
                    <div id="chartContainer" style="height: 200px; width: 40%;"></div>
                </div>
            </div> -->
        </div>
    </div>
</body>

</html>