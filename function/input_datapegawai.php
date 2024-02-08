<?php
include('../database/db_koneksi.php');
session_start();

if (!isset($_SESSION["login_admin"])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['submit'])) {
    $user_pegawai = $_POST['user_pegawai'];
    $pass_pegawai = $_POST['pass_pegawai'];
    $validasiPassoword = $_POST['validate_password'];
    $nama_pegawai = $_POST['nama_pegawai'];
    $nomor_pegawai = $_POST['nomor_pegawai'];
    $rules = $_POST['rules'];

    $queryDuplicate = "SELECT * FROM pegawai_tb WHERE user_pegawai = '$user_pegawai'";
    $cekDuplicateUser = mysqli_num_rows(mysqli_query($conn, $queryDuplicate));

    if (empty($user_pegawai && $pass_pegawai && $validasiPassoword && $nama_pegawai && $nomor_pegawai && $rules)) {
        echo "<script>alert('Data akun tidak boleh kosong!'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else if ($cekDuplicateUser > 0) {
        echo "<script>alert('Akun dengan username tersebut sudah terdaftar silahkan coba lagi dengan user berbeda!'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else if ($pass_pegawai != $validasiPassoword) {
        echo "<script>alert('Password dan validasi password akun berbeda! Silahkan coba lagi!'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else if (strlen($user_pegawai) < 5) {
        echo "<script>alert('Karakter pada username terlalu singkat! Silahkan buat karakter diatas 5 kata'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else if (!preg_match('/[a-zA-z]/', $pass_pegawai) || !preg_match('/\d/', $pass_pegawai)) {
        echo "<script>alert('Password harus mengandung huruf dan angka! Silahkan coba lagi!'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else if (strlen($pass_pegawai) < 5) {
        echo "<script>alert('Karakter pada password terlalu singkat! Silahkan buat karakter diatas 5 kata'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else if (is_numeric($nama_pegawai)) {
        echo "<script>alert('Nama pegawai tidak boleh mengandung karakter angka! Silahkan coba lagi!'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else if (is_string($nomor_pegawai)) {
        echo "<script>alert('Nomor pegawai tidak boleh mengandung karakter kata! Silahkan coba lagi!'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else {
        $queryInput = "INSERT INTO pegawai_tb VALUES ('', '$user_pegawai', '$pass_pegawai', '$nama_pegawai', '$nomor_pegawai', '0', '$rules')";
        $entryData = mysqli_query($conn, $queryInput);

        if ($entryData) {
            echo "<script>alert('Akun pegawai berhasil dibuat!'); window.location.href = '../halaman_datapegawai.php';</script>";
        } else {
            echo "<script>alert('Akun pegawai gagal dibuat!'); window.location.href = '../halaman_datapegawai.php';</script>";
        }

    }

}

?>