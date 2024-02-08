<?php
include '../database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}
$sqlQuery = mysqli_query($conn, "SELECT * FROM pegawai_tb WHERE id_pegawai = '" . $_SESSION['id'] . "' ");
$takeData = mysqli_fetch_object($sqlQuery);

$perusahaan_id = $_GET['perusahaan_id'];
$sqlGetPerusahaan = "SELECT * FROM perusahaan_tb WHERE perusahaan_id = '$perusahaan_id'";
$resultPerusahaan = mysqli_query($conn, $sqlGetPerusahaan);
$viewGetDataPerusahaan = mysqli_fetch_object($resultPerusahaan);
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
    <title>Edit Data Perusahaan</title>
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
                        <?php echo $_SESSION['a_global']->nama_pegawai; ?>
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
                    <a href="../halaman_dataperusahaan.php">
                        <p> Data Perusahaan</p>
                    </a>
                    <p> > </p>
                    <p> Edit data perusahaan : </p>
                    <p>
                        <?php echo $viewGetDataPerusahaan->perusahaan_nama ?>
                    </p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Tabel Edit Data Perusahaan</p>
                    </div>
                    <div class="form-update-dataobat">
                        <form action="" method="POST">
                            <div class="form-containerEditPerusahaan">
                                <div class="form-edit1-perusahaan">
                                    <div>
                                        <label for="perusahaanNama">Nama Perusahaan</label>
                                        <br>
                                        <input type="text" name="perusahaan_nama"
                                            value="<?php echo $viewGetDataPerusahaan->perusahaan_nama; ?>"
                                            id="perusahaanNama">
                                    </div>
                                    <div>
                                        <label for="perusahaanKode">Kode Perusahaan</label>
                                        <br>
                                        <input type="text" name="perusahaan_kode"
                                            value="<?php echo $viewGetDataPerusahaan->perusahaan_kode; ?>"
                                            id="perusahaanKode">
                                    </div>
                                    <div>
                                        <label for="perusahaanSales">Nama Sales</label>
                                        <br>
                                        <input type="text" name="perusahaan_namaSales"
                                            value="<?php echo $viewGetDataPerusahaan->perusahaan_namaSales; ?>"
                                            id="perusahaanSales">
                                    </div>
                                    <div>
                                        <label for="perusahaanSalesKontak">Kontak Sales</label>
                                        <br>
                                        <input type="text" name="perusahaan_noSales"
                                            value="<?php echo $viewGetDataPerusahaan->perusahaan_noSales; ?>"
                                            id="perusahaanSalesKontak">
                                    </div>
                                    <div>
                                        <input type="submit" name="submit" id="updateButton" value="Update Data"
                                            onclick="return confirm('Apakah data sudah benar?')">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?php
                    if (isset($_POST["submit"])) {
                        $perusahaan_nama = $_POST['perusahaan_nama'];
                        $perusahaan_kode = $_POST['perusahaan_kode'];
                        $perusahaan_namaSales = $_POST['perusahaan_namaSales'];
                        $perusahaan_noSales = $_POST['perusahaan_noSales'];

                        if (
                            empty($perusahaan_nama && $perusahaan_kode && $perusahaan_namaSales && $perusahaan_noSales)
                        ) {
                            echo "<script>alert('Data tidak boleh kosong!');</script>";
                        } else if (strlen($perusahaan_kode) > 5) {
                            echo "<script>alert('Kode tidak boleh lebih dari 5 kata!');</script>";
                        } else if (!is_string($perusahaan_nama)) {
                            echo "<script>alert('Nama perusahaan tidak boleh mengandung angka!');</script>";
                        } else if (!is_string($perusahaan_namaSales)) {
                            echo "<script>alert('Nama sales tidak boleh mengandung angka!');</script>";
                        } else if (!is_numeric($perusahaan_noSales)) {
                            echo "<script>alert('Nomor handphone sales harus angka!');</script>";
                        } else {
                            $updateProses = mysqli_query($conn, 'UPDATE perusahaan_tb
                                        SET 
                                        perusahaan_nama = "' . $perusahaan_nama . '",
                                        perusahaan_kode ="' . $perusahaan_kode . '" ,
                                        perusahaan_namaSales = "' . $perusahaan_namaSales . '",
                                        perusahaan_noSales = "' . $perusahaan_noSales . '"
                                        WHERE perusahaan_id = ' . $viewGetDataPerusahaan->perusahaan_id);
                            if ($updateProses) {
                                echo "<script>alert('Data berhasil diubah'); window.location.href='../halaman_dataperusahaan.php';</script>";
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