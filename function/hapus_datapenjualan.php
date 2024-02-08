<?php
include("../database/db_koneksi.php");
session_start();

if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$datapenjualan_id = $_GET['datapenjualan_id'];

$sqldelete = mysqli_query($conn, "DELETE FROM datapenjualan_tb WHERE datapenjualan_id = '$datapenjualan_id'");

if ($sqldelete) {
    echo "<script>alert('Data berhasil di hapus!'); window.location.href='../halaman_datapenjualan.php'</script>";
} else {
    echo "Error:" . $sqldelete . "<br>" . mysqli_error($conn);
}
?>