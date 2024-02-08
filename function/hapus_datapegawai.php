<?php
include '../database/db_koneksi.php';
session_start();

if (!isset($_SESSION["login_admin"])) {
    header("Location: index.php");
    exit;
}

$datapegawai_id = $_GET['id_pegawai'];

$sqlDeleteDataObat = mysqli_query($conn, "DELETE FROM pegawai_tb WHERE id_pegawai ='$datapegawai_id'");

if ($sqlDeleteDataObat) {
    echo "<script>alert('Data berhasil dihapus'); window.location.href= '../halaman_datapegawai.php'</script>";
} else {
    echo "Error:" . $sqlDeleteDataObat . "<br>" . mysqli_error($conn);
}
?>