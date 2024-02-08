<?php
$conn = new mysqli("localhost", "root", "", "db_apotekterang");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $result = $conn->query("SELECT * FROM pegawai_tb");
    $data = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode($data);
} else {
    echo json_encode(['error' => 'Gagal mendapatkan data!']);
}

?>