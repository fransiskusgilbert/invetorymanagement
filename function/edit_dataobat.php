<?php
include '../database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$sqlQuery = mysqli_query($conn, "SELECT * FROM pegawai_tb WHERE id_pegawai = '" . $_SESSION['id'] . "' ");
$takeData = mysqli_fetch_object($sqlQuery);

$dataobat_id = $_GET['dataobat_id'];
$sqlGetObat = "SELECT * FROM dataobat_tb where dataobat_id = '$dataobat_id'";
$resultObat = mysqli_query($conn, $sqlGetObat);
$viewGetDataObat = mysqli_fetch_object($resultObat);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../homestyle.css">
    <!-- Icon CSS -->
    <script src="https://kit.fontawesome.com/604f0994f6.js" crossorigin="anonymous"></script>
    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <title>Edit Data Obat</title>
</head>

<body>
    <div class="container">
        <div class="nav-top">
            <div class="nav-head-img">
                <img src="../image/logo_navbar.png" alt="">
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
                <li><span><i class="fa-solid fa-house"></i></span><a href="../halaman_dashboard.php"
                        id="dashboardMenu">Dashboard</a></li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="../halaman_databarang.php">Data
                        Obat</a>
                </li>
                <li><span><i class="fa-regular fa-money-bill-1"></i></span><a href="../halaman_datapenjualan.php">Data
                        Penjualan</a></li>
                <li><span><i class="fa-solid fa-people-arrows"></i></span><a href="../halaman_dataperusahaan.php">Data
                        Perusahaan</a></li>
                <li><span><i class="fa-solid fa-user"></i></span><a href="../halaman_datapegawai.php">Data Pegawai</a>
                </li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="../halaman_databarangkeluar.php">Data
                        Barang Keluar</a></li>
                <li><span><i class="fa-solid fa-power-off"></i></span><a href="../login_proses/logout_proses.php"
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
                    <a href="../halaman_databarang.php">
                        <p>Data Obat</p>
                    </a>
                    <p> > </p>
                    <p> Edit data untuk batch : </p>
                    <p>
                        <?php echo $viewGetDataObat->dataobat_batch ?>
                    </p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Tabel Edit Data Obat</p>
                    </div>
                    <div class="form-update-dataobat">
                        <form action="" method="POST">
                            <div class="form-containerEditObat">
                                <div class="form-edit1">
                                    <div>
                                        <label for="dataObatBatch">Batch</label>
                                        <br>
                                        <input type="text" name="dataobat_batch"
                                            value="<?php echo $viewGetDataObat->dataobat_batch; ?>" id="dataObatBatch">
                                    </div>
                                    <div>
                                        <label for="dataObatNama">Nama Obat</label>
                                        <br>
                                        <input type="text" name="dataobat_namaObat"
                                            value="<?php echo $viewGetDataObat->dataobat_namaObat; ?>"
                                            id="dataObatNama">
                                    </div>
                                    <div>
                                        <label for="dataObatHargaModal">Harga Modal</label>
                                        <br>
                                        <input type="text" name="dataobat_hargaModal"
                                            value="<?php echo $viewGetDataObat->dataobat_hargaModal; ?>"
                                            id="dataObatHargaModal">
                                    </div>
                                    <div>
                                        <label for="dataObatHargaJual">Harga Jual</label>
                                        <br>
                                        <input type="text" name="dataobat_hargaJual"
                                            value="<?php echo $viewGetDataObat->dataobat_hargaJual; ?>"
                                            id="dataObatHargaJual">
                                    </div>
                                    <div>
                                        <label for="dataObatTglMasuk">Tanggal Masuk</label>
                                        <br>
                                        <input type="date" name="dataobat_tglMasuk"
                                            value="<?php echo $viewGetDataObat->dataobat_tglMasuk; ?>"
                                            id="dataObatTglMasuk">
                                    </div>
                                    <div>
                                        <label for="dataObatTglExpired">Tanggal Expired</label>
                                        <br>
                                        <input type="date" name="dataobat_tglExpired"
                                            value="<?php echo $viewGetDataObat->dataobat_tglExpired; ?>"
                                            id="dataObatTglExpired">
                                    </div>
                                </div>
                                <div class="form-edit2">
                                    <div>
                                        <label for="dataObatJlhMasuk">Jumlah Obat Masuk</label>
                                        <br>
                                        <input type="text" name="dataobat_jlhStockMasuk"
                                            value="<?php echo $viewGetDataObat->dataobat_jlhStockMasuk; ?>"
                                            id="dataObatJlhMasuk">
                                    </div>
                                    <div>
                                        <label for="dataObatFormat">Format Jumlah Obat</label>
                                        <br>
                                        <input type="text" name="dataobat_format"
                                            value="<?php echo $viewGetDataObat->dataobat_format; ?>"
                                            id="dataObatJlhMasuk" readonly>

                                    </div>
                                    <div>
                                        <label for="changeObatFormat">Ganti Format Jumlah Obat</label>
                                        <br>
                                        <select name="dataobat_format" id="changeObatFormat">
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
                                        <input type="text" name="perusahaan_kode"
                                            value="<?php echo $viewGetDataObat->perusahaan_kode; ?>" id="kodePerusahaan"
                                            readonly>
                                    </div>
                                    <div>
                                        <label for="changePerusahaanKode">Ganti Kode Perusahaan </label>
                                        <br>
                                        <select name="perusahaan_kode" id="changePerusahaanKode">
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
                                        <input type="submit" name="submit" id="updateButton" value="Update Data"
                                            onclick="return confirm('Apakah data sudah benar?')">
                                    </div>
                                </div>
                            </div>
                            <?php
                            $todayDate = date('Y-m-d');

                            // Format date in jakarta
                            date_default_timezone_set('Asia/Jakarta');
                            $timeStamp = date("Y-m-d H:i:s");
                            $pegawaiOnDuty = $_SESSION['user_login'];

                            if (isset($_POST["submit"])) {
                                $dataobat_batch = $_POST['dataobat_batch'];
                                $dataobat_namaObat = $_POST['dataobat_namaObat'];
                                $dataobat_hargaModal = $_POST['dataobat_hargaModal'];
                                $dataobat_hargaJual = $_POST['dataobat_hargaJual'];
                                $dataobat_tglMasuk = $_POST['dataobat_tglMasuk'];
                                $dataobat_tglExpired = $_POST['dataobat_tglExpired'];
                                $dataobat_jlhStockMasuk = $_POST['dataobat_jlhStockMasuk'];
                                $dataobat_format = $_POST['dataobat_format'];
                                $perusahaan_kode = $_POST['perusahaan_kode'];


                                // Query check duplicate data
                                $queryCheck = "SELECT * FROM dataobat_tb WHERE dataobat_batch = '$dataobat_batch'";
                                // Check validasi untuk memastikan data tidak boleh duplicate
                                $checkDuplicateEditDataObat = mysqli_num_rows(mysqli_query($conn, $queryCheck));
                                if (
                                    empty($dataobat_batch && $dataobat_namaObat && $dataobat_hargaModal && $dataobat_hargaJual && $dataobat_tglMasuk && $dataobat_tglExpired
                                    && $dataobat_jlhStockMasuk && $dataobat_format && $perusahaan_kode)
                                ) {
                                    echo "<script>alert('Data tidak boleh kosong!');</script>";
                                } else if ($checkDuplicateEditDataObat > 1) {
                                    echo "<script>alert('Data dengan batch tersebut sudah ada');</script>";
                                } else if (!is_numeric($dataobat_hargaModal)) {
                                    echo "<script>alert('Data harus angka!');</script>";
                                } else if (!is_numeric($dataobat_hargaJual)) {
                                    echo "<script>alert('Data harus angka!');</script>";
                                } else if (!is_numeric($dataobat_jlhStockMasuk)) {
                                    echo "<script>alert('Data harus angka!');</script>";
                                } else {
                                    $updateProses = mysqli_query($conn, 'UPDATE dataobat_tb
                                        SET 
                                        dataobat_batch = "' . $dataobat_batch . '",
                                        dataobat_namaObat ="' . $dataobat_namaObat . '" ,
                                        dataobat_hargaModal = "' . $dataobat_hargaModal . '",
                                        dataobat_hargaJual = "' . $dataobat_hargaJual . '",
                                        dataobat_tglMasuk = "' . $dataobat_tglMasuk . '",
                                        dataobat_tglExpired = "' . $dataobat_tglExpired . '",
                                        dataobat_jlhStockMasuk = "' . $dataobat_jlhStockMasuk . '",
                                        dataobat_format = "' . $dataobat_format . '",
                                        perusahaan_kode = "' . $perusahaan_kode . '"
                                    
                                        WHERE dataobat_id = ' . $viewGetDataObat->dataobat_id);
                                    if ($updateProses) {
                                        $logMessage = "Data berhasil diubah - Batch: $dataobat_batch, Nama Obat: $dataobat_namaObat, Harga Modal: $dataobat_hargaModal, Harga Jual: $dataobat_hargaJual, Tgl Masuk: $dataobat_tglMasuk, Tgl Expired: $dataobat_tglExpired, Jlh Stock Masuk: $dataobat_jlhStockMasuk, Format: $dataobat_format, Kode Perusahaan: $perusahaan_kode, Diubah oleh: $pegawaiOnDuty";
                                        mysqli_query($conn, "INSERT INTO logseditbarang_tb(logseditbarang_id, logseditbarang_description, logseditbarang_time) VALUES (NULL, '$logMessage', NOW())");
                                        echo "<script>alert('Data berhasil diubah'); window.location.href= '../halaman_databarang.php';</script>";
                                    } else {
                                        echo "Error :" . $updateProses . "<br>" . mysqli_error($conn);
                                    }
                                }
                            }

                            ?>
                        </form>
                    </div>
                </div>
            </div>

        </div>

    </div>
    </div>
    <!-- Content end -->
    </div>
</body>

</html>