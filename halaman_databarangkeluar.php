<?php
include './database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$sqlQuery = mysqli_query($conn, "SELECT * FROM pegawai_tb WHERE id_pegawai = '" . $_SESSION['id'] . "' ");
$takeData = mysqli_fetch_object($sqlQuery);

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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <title>Dashboard</title>
    <script>
        function updateSisaStock() {
            // Get the values from the input fields
            var databarangkeluar_stockAwal = parseFloat(document.getElementById("stockAwal").value) || 0;
            var databarangkeluar_stockKeluar = parseFloat(document.getElementById("stockKeluar").value) || 0;

            // Calculate the total penjualan
            var databarangkeluar_sisaStock = databarangkeluar_stockAwal - databarangkeluar_stockKeluar;

            // Update the value in the totalPenjualan input field
            document.getElementById("stockSisa").value = databarangkeluar_sisaStock;
        }

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
                    <ul>
                        <li class="nav-bar-content" style="text-transform: uppercase;">Halo,
                            <?php echo $_SESSION['user_login']; ?>
                        </li>
                        <li class="nav-bar-content" id="dateNow"></li>
                    </ul>
                </ul>
            </div>
            <script src="dateFunction.js"></script>
        </div>
        <div class="nav-side">
            <ul>
                <li><span><i class="fa-solid fa-house"></i></span><a href="halaman_dashboard.php"
                        id="dashboardMenu">Dashboard</a></li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="halaman_databarang.php">Data Obat</a>
                </li>
                <li><span><i class="fa-regular fa-money-bill-1"></i></span><a href="halaman_datapenjualan.php">Data
                        Penjualan</a></li>
                <li><span><i class="fa-solid fa-people-arrows"></i></span><a href="halaman_dataperusahaan.php">Data
                        Perusahaan</a></li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="halaman_databarangkeluar.php">Data
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
                    <p>Data Obat Keluar</p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Tabel Data Obat Keluar</p>
                    </div>
                    <div class="dataobat-button-container">
                        <div class="dataobat-button-wrapper">
                            <button id="addDataObat" onclick="inputData()">Tambah Data</button>
                        </div>
                        <div class="dataobat-form-searchwrapper">
                            <form action="function/search_dataobat_keluar.php">
                                <input type="date" name="cari" value="<?php echo htmlspecialchars($cari); ?>">
                                <input type="submit" value="Cari">
                            </form>
                        </div>
                        <div class="dataobat-button-export-excell">
                            <div class="dataobat-button-container-excell">
                                <a href="convert_dataobatkeluar_to_excell.php">Cetak Laporan</a>
                            </div>
                        </div>
                    </div>
                    <!-- Pop Up untuk Input Data Start -->
                    <div class="popUp" id="popUpAddData" style="display:none; height:350px;">
                        <div class="pop-header-container">
                            <p>Form Tambah Data Obat Keluar</p>
                        </div>
                        <div class="popUp-button-control">
                            <button class="closePopUp" id="closePopUp" onclick="closePopUp()"> x</button>
                        </div>
                        <div class="form-control-add-data">
                            <form action="function/input_databarangkeluar.php" method="POST">
                                <div>
                                    <label for="namaObat">Nama Obat</label>
                                    <br>
                                    <select name="databarangkeluar_nama" id="namaObat">
                                        <option disabled selected>--Pilih Nama Obat--</option>
                                        <?php
                                        $sqlTakeDataObatNama = "SELECT DISTINCT dataobat_namaObat FROM dataobat_tb";
                                        $fetchDataObatNama = mysqli_query($conn, $sqlTakeDataObatNama);

                                        while ($showDataObatNama = mysqli_fetch_array($fetchDataObatNama)) {
                                            ?>
                                            <option value="<?= $showDataObatNama['dataobat_namaObat'] ?> ">
                                                <?= $showDataObatNama['dataobat_namaObat'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="stockAwal">Stock Awal</label>
                                    <br>
                                    <input type="text" name="databarangkeluar_stockAwal" id="stockAwal"
                                        oninput="updateSisaStock()" readonly>
                                </div>
                                <div>
                                    <label for="stockKeluar">Barang keluar</label>
                                    <br>
                                    <input type="text" name="databarangkeluar_stockKeluar" id="stockKeluar"
                                        oninput="updateSisaStock()">
                                </div>
                                <div>
                                    <label for="stockSisa">Sisa Stock</label>
                                    <br>
                                    <input type="text" name="sisaStock" id="stockSisa" oninput="updateSisaStock()"
                                        readonly>
                                </div>
                                <div>
                                    <label for="tglUpdate">Tanggal Update</label>
                                    <br>
                                    <input type="date" name="databarangkeluar_tanggal" id="tglUpdate">
                                </div>
                                <input type="submit" name="submitPenjualan" id="submitBtn"
                                    value="Masukan Data Obat Keluar"
                                    onclick="return confirm('Apakah data sudah benar?');">
                            </form>
                        </div>
                        <script>
                            $(document).ready(function () {
                                $("#namaObat").change(function () {
                                    var selectedObat = $(this).val();

                                    $.ajax({
                                        url: "get_stock.php",
                                        type: "POST",
                                        data: { dataobat_namaObat: selectedObat },
                                        success: function (response) {
                                            $("#stockAwal").val(response);
                                        }
                                    });
                                });
                            });
                        </script>
                        <script src="js/popInput.js"></script>
                        <script src="js/closePopBarangKeluar.js"></script>
                    </div>
                    <div class="showdata" id="showtable">
                        <?php
                        require("viewtable_databarangkeluar.php")
                            ?>
                    </div>
                </div>
            </div>
            <!-- Content end -->
        </div>
</body>

</html>