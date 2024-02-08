<?php
$conn = new mysqli("localhost", "root", "", "db_apotekterang");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
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

    $query = "INSERT into dataobat_tb VALUES ('', '$dataobat_batch', '$dataobat_namaObat', '$dataobat_hargaModal', '$dataobat_hargaJual',
    '$dataobat_tglMasuk', '$dataobat_tglExpired', '$dataobat_jlhStockMasuk', '$dataobat_format', '$perusahaan_kode', '$nama_pegawai')";
    $result = mysqli_query($conn, $query);
    echo json_encode([
        'message' => "Berhasil memasukan data!",
        'dataobat_batch' => $dataobat_batch,
        'dataobat_namaObat' => $dataobat_namaObat,
        'dataobat_hargaModal' => $dataobat_hargaModal,
        'dataobat_hargaJual' => $dataobat_hargaJual,
        'dataobat_tglMasuk' => $dataobat_tglMasuk,
        'dataobat_tglExpired' => $dataobat_tglExpired,
        'dataobat_jlhStockMasuk' => $dataobat_jlhStockMasuk,
        'dataobat_format' => $dataobat_format,
        'perusahaan_kode' => $perusahaan_kode,
        'nama_pegawai' => $nama_pegawai
    ]);
} else {
    echo json_encode(['error' => 'Gagal input data!']);
}

?>