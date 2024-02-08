<?php
include('../database/db_koneksi.php');
session_start();


if (!isset($_SESSION["login_admin"])) {
    header("Location: index.php");
    exit;
}

$sqlQuery = mysqli_query($conn, "SELECT * FROM pegawai_tb WHERE id_pegawai = '" . $_SESSION['id'] . "' ");
$takeData = mysqli_fetch_object($sqlQuery);

if (isset($_POST['submit'])) {
    $passwordBaru = $_POST['pass_pegawai'];
    $validasiPassword = $_POST['validate_password'];

    if ($passwordBaru !== $validasiPassword) {
        echo "<script>alert('Password baru dengan validasi berbeda!'); window.location.href = '../halaman_datapegawai.php';</script>";
    } else {
        // Use prepared statement to update password
        $sqlUpdatePassword = "UPDATE pegawai_tb SET pass_pegawai = ? WHERE id_pegawai = ? ";
        $stmt = mysqli_prepare($conn, $sqlUpdatePassword);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "si", $passwordBaru, $_SESSION['id']);
            $processUpdate = mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            if ($processUpdate) {
                echo "<script>alert('Password berhasil diganti!'); window.location.href = '../halaman_datapegawai.php';</script>";
            } else {
                error_log("Error updating password: " . mysqli_error($conn));
                echo "<script>alert('Terjadi kesalahan dalam mengganti password.'); window.location.href = '../halaman_datapegawai.php';</script>";
            }
        } else {
            error_log("Error preparing statement: " . mysqli_error($conn));
            echo "<script>alert('Terjadi kesalahan dalam mengganti password.'); window.location.href = '../halaman_datapegawai.php';</script>";
        }
    }
}
?>
