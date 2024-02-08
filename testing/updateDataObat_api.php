<?php
$conn = new mysqli("localhost", "root", "", "db_apotekterang");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == "PUT") {

    // Assuming dataobat_id is received in the request body
    $dataobat_id = isset($_POST['dataobat_id']) ? $_POST['dataobat_id'] : null;

    // Validate required fields
    if (
        !isset($_POST['dataobat_batch']) ||
        !isset($_POST['dataobat_namaObat']) ||
        !isset($_POST['dataobat_hargaModal']) || !isset($_POST['dataobat_hargaJual'])
        || !isset($_POST['dataobat_tglMasuk'])
        || !isset($_POST['dataobat_tglExpired'])
        || !isset($_POST['dataobat_jlhStockMasuk'])
        || !isset($_POST['dataobat_format'])
        || !isset($_POST['perusahaan_kode'])
        || !isset($_POST['nama_pegawai'])
    ) {
        echo json_encode(['error' => 'Missing required fields!']);
        exit;
    }

    $dataobat_batch = $_POST['dataobat_batch'];
    $dataobat_namaObat = $_POST['dataobat_namaObat'];
    $dataobat_hargaModal = $_POST['dataobat_hargaModal'];
    $dataobat_hargaJual = $_POST['dataobat_hargaJual'];
    $dataobat_tglMasuk = $_POST['dataobat_tglMasuk'];
    $dataobat_tglExpired = $_POST['dataobat_tglExpired'];
    $dataobat_jlhStockMasuk = $_POST['dataobat_jlhStockMasuk'];
    $dataobat_format = $_POST['dataobat_format'];
    $perusahaan_kode = $_POST['perusahaan_kode'];
    $nama_pegawai = $_POST['nama_pegawai'];

    $query = "UPDATE dataobat_tb SET
        dataobat_batch = ?,
        dataobat_namaObat = ?,
        dataobat_hargaModal = ?,
        dataobat_hargaJual = ?,
        dataobat_tglMasuk = ?,
        dataobat_tglExpired = ?,
        dataobat_jlhStockMasuk = ?,
        dataobat_format = ?,
        perusahaan_kode = ?,
        nama_pegawai = ?,
    WHERE dataobat_id = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param(
        "sssss",
        $dataobat_batch,
        $dataobat_namaObat,
        $dataobat_hargaModal,
        $dataobat_hargaJual,
        $dataobat_tglMasuk,
        $dataobat_tglExpired,
        $dataobat_jlhStockMasuk,
        $dataobat_format,
        $perusahaan_kode,
        $nama_pegawai,
        $dataobat_id
    );

    if ($stmt->execute()) {
        echo json_encode([
            'message' => "Berhasil memasukan data!",
            'dataobat_batch' => $dataobat_batch,
            'dataobat_namaObat' => $dataobat_namaObat,
            // ... (include other fields)
        ]);
    } else {
        echo json_encode(['error' => 'Failed to update data!']);
    }
} else {
    echo json_encode(['error' => 'Gagal input data!']);
}