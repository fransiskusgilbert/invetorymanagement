<?php
include '../database/db_koneksi.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$perusahaan_id = $_GET['perusahaan_id'];

$sqlDeletePerusahaan = mysqli_query($conn, "DELETE FROM perusahaan_tb WHERE perusahaan_id ='$perusahaan_id'");

if ($sqlDeletePerusahaan) {
    echo "<script>alert('Data berhasil dihapus'); window.location.href= '../halaman_dataperusahaan.php'</script>";
} else {
    echo "Error:" . $sqlDeletePerusahaan . "<br>" . mysqli_error($conn);
}
?>