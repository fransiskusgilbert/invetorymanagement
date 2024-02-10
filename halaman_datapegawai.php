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
    <title>Halaman Pegawai</title>
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
                    <li class="nav-bar-content">Halo,
                        <?php echo $_SESSION['admin_login']; ?>
                    </li>
                    <li class="nav-bar-content" id="dateNow"></li>
                </ul>
            </div>
            <script src="dateFunction.js"></script>
        </div>
        <div class="nav-side">
            <ul>
                <ul>
                    <li><span><i class="fa-solid fa-house"></i></span><a href="halaman_dashboard_admin.php"
                            id="dashboardMenu">Dashboard</a></li>
                    <li><span><i class="fa-solid fa-user"></i></span><a href="halaman_datapegawai.php">Data Pegawai</a>
                    </li>
                    <li><span><i class="fa-solid fa-power-off"></i></span><a href="login_proses/logout_proses.php"
                            onclick="return confirm('Apakah anda yakin ingin keluar?')">Keluar</a>
                    </li>
                </ul>
            </ul>
        </div>
        <!-- Content start -->
        <div class="dataobat-dashboard-container">
            <div class="dataobat-header-container">
                <div class="dataobat-dashboard-text">
                    <div class="obat-text-logo">
                        <i class="fa-regular fa-square-plus"></i>
                    </div>
                    <p>Data Pegawai</p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Data Pegawai</p>
                    </div>
                    <div class="dataobat-button-container">
                        <div class="dataobat-button-wrapper">
                            <button id="addDataObat" onclick="inputData()">Tambah Pegawai</button>
                        </div>
                    </div>
                    <!-- Pop Up untuk Input Data Start -->
                    <div class="popUp-pegawai" id="popUpAddData" style="display:none;">
                        <div class="pop-header-container">
                            <p>Form Tambah Akun Pegawai</p>
                        </div>
                        <div class="popUp-button-control">
                            <button class="closePopUp" id="closePopUp" onclick="closePopUp()"> x</button>
                        </div>
                        <div class="form-control-add-data-pegawai">
                            <form action="function/input_datapegawai.php" method="POST">
                                <div>
                                    <label for="userNot">Username akun pegawai</label>
                                    <br>
                                    <input type="text" name="user_pegawai" id="userNot"
                                        placeholder="Silahkan masukan username pegawai">
                                </div>
                                <div>
                                    <label for="current-password">Masukan password akun pegawai baru</label>
                                    <br>
                                    <input type="password" name="pass_pegawai" id="current-password">
                                </div>
                                <div>
                                    <label for="validatePassowrd">Masukan password baru kembali</label>
                                    <br>
                                    <input type="text" name="validate_password" id="validatePassword">
                                </div>

                                <div>
                                    <label for="userNot">Nama lengkap pegawai</label>
                                    <br>
                                    <input type="text" name="nama_pegawai" id="userNot"
                                        placeholder="Silahkan masukan nama lengkap pegawai">
                                </div>

                                <div>
                                    <label for="userNot">Nomor lengkap pegawai</label>
                                    <br>
                                    <input type="text" name="nomor_pegawai" id="userNot"
                                        placeholder="Silahkan masukan nomor handphone pegawai">
                                </div>

                                <div>
                                    <label for="userNot">Rules pegawai</label>
                                    <br>
                                    <select name="rules">
                                        <option value="" disabled selected>-- Pilih Rules --</option>
                                        <option value="user">User</option>
                                    </select>
                                </div>

                                <input type="submit" name="submit" id="submitBtn-pegawai" value="Buat akun"
                                    onclick="return confirm('Apakah data sudah benar?');">
                            </form>
                        </div>
                        <script src="js/popInput.js"></script>
                        <script src="js/closePopPegawai.js"></script>
                    </div>
                    <div class="showdata" id="showtable">
                        <?php
                        require("view_pegawai.php");
                        ?>
                    </div>
                </div>
            </div>
            <!-- Content end -->
        </div>
</body>

</html>