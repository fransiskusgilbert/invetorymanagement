<?php
include '../database/db_koneksi.php';
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$dataobat_id = $_GET['dataobat_id'];
$dataobat_batch = $_GET['dataobat_batch'];
$pegawaiOnDuty = $_SESSION['user_login'];

$sqlDeleteDataObat = mysqli_query($conn, "DELETE FROM dataobat_tb WHERE dataobat_id ='$dataobat_id' AND dataobat_batch = '$dataobat_batch'");

if ($sqlDeleteDataObat) {
    $logMessage = "Data berhasil dihapus dengan batch: $dataobat_batch. Dihapus oleh: $pegawaiOnDuty";
    mysqli_query($conn, "INSERT INTO logshapusbarang_tb(logshapusbarang_id, logshapusbarang_description, logshapusbarang_time) VALUES (NULL, '$logMessage', NOW())");
    echo "<script>alert('Data berhasil dihapus'); </script>";
} else {
    echo "Error:" . $sqlDeleteDataObat . "<br>" . mysqli_error($conn);
}
?>