<?php
include './database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login"])) {
    echo "<script>alert('Anda harus memiliki akses user!');</script>";
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
                            <button id="addDataObat" onclick="inputData()">Tambah Data</button>
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
                    <!-- Pop Up untuk Input Data Start -->
                    <div class="popUp" id="popUpAddData" style="display:none;">
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
                        <div class="form-control-add-data">
                            <form action="function/input_databarang.php" method="POST">
                                <div>
                                    <label for="batch">Batch</label>
                                    <br>
                                    <input type="text" name="dataobat_batch" id="batch">
                                </div>
                                <div>
                                    <label for="namaObat">Nama Obat</label>
                                    <br>
                                    <input type="text" name="dataobat_namaObat" id="namaObat">
                                </div>
                                <div>
                                    <label for="hargaModal">Harga Modal</label>
                                    <br>
                                    <input type="text" name="dataobat_hargaModal" id="hargaModal">
                                </div>
                                <div>
                                    <label for="hargaJual">Harga Jual</label>
                                    <br>
                                    <input type="text" name="dataobat_hargaJual" id="hargaJual">
                                </div>
                                <div>
                                    <label for="tglMasuk">Tanggal Masuk</label>
                                    <br>
                                    <input type="date" name="dataobat_tglMasuk" id="tglMasuk">
                                </div>
                                <div>
                                    <label for="tglExp">Tanggal Expired</label>
                                    <br>
                                    <input type="date" name="dataobat_tglExpired" id="tglExp">
                                </div>
                                <div>
                                    <label for="jlhStockMasuk">Jumlah Stock Masuk</label>
                                    <br>
                                    <input type="text" name="dataobat_jlhStockMasuk" id="jlhStockMasuk">
                                    <select name="dataobat_format" id="">
                                        <option disabled selected>--Pilih satuan--</option>
                                        <option value="Strip">Strip</option>
                                        <option value="Botol">Botol</option>
                                        <option value="Box">Box</option>
                                        <option value="Tube">Tube</option>
                                        <option value="Vial">Vial</option>
                                        <option value="Ampul">Ampul</option>
                                        <option value="Pot">Pot</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="kodePerusahaan">Kode Perusahaan</label>
                                    <br>
                                    <select name="perusahaan_kode" style="width:200px;" id="kodePerusahaan">
                                        <option disabled selected> Pilih Kode Perusahaan </option>
                                        <?php
                                        $fecthDataPerusahaan = mysqli_query($conn, "SELECT DISTINCT perusahaan_kode FROM perusahaan_tb");
                                        while ($showDataPerusahaanKode = mysqli_fetch_array($fecthDataPerusahaan)) {
                                            ?>
                                            <option value="<?= $showDataPerusahaanKode['perusahaan_kode'] ?>">
                                                <?= $showDataPerusahaanKode['perusahaan_kode'] ?>
                                            </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="namaPegawai">Pegawai yang bertugas</label>
                                    <br>
                                    <input type="text" name="nama_pegawai" id="namaPegawai" placeholder="Nama Pegawai"
                                        value="<?php echo $takeData->nama_pegawai; ?>" readonly>
                                </div>
                                <input type="submit" name="submit" id="submitBtn" value="Masukan Data Obat Masuk"
                                    onclick="return confirm('Apakah data sudah benar?');">
                            </form>
                        </div>
                        <script src="js/popInput.js"></script>
                        <script src="js/closePopBarang.js"></script>
                    </div>
                    <div class="showdata" id="showtable">
                        <?php
                        require("viewtable_databarang.php")
                            ?>
                    </div>
                </div>
            </div>
            <!-- Content end -->
        </div>
</body>

</html>