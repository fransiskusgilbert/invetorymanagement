<?php
// Start the session
session_start();

// Include the database connection
include '../database/db_koneksi.php';

// Check if the session variable 'id' is set and not empty
if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    // Store the ID from the session
    $id_pegawai = $_SESSION['id'];

    // Update login status in the database
    $updateStatus = mysqli_query($conn, "UPDATE pegawai_tb SET pegawai_status = 0 WHERE id_pegawai = '$id_pegawai'");

    if (!$updateStatus) {
        // Handle the case where the update fails
        echo "Failed to update login status: " . mysqli_error($conn);
        exit("<script>alert('Failed to update login status.'); window.location.href = '../index.php';</script>");
    }

    // Debugging
    echo "ID Pegawai: " . $id_pegawai;
    echo "Session ID: " . $_SESSION['id'];
}

if (isset($_SESSION['login_admin'])) {
    $_SESSION['login_admin'] = false;
    header("Location: ../index.php");
} else if (isset($_SESSION['login'])) {
    $_SESSION['login'] = false;
    header("Location: ../index.php");
} else {
    echo "<script>alert('Gagal!');</script>";
}


?>