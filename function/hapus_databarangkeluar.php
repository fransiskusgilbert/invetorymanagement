<?php
include '../database/db_koneksi.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$databarangkeluar_id = $_GET['databarangkeluar_id'];
$databarangkeluar_nama = $_GET['databarangkeluar_nama'];

$pegawaiOnDuty = $_SESSION['user_login'];
$sqlDeleteDataObat = mysqli_query($conn, "DELETE FROM dataobatkeluar_tb WHERE databarangkeluar_id ='$databarangkeluar_id'");

if ($sqlDeleteDataObat) {
    $logMessage = "Data obat keluar dengan nama obat = $databarangkeluar_nama berhasil dihapus! Dihapus oleh $pegawaiOnDuty";
    mysqli_query($conn, "INSERT INTO logshapusbarangkeluar_tb(logs_id, logs_description, logs_time) VALUES(NULL, '$logMessage', NOW())");
    echo "<script>alert('Data berhasil dihapus'); window.location.href = '../halaman_databarangkeluar.php'; </script>";
} else {
    echo "Error:" . $sqlDeleteDataObat . "<br>" . mysqli_error($conn);
}
?>