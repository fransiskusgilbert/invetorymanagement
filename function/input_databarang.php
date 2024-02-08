<?php
include("../database/db_koneksi.php");

if (isset($_POST["submit"])) {
    $dataobat_batch = $_POST["dataobat_batch"];
    $dataobat_namaObat = $_POST["dataobat_namaObat"];
    $dataobat_hargaModal = $_POST["dataobat_hargaModal"];
    $dataobat_hargaJual = $_POST["dataobat_hargaJual"];
    $dataobat_tglMasuk = $_POST["dataobat_tglMasuk"];
    $dataobat_tglExpired = $_POST["dataobat_tglExpired"];
    $dataobat_jlhStockMasuk = $_POST["dataobat_jlhStockMasuk"];
    $dataobat_format = $_POST["dataobat_format"];
    $perusahaan_kode = $_POST["perusahaan_kode"];
    $nama_pegawai = $_POST["nama_pegawai"];

    // Format date in jakarta
    date_default_timezone_set('Asia/Jakarta');

    // Inisialisasi tgl hari ini untuk compare dengan tgl expired
    $todayDate = date("Y-m-d");
    $timeStamp = date("Y-m-d H:i:s");


    // Todo : Kode batch tidak boleh ada dupli kat data
    $queryCek = "SELECT * FROM dataobat_tb WHERE dataobat_batch = '$dataobat_batch'";
    $cekDuplicateBatch = mysqli_num_rows(mysqli_query($conn, $queryCek));


    // Todo : Validasi data tidak boleh kosong :
    if (
        empty($dataobat_batch && $dataobat_namaObat && $dataobat_hargaModal && $dataobat_hargaJual && $dataobat_tglMasuk && $dataobat_tglExpired
        && $dataobat_jlhStockMasuk && $dataobat_format && $perusahaan_kode)
    ) {
        echo "<script>alert('Data tidak boleh kosong!'); window.location.href='../halaman_databarang.php';</script>";
    }
    // Todo : Validasi Duplicate Data :
    else if ($cekDuplicateBatch > 0) {
        echo "<script>alert('Kode batch tersebut sudah ada!'); window.location.href='../halaman_databarang.php';</script>";
    }
    // Todo : Validasi Inputan Harga Modal dan Harga Jual harus angka :
    else if (!is_numeric($dataobat_hargaModal) || !is_numeric($dataobat_hargaJual) || !is_numeric($dataobat_jlhStockMasuk)) {
        echo "<script>alert('Data harga harus berupa angka!'); window.location.href='../halaman_databarang.php';</script>";
    }
    // Todo : Validasi inputan harga Jual tidak boleh dibawah nol
    else if ($dataobat_hargaJual < 0) {
        echo "<script>alert('Harga jual salah!'); window.location.href='../halaman_databarang.php';</script>";
    }
    // Todo : Validasi inputan harga Jual tidak boleh dibawah nol
    else if ($dataobat_hargaModal < 0) {
        echo "<script>alert('Harga modal salah!'); window.location.href='../halaman_databarang.php';</script>";
    }
    // Todo : Validasi inputan jumlah stock masuk tidak boleh dibawah nol
    else if ($dataobat_jlhStockMasuk < 0) {
        echo "<script>alert('Jumlah stock salah!'); window.location.href='../halaman_databarang.php';</script>";
    }
    // Todo : Validasi tgl obat expried tidak boleh lebih kecil daripada tgl hari ini
    else if ($dataobat_tglExpired < $todayDate) {
        echo "<script>alert('Obat sudah kadaluarsa!'); window.location.href='../halaman_databarang.php';</script>";
    } else {
        // #input query
        $inputSql = mysqli_query($conn, "INSERT into dataobat_tb VALUES ('', '$dataobat_batch', '$dataobat_namaObat', '$dataobat_hargaModal', '$dataobat_hargaJual',
        '$dataobat_tglMasuk', '$dataobat_tglExpired', '$dataobat_jlhStockMasuk', '$dataobat_format', '$perusahaan_kode', '$nama_pegawai')");
        // #Memanggil input query
        if ($inputSql) {
            $logMessage = "Data berhasil masuk - Batch: $dataobat_batch, Nama Obat: $dataobat_namaObat, Harga Modal: $dataobat_hargaModal, Harga Jual: $dataobat_hargaJual, Tgl Masuk: $dataobat_tglMasuk, Tgl Expired: $dataobat_tglExpired, Jlh Stock Masuk: $dataobat_jlhStockMasuk, Format: $dataobat_format, Kode Perusahaan: $perusahaan_kode, Nama Pegawai: $nama_pegawai";
            mysqli_query($conn, "INSERT INTO inputbaranglogs_tb(logs_id, logs_description, logs_time) VALUES (NULL, '$logMessage', '$timeStamp')");
            echo "<script>alert('Data berhasil masuk!'); window.location.href='../halaman_databarang.php';</script>";
        } else {
            echo "Error:" . $inputSql . "<br>" . mysqli_error($conn);
        }
    }
}
?>