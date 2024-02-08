<?php
include '../database/db_koneksi.php';
session_start();

if (isset($_POST['submit'])) {
    $user_pegawai = mysqli_real_escape_string($conn, $_POST['user_pegawai']);
    $pass_pegawai = mysqli_real_escape_string($conn, $_POST['pass_pegawai']);
    $rules = isset($_POST['rules']) ? mysqli_real_escape_string($conn, $_POST['rules']) : '';

    if (empty($user_pegawai) || empty($pass_pegawai) || empty($rules)) {
        echo "<script>alert('Username, password, dan rules tidak boleh kosong!'); window.location.href = '../index.php';</script>";
    } else {
        $sql_check = mysqli_query($conn, "SELECT * FROM pegawai_tb WHERE user_pegawai='$user_pegawai' AND pass_pegawai='$pass_pegawai' AND rules = '$rules'");

        if (mysqli_num_rows($sql_check) > 0) {
            $dataLogin = mysqli_fetch_assoc($sql_check);
            $uniqueSessionID = md5(uniqid($dataLogin['id_pegawai'] . rand(), true));

            if ($dataLogin['rules'] == "admin") {
                $_SESSION['login_admin'] = true;
                $_SESSION['admin_login'] = $user_pegawai;
                $_SESSION['rules'] = "admin";
                $_SESSION['id_admin'] = $dataLogin['id_pegawai'];
                $_SESSION['unique_session_id'] = $uniqueSessionID;

                $loginStatus = mysqli_query($conn, "UPDATE pegawai_tb SET pegawai_status = 1 WHERE id_pegawai = '" . $dataLogin['id_pegawai'] . "'");
                echo "<script>alert('Rules anda adalah admin');  window.location.href = '../halaman_dashboard_admin.php';</script>";
            }
            if ($dataLogin['rules'] == "user") {
                $_SESSION['login'] = true;
                $_SESSION['user_login'] = $user_pegawai;
                $_SESSION['rules'] = "user";
                $_SESSION['id'] = $dataLogin['id_pegawai'];
                $_SESSION['unique_session_id'] = $uniqueSessionID;

                $loginStatus = mysqli_query($conn, "UPDATE pegawai_tb SET pegawai_status = 1 WHERE id_pegawai = '" . $dataLogin['id_pegawai'] . "'");


                $redirectUrl = "../halaman_dashboard.php?user_login=" . urlencode($_SESSION['user_login']);

                header("Location: " . $redirectUrl);
                exit();
            } else {
                echo "<script>alert('Gagal!');</script>";
            }
        } else {
            echo "<script>alert('Username atau password atau rules salah silahkan coba lagi!'); window.location.href = '../index.php';</script>";
        }
    }
}
?>