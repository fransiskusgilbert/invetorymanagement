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
    <title>Halaman Data Penjualan</title>
    <script>
        function updateTotalPenjualan() {
            // Get the values from the input fields
            var datapenjualan_kredit = parseFloat(document.getElementById('tagihanKredit').value) || 0;
            var datapenjualan_cash = parseFloat(document.getElementById('tagihanCash').value) || 0;
            var datapenjualan_omzet = parseFloat(document.getElementById('omzet').value) || 0;

            // Calculate the total penjualan
            var datapenjualan_totalPenjualan = datapenjualan_omzet - (datapenjualan_kredit + datapenjualan_cash);

            // Update the value in the totalPenjualan input field
            document.getElementById('totalPenjualan').value = datapenjualan_totalPenjualan;
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
                    <li class="nav-bar-content" style="text-transform: uppercase;">Halo,
                        <?php echo $_SESSION['user_login']; ?>
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
                    <p>Data Cash Flow</p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Tabel Data Cash Flow</p>
                    </div>
                    <div class="dataobat-button-container">
                        <div class="dataobat-button-wrapper">
                            <button id="addDataObat" onclick="inputData()">Tambah Data</button>
                        </div>
                        <div class="dataobat-form-searchwrapper">
                            <form action="function/search_datapenjualan.php">
                                <input type="date" name="cari">
                                <input type="submit" value="Cari">
                            </form>
                        </div>
                        <div class="dataobat-button-export-excell">
                            <div class="dataobat-button-container-excell">
                                <a href="convert_datapenjualan_to_excell.php">Cetak Laporan</a>
                            </div>
                        </div>
                    </div>
                    <!-- Pop Up untuk Input Data Start -->
                    <div class="popUp-penjualan" id="popUpAddData" style="display:none;">
                        <div class="pop-header-container">
                            <p>Form Tambah Data</p>
                        </div>
                        <div class="popUp-button-control">
                            <button class="closePopUp" id="closePopUp" onclick="closePopUp()"> x</button>
                        </div>
                        <!-- Form add data -->
                        <!-- Take data form data perusahaan -->
                        <?php
                        $injectQueryPerusahaan = mysqli_query($conn, "SELECT * FROM perusahaan_tb ");
                        $receiveDataPerusahaan = mysqli_fetch_object($injectQueryPerusahaan);
                        ?>
                        <div class="form-control-add-data-penjualan">
                            <form action="function/input_datapenjualan.php" method="POST">
                                <div>
                                    <label for="tagihanKredit">Tagihan Kredit</label>
                                    <br>
                                    <input type="text" name="datapenjualan_kredit" id="tagihanKredit"
                                        oninput="updateTotalPenjualan()">
                                </div>
                                <div>
                                    <label for="tagihanCash">Tagihan Cash</label>
                                    <br>
                                    <input type="text" name="datapenjualan_cash" id="tagihanCash"
                                        oninput="updateTotalPenjualan()">
                                </div>
                                <div>
                                    <label for="omzet">Total Omzet</label>
                                    <br>
                                    <input type="text" name="datapenjualan_omzet" id="omzet"
                                        oninput="updateTotalPenjualan()">
                                </div>

                                <div>
                                    <label for="totalPenjualan">Total Penjualan</label>
                                    <br>
                                    <input type="text" name="datapenjualan_totalPenjualan" id="totalPenjualan" readonly>
                                </div>
                                <div>
                                    <label for="shift">Shift</label>
                                    <br>
                                    <select name="datapenjualan_shift" id="shift">
                                        <option disabled selected>--Pilih Shift--</option>
                                        <option value="shift1">Pagi - Sore </option>
                                        <option value="shift2">Sore - Malam </option>
                                    </select>
                                </div>
                                <div>
                                    <label for="tglShift">Tanggal Penjualan</label>
                                    <br>
                                    <input type="date" name="datapenjualan_tglShift" id="tglShift">
                                </div>
                                <div>
                                    <label for="namaPegawaiPenjualan">Pegawai yang bertugas</label>
                                    <br>
                                    <input type="text" name="nama_pegawai" id="namaPegawaiPenjualan"
                                        placeholder="Nama Pegawai" value="<?php echo $takeData->nama_pegawai; ?>"
                                        readonly>
                                </div>
                                <input type="submit" name="submit" id="submitBtn-penjualan"
                                    value="Masukan Data Penjualan"
                                    onclick="return confirm('Apakah data sudah benar?');">
                            </form>
                        </div>
                        <script src="js/popInput.js"></script>
                        <script src="js/closePopPenjualan.js"></script>
                    </div>
                    <div class="showdata" id="showtable">
                        <?php
                        require("viewtable_datapenjualan.php")
                            ?>
                    </div>
                </div>
            </div>
            <!-- Content end -->
        </div>
</body>

</html>