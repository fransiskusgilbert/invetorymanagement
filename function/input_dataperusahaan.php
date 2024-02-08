<?php
include("../database/db_koneksi.php");

if (isset($_POST["submit"])) {
    $perusahaan_nama = $_POST["perusahaan_nama"];
    $perusahaan_kode = $_POST["perusahaan_kode"];
    $perusahaan_namaSales = $_POST["perusahaan_namaSales"];
    $perusahaan_noSales = $_POST["perusahaan_noSales"];

    $cekNamaSalesQuery = mysqli_num_rows(mysqli_query($conn, "SELECT perusahaan_namaSales FROM perusahaan_tb WHERE perusahaan_namaSales = '$perusahaan_namaSales'"));
    // Valdiasi duplicate data :
    $cekDuplicate = "SELECT * FROM perusahaan_tb WHERE perusahaan_nama = '$perusahaan_nama' AND perusahaan_namaSales = '$perusahaan_namaSales'";
    $validateData = mysqli_num_rows(mysqli_query($conn, $cekDuplicate));

    if (empty($perusahaan_nama && $perusahaan_kode && $perusahaan_namaSales && $perusahaan_noSales)) {
        echo "<script>alert('Harap isi semua data pada form!'); window.location.href = '../halaman_dataperusahaan.php';</script>";
    } else if ($validateData > 0) {
        echo "<script>alert('Data dengan nama perusahaan dan nama sales sudah ada!'); window.location.href= '../halaman_dataperusahaan.php';</script>";
    } else if (strlen($perusahaan_kode) >= 5) {
        echo "<script>alert('Kode tidak boleh lebih dari 5 Karakter!')</script>";
    } else if (!is_numeric($perusahaan_noSales)) {
        echo "<script>alert('Nomor tidak boleh menggunakan karakter atau huruf!')</script>";
    } else if ($cekNamaSalesQuery > 0) {
        echo "<script>alert('Nama sales sudah ada!')</script>";
    } else {
        $insertQuery = "INSERT into perusahaan_tb values('', '$perusahaan_nama', '$perusahaan_kode', '$perusahaan_namaSales',
        '$perusahaan_noSales')";

        $inputProses = mysqli_query($conn, $insertQuery);

        if ($inputProses) {
            echo "<script>alert('Data inserted successfully!');window.location.href = '../halaman_dataperusahaan.php';</script>";
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    }
}
?>
?>