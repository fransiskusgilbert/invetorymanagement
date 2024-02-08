<?php
include './database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login_admin"])) {
    header("Location: index.php");
    exit;
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homestyle.css">
    <!-- Icon CSS -->
    <script src="https://kit.fontawesome.com/604f0994f6.js" crossorigin="anonymous"></script>
    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <title>Dashboard</title>
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
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="halaman_databarangkeluarlogs.php">Log
                        Barang Keluar</a></li>
                <li><span><i class="fa-solid fa-power-off"></i></span><a href="login_proses/logout_proses.php"
                        onclick="return confirm('Apakah anda yakin ingin keluar?')">Keluar</a>
                </li>
            </ul>
        </div>
        <!-- Content start -->
        <div class="dataobat-dashboard-container">
            <div class="dataobat-header-container">
                <div class="dataobat-dashboard-text">
                    <div class="obat-text-logo">
                        <i class="fa-regular fa-square-plus"></i>
                    </div>
                    <p>Data Obat</p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Tabel Data Obat</p>
                    </div>
                    <div class="dataobat-button-container">
                        <div class="dataobat-button-wrapper">
                            <button id="addDataObat" onclick="inputData()">Edit Data Obat Logs</button>
                        </div>
                        <div class="dataobat-button-wrapper">
                            <button id="addDataObat" onclick="inputData()">Hapus Data Obat Logs</button>
                        </div>
                        <div class="dataobat-form-searchwrapper">
                            <form action="function/search_dataobat.php">
                                <input type="date" name="cari" value="<?php echo htmlspecialchars($cari); ?>">
                                <input type="submit" value="Cari">
                            </form>
                        </div>
                        <div class="dataobat-button-export-excell">
                            <div class="dataobat-button-container-excell">
                                <a href="convert_dataobat_to_excell.php">Cetak Laporan</a>
                            </div>
                        </div>
                    </div>
                    <div class="showdata" id="showtable">
                        <?php
                        require("viewtable_databarang_logs.php")
                            ?>
                    </div>
                </div>
            </div>
            <!-- Content end -->
            <?php

            function () {
                    
            }
                ?>
        </div>
</body>

</html>