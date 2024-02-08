<?php
include("../database/db_koneksi.php");

if (isset($_POST["submit"])) {
    $datapenjualan_kredit = $_POST["datapenjualan_kredit"];
    $datapenjualan_cash = $_POST["datapenjualan_cash"];
    $datapenjualan_omzet = $_POST["datapenjualan_omzet"];
    $datapenjualan_totalPenjualan = $_POST["datapenjualan_totalPenjualan"];
    $datapenjualan_shift = $_POST["datapenjualan_shift"];
    $datapenjualan_tglShift = $_POST["datapenjualan_tglShift"];
    $nama_pegawai = $_POST["nama_pegawai"];

    // Inisialisasi tgl hari ini untuk compare dengan tgl expired
    $todayDate = date("Y-m-d");

    $cekDuplicateData = "SELECT * FROM datapenjualan_tb WHERE datapenjualan_shift = '$datapenjualan_shift' AND datapenjualan_tglShift = '$datapenjualan_tglShift'";
    $resultCekDuplicate = mysqli_num_rows(mysqli_query($conn, $cekDuplicateData));
    // TODO: Validasi data penjualan tidak boleh duplikat di antara shift dan tanggal penjualan
    if ($resultCekDuplicate > 1) {
        echo "<script>alert('Data sudah ada!'); window.location.href='../halaman_datapenjualan.php';</script>";
    }
    // Todo: Validasi data tidak boleh kosong :
    else if (empty($datapenjualan_kredit && $datapenjualan_cash && $datapenjualan_omzet && $datapenjualan_totalPenjualan && $datapenjualan_shift && $datapenjualan_tglShift)) {
        echo "<script>alert('Data tidak boleh kosong!'); window.location.href= '../halaman_datapenjualan.php'</script>";
    }
    // Todo: Validasi Inputan Harga Modal dan Harga Jual harus angka :
    else if (!is_numeric($datapenjualan_kredit) || !is_numeric($datapenjualan_cash) || !is_numeric($datapenjualan_omzet) || !is_numeric($datapenjualan_totalPenjualan)) {
        echo "<script>alert('Data harga harus berupa angka!'); window.location.href='../halaman_datapenjualan.php';</script>";
    }
    // Todo: Validasi inputan harga Jual tidak boleh dibawah nol
    else if ($datapenjualan_kredit < 0 || $datapenjualan_cash < 0 || $datapenjualan_omzet < 0 || $datapenjualan_totalPenjualan < 0) {
        echo "<script>alert('Total Tagihan atau Omzet atau Total Penjualan tidak boleh kurang dari 0!'); window.location.href='../halaman_datapenjualan.php';</script>";
    } else {
        // #input query
        $inputSql = mysqli_query($conn, "INSERT into datapenjualan_tb VALUES ('', '$datapenjualan_kredit', '$datapenjualan_cash', '$datapenjualan_omzet', '$datapenjualan_totalPenjualan',
        '$datapenjualan_shift', '$datapenjualan_tglShift', '$nama_pegawai')");
        // #Memanggil input query
        if ($inputSql) {
            echo "<script>alert('Data berhasil masuk!'); window.location.href='../halaman_datapenjualan.php';</script>";
        } else {
            echo "Error:" . $inputSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>