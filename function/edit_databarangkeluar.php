<?php
include '../database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$sqlQuery = mysqli_query($conn, "SELECT * FROM pegawai_tb WHERE id_pegawai = '" . $_SESSION['id'] . "' ");
$takeData = mysqli_fetch_object($sqlQuery);

$databarangkeluar_id = $_GET['databarangkeluar_id'];
$sqlGetObatKeluar = "SELECT * FROM dataobatkeluar_tb where databarangkeluar_id = '$databarangkeluar_id'";
$resultObatKeluar = mysqli_query($conn, $sqlGetObatKeluar);
$viewGetDataObatKeluar = mysqli_fetch_object($resultObatKeluar);
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
    <title>Edit Data Obat Keluar</title>
    <script>
        function updateSisaStock() {
            // Get the values from the input fields
            var databarangkeluar_stockAwal = parseFloat(document.getElementById("editStockAwal").value) || 0;
            var databarangkeluar_stockKeluar = parseFloat(document.getElementById("editStockKeluar").value) || 0;

            // Calculate the total penjualan
            var databarangkeluar_sisaStock = databarangkeluar_stockAwal - databarangkeluar_stockKeluar;

            // Update the value in the totalPenjualan input field
            document.getElementById("editSisaStock").value = databarangkeluar_sisaStock;
        }

    </script>
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
                    <li class="nav-bar-content">Halo,
                        <?php echo $_SESSION['user_login']; ?>
                    </li>
                    <li class="nav-bar-content" id="dateNow"></li>
                </ul>
            </div>
            <script src="../dateFunction.js"></script>
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
                <li><span><i class="fa-solid fa-power-off"></i></span><a
                        href="../login_proses/logout_proses.php">Keluar</a></li>
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
                        <p>Data Obat Keluar</p>
                    </a>
                    <p> > </p>
                    <p> Edit data untuk nama obat : </p>
                    <p>
                        <?php echo $viewGetDataObatKeluar->databarangkeluar_nama ?>
                    </p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Tabel Edit Data Obat Keluar</p>
                    </div>
                    <div class="form-update-dataobat">
                        <form action="" method="POST">
                            <div class="form-containerEditObat">
                                <div class="form-edit1">
                                    <div>
                                        <label for="keluarNama">Nama Obat </label>
                                        <br>
                                        <input type="text" name="databarangkeluar_nama"
                                            value="<?php echo $viewGetDataObatKeluar->databarangkeluar_nama; ?>"
                                            id="keluarNama" readonly>
                                    </div>
                                    <div>
                                        <label for="stockAwal">Jumlah Stock Masuk</label>
                                        <br>
                                        <input type="text"
                                            value="<?php echo $viewGetDataObatKeluar->databarangkeluar_stockAwal; ?>"
                                            readonly>
                                        <br>
                                        <label for="editStockAwal">Edit Jumlah Stock Masuk</label>
                                        <br>
                                        <input type="text" name="databarangkeluar_stockAwal" id="editStockAwal"
                                            oninput="updateSisaStock()">
                                    </div>
                                    <div>
                                        <label for="stockKeluar">Jumlah Stock Keluar</label>
                                        <br>
                                        <input type="text"
                                            value="<?php echo $viewGetDataObatKeluar->databarangkeluar_stockKeluar; ?>"
                                            id="stockKeluar" readonly>
                                        <br>
                                        <label for="editStockKeluar">Edit Jumlah Stock Keluar</label>
                                        <br>
                                        <input type="text" name="databarangkeluar_stockKeluar" id="editStockKeluar"
                                            oninput="updateSisaStock()">
                                    </div>
                                    <div>
                                        <label for="sisaStock">Sisa Stock</label>
                                        <br>
                                        <input type="text" value="<?php echo $viewGetDataObatKeluar->sisaStock; ?>"
                                            id="sisaStock" readonly>
                                        <br>
                                        <label for="editSisaStock">Edit Sisa Stock</label>
                                        <br>
                                        <input type="text" name="sisaStock" id="editSisaStock"
                                            oninput="updateSisaStock()">
                                    </div>
                                    <div>
                                        <label for="dataObatKeluarTgl">Tanggal Keluar</label>
                                        <br>
                                        <input type="date" name="databarangkeluar_tanggal"
                                            value="<?php echo $viewGetDataObatKeluar->databarangkeluar_tanggal; ?>"
                                            id="dataObatKeluarTgl">
                                    </div>
                                    <div>
                                        <input type="submit" name="submit" id="updateButton" value="Update Data"
                                            onclick="return confirm('Apakah data sudah benar?')">
                                    </div>
                                </div>

                            </div>
                            <?php
                            $todayDate = date('Y-m-d');
                            if (isset($_POST["submit"])) {
                                $databarangkeluar_stockAwal = $_POST['databarangkeluar_stockAwal'];
                                $databarangkeluar_stockKeluar = $_POST['databarangkeluar_stockKeluar'];
                                $sisaStock = $_POST['sisaStock'];
                                $databarangkeluar_tanggal = $_POST['databarangkeluar_tanggal'];

                                $pegawaiOnDuty = $_SESSION['user_login'];
                                // Check validasi untuk memastikan data tidak boleh duplicate\
                                if (
                                    empty($databarangkeluar_stockAwal && $databarangkeluar_stockKeluar && $sisaStock && $databarangkeluar_tanggal)
                                ) {
                                    echo "<script>alert('Data tidak boleh kosong!');</script>";
                                } else if (!is_numeric($databarangkeluar_stockAwal)) {
                                    echo "<script>alert('Data harus angka!');</script>";
                                } else if (!is_numeric($databarangkeluar_stockKeluar)) {
                                    echo "<script>alert('Data harus angka!');</script>";
                                } else if (!is_numeric($sisaStock)) {
                                    echo "<script>alert('Data harus angka!');</script>";
                                } else if ($databarangkeluar_stockAwal < 0) {
                                    echo "<script>alert('Data tidak boleh dibawah 0!')</script>";
                                } else if ($databarangkeluar_stockKeluar < 0) {
                                    echo "<script>alert('Data tidak boleh dibawah 0!')</script>";
                                } else if ($sisaStock < 0) {
                                    echo "<script>alert('Data tidak boleh dibawah 0!')</script>";
                                } else {
                                    $updateProses = mysqli_query($conn, 'UPDATE dataobatkeluar_tb
                                        SET 
                                        databarangkeluar_stockAwal = "' . $databarangkeluar_stockAwal . '",
                                        databarangkeluar_stockKeluar ="' . $databarangkeluar_stockKeluar . '" ,
                                        databarangkeluar_tanggal = "' . $databarangkeluar_tanggal . '",
                                        sisaStock = "' . $sisaStock . '"
                                      
                                    
                                        WHERE databarangkeluar_id = ' . $viewGetDataObatKeluar->databarangkeluar_id);
                                    if ($updateProses) {
                                        $logMessage = "Data barang dengan nama barang $viewGetDataObatKeluar->databarangkeluar_nama dengan jumlah stock awal berjumlah $viewGetDataObatKeluar->databarangkeluar_stockAwal menjadi $databarangkeluar_stockAwal, jumlah stock keluar awal $viewGetDataObatKeluar->databarangkeluar_stockKeluar menjadi $databarangkeluar_stockKeluar, jumlah sisa stock awal $viewGetDataObatKeluar->sisaStock menjadi $sisaStock berhasil diubah. Diubah oleh $pegawaiOnDuty";
                                        mysqli_query($conn, "INSERT INTO logseditbarangkeluar_tb(logs_id, logs_description, logs_time) VALUES(NULL, '$logMessage', NOW())");
                                        echo "<script>alert('Data berhasil diubah'); window.location.href= '../halaman_databarangkeluar.php';</script>";
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