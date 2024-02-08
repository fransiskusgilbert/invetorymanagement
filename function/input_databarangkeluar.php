<?php
include('../database/db_koneksi.php');
session_start();
if (isset($_POST['submitPenjualan'])) {
    $databarangkeluar_nama = $_POST['databarangkeluar_nama'];
    $databarangkeluar_stockAwal = $_POST['databarangkeluar_stockAwal'];
    $databarangkeluar_stockKeluar = $_POST['databarangkeluar_stockKeluar'];
    $databarangkeluar_tanggal = $_POST['databarangkeluar_tanggal'];
    $sisaStock = $_POST['sisaStock'];

    $pegawaiOnDuty = $_SESSION['user_login'];

    $sqlQueryCheckDuplicate = "SELECT databarangkeluar_nama FROM dataobatkeluar_tb 
    WHERE databarangkeluar_nama = '$databarangkeluar_nama'";

    $checkDuplicateDataBarangKeluar = mysqli_num_rows(mysqli_query($conn, $sqlQueryCheckDuplicate));

    if (empty($databarangkeluar_nama && $databarangkeluar_stockAwal && $databarangkeluar_stockKeluar && $sisaStock)) {
        echo "<script>alert('Data tidak boleh kosong!');</script>";
    } else if ($checkDuplicateDataBarangKeluar > 0) {
        echo "<script>alert('Data sudah ada!')</script>";
    } else if (!is_numeric($databarangkeluar_stockAwal) || !is_numeric($databarangkeluar_stockKeluar)) {
        echo "<script>alert('Data harus angka!');</script>";
    } else if ($databarangkeluar_stockKeluar < 0) {
        echo "<script>alert('Data tidak valid!');</script>";
    } else {
        $sqlQueryInput = "INSERT INTO dataobatkeluar_tb VALUES ('', '$databarangkeluar_nama','$databarangkeluar_stockAwal', '$databarangkeluar_stockKeluar', '$databarangkeluar_tanggal', '$sisaStock') ";
        $resultQuery = mysqli_query($conn, $sqlQueryInput);

        if ($resultQuery) {
            $logMessage = "Data obat keluar berhasil di input, Nama obat = $databarangkeluar_nama, Jumlah stock awal = $databarangkeluar_stockAwal, Jumlah stock keluar = $databarangkeluar_stockKeluar, Sisa stock = $sisaStock dan di input oleh $pegawaiOnDuty pada tanggal = $databarangkeluar_tanggal";
            mysqli_query($conn, "INSERT INTO logsinputbarangkeluar_tb(logs_id, logs_description, logs_time) VALUES (NULL, '$logMessage', NOW())");
            echo "<script>alert('Data berhasil masuk!'); window.location.href = '../halaman_databarangkeluar.php'; </script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

?>