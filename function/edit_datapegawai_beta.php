<?php
include '../database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login_admin"])) {
    header("Location: index.php");
    exit;
}


$pegawai_id = $_GET['id_pegawai'];
$sqlGetPegawai = "SELECT * FROM pegawai_tb WHERE id_pegawai = '$pegawai_id'";
$resultPegawai = mysqli_query($conn, $sqlGetPegawai);
$viewGetDataPegawai = mysqli_fetch_object($resultPegawai);
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
                        <?php echo $_SESSION['admin_login']; ?>
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
                    <a href="../halaman_datapegawai.php">
                        <p> Data Pegawai</p>
                    </a>
                    <p> > </p>
                    <p> Edit data perusahaan : </p>
                    <p>
                        <?php echo $viewGetDataPegawai->id_pegawai ?>
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
                                        <label for="perusahaanNama">Username Pegawai</label>
                                        <br>
                                        <input type="text" name="user_pegawai"
                                            value="<?php echo $viewGetDataPegawai->user_pegawai; ?>" id="perusahaanNama"
                                            readonly>
                                    </div>
                                    <div>
                                        <label for="perusahaanKode">Password Lama</label>
                                        <br>
                                        <input type="text" name=""
                                            value="<?php echo $viewGetDataPegawai->pass_pegawai; ?>"
                                            id="perusahaanKode">
                                    </div>
                                    <div>
                                        <label for="perusahaanSales">Password Baru</label>
                                        <br>
                                        <input type="text" name="pass_pegawai" id="perusahaanSales">
                                    </div>
                                    <div>
                                        <label for="perusahaanSales">Masukan Kembali Password Baru</label>
                                        <br>
                                        <input type="text" name="validate_password" id="perusahaanSales">
                                    </div>
                                    <div>
                                        <input type="submit" name="submit" id="updateButton" value="Update Data Pegawai"
                                            onclick="return confirm('Apakah data sudah benar?')">
                                    </div>
                                </div>
                            </div>
                    </div>
                    <?php
                    if (isset($_POST["submit"])) {
                        $pass_pegawai = $_POST['pass_pegawai'];
                        $validasiPassword = $_POST['validate_password'];

                        if (
                            empty($pass_pegawai && $validasiPassword)
                        ) {
                            echo "<script>alert('Password tidak boleh kosong!');</script>";
                        } else if ($pass_pegawai != $validasiPassword) {
                            echo "<script>alert('Password baru tidak sesuai');</script>";
                        } else if (!preg_match('/[a-zA-z]/', $pass_pegawai) || !preg_match('/\d/', $pass_pegawai)) {
                            echo "<script>alert('Password harus mengandung huruf dan angka! Silahkan coba lagi!');</script>";
                        } else {
                            $updateProses = mysqli_query($conn, 'UPDATE pegawai_tb
                                        SET 
                                        pass_pegawai = "' . $pass_pegawai . '"
                                        WHERE id_pegawai = ' . $viewGetDataPegawai->id_pegawai);
                            if ($updateProses) {
                                echo "<script>alert('Data berhasil diubah'); window.location.href='../halaman_datapegawai.php';</script>";
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