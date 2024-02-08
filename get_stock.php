<?php
include("database/db_koneksi.php"); // Include your database connection file

if (isset($_POST['dataobat_namaObat'])) {
    $selectedDataObatNama = $_POST['dataobat_namaObat'];

    $sqlCountStockAwal = "SELECT SUM(dataobat_jlhStockMasuk) AS stockAwal FROM dataobat_tb WHERE dataobat_namaObat = '$selectedDataObatNama'";
    $resultDataStockAwal = mysqli_query($conn, $sqlCountStockAwal);
    $rowStockAwal = mysqli_fetch_assoc($resultDataStockAwal);
    $stockAwal = $rowStockAwal['stockAwal'];

    echo $stockAwal;
}
?>