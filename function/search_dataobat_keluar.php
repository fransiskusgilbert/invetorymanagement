<?php
include '../database/db_koneksi.php';
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$sqlQuery = mysqli_query($conn, "SELECT * FROM pegawai_tb WHERE id_pegawai = '" . $_SESSION['id'] . "' ");
$takeData = mysqli_fetch_object($sqlQuery);

if (isset($_GET['cari'])) {
    $cari = $_GET['cari'];
    $formatedDate = date('d-m-Y', strtotime($cari));

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../homestyle.css">
    <!-- Icon CSS -->
    <script src="https://kit.fontawesome.com/604f0994f6.js" crossorigin="anonymous"></script>
    <!-- Font CSS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans:ital,wght@0,400;0,700;1,400;1,700&display=swap"
        rel="stylesheet">
    <title>Dashboard</title>

</head>

<body>
    <div class="container">
        <div class="nav-top">
            <div class="nav-head-img">
                <img src="../image/logo_navbar.png" alt="">
            </div>
            <p class="nav-text-describe">Sistem Persedian dan Penjualan Obat</p>
            <div class="nav-top-contents">
                <ul>
                    <li class="nav-bar-content">Halo,
                        <?php echo $_SESSION['user_login']; ?>
                    </li>
                    <li class="nav-bar-content" id="dateNow"></li>
                </ul>
            </div>
            <script src="dateFunction.js"></script>
        </div>
        <div class="nav-side">
            <ul>
                <li><span><i class="fa-solid fa-house"></i></span><a href="../halaman_dashboard.php"
                        id="dashboardMenu">Dashboard</a></li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="../halaman_databarang.php">Data
                        Obat</a>
                </li>
                <li><span><i class="fa-regular fa-money-bill-1"></i></span><a href="../halaman_datapenjualan.php">Data
                        Penjualan</a></li>
                <li><span><i class="fa-solid fa-people-arrows"></i></span><a href="../halaman_dataperusahaan.php">Data
                        Perusahaan</a></li>
                <li><span><i class="fa-solid fa-notes-medical"></i></span><a href="../halaman_databarangkeluar.php">Data
                        Barang Keluar</a></li>
                <li><span><i class="fa-solid fa-power-off"></i></span><a href="../login_proses/logout_proses.php"
                        onclick="return confirm('Apakah anda yakin ingin keluar?')">Keluar</a>
                </li>
            </ul>
        </div>
        <!-- Content start -->
        <div class="dataobat-dashboard-container">
            <div class="dataobat-header-container">
                <div class="dataobat-dashboard-text">
                    <div class="obat-text-logo">
                        <i class="fa-regular fa-square-plus"></i>
                    </div>
                    <a href="../halaman_databarang.php">
                        <p>Data Obat</p>
                    </a>
                    <p>></p>
                    <p>Pencarian data obat :</p>
                    <p>
                        <?php echo $cari; ?>
                    </p>
                </div>
            </div>
            <!-- Container content -->
            <div class="dataobat-view-container">
                <!-- Box Styling -->
                <div class="dataobat-box-container">
                    <div class="dataobat-box-header-container">
                        <p>Tabel Pencariaan Data Obat</p>
                    </div>
                    <div class="wrapper-search-contents">
                        <div class="box-search-container">
                            <div class="box-search-wrapper">
                                <div class="content-1">
                                    <p>Pencariaan data obat pada tanggal :</p>
                                </div>
                                <div class="content-2">
                                    <p>
                                        <?php echo $formatedDate; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="button-export-excel-srt-container">
                            <div class="button-export-excel-srt-wrapper">
                                <form action="../convert_dataobatkeluar_to_excell_sortdate.php" method="GET">
                                    <input type="text" name="cari_data" value="<?php echo $cari; ?>"
                                        style="display:none;">
                                    <input type="submit" name="submit" value="Cetak Laporan"
                                        onclick="return confirm ('Anda akan mencetak laporan pada tanggal <?php echo $cari; ?>');">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tb-dataobat">
                        <table>
                            <tr>
                                <th>No</th>
                                <th>Nama Obat</th>
                                <th>Jumlah Stock Awal</th>
                                <th>Jumlah Stock Keluar</th>
                                <th>Sisa Stock</th>
                                <th>Tanggal Update</th>
                                <th>Opsi</th>
                            </tr>
                            <?php
                            // Jumlah konten per table
                            $results_per_page = 5;

                            // Validasi halaman yang sedang digunakan
                            if (!isset($_GET['page'])) {
                                $page = 1;
                            } else {
                                $page = $_GET['page'];
                            }

                            $start_from = ($page - 1) * $results_per_page;

                            if (isset($_GET['cari'])) {
                                $cari = $_GET['cari'];

                                if (!empty($cari)) {
                                    $getDataObat = "SELECT * FROM dataobatkeluar_tb WHERE databarangkeluar_tanggal LIKE '%" . $cari .
                                        "%' LIMIT $start_from, $results_per_page";
                                    $showDataObat = mysqli_query($conn, $getDataObat);
                                } else {
                                    echo "<script>alert('Data tidak boleh kosong!'); window.location.href= '../halaman_databarangkeluar.php';</script>";
                                }
                            }
                            // Menggunakan Query pencariaan dan untuk membuat limit dalam satu table
                            
                            $noLoop = 1;
                            $spasi = "  ";
                            if (mysqli_num_rows($showDataObat) > 0) {
                                while ($viewDataObat = mysqli_fetch_array($showDataObat)) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $noLoop++ + $start_from; ?>
                                        </td>
                                        <td>
                                            <?php echo $viewDataObat['databarangkeluar_nama']; ?>
                                        </td>
                                        <td>
                                            <?php echo $viewDataObat['databarangkeluar_stockAwal']; ?>
                                        </td>
                                        <td>
                                            <?php echo $viewDataObat['databarangkeluar_stockKeluar']; ?>
                                        </td>
                                        <td>
                                            <?php echo $viewDataObat['sisaStock']; ?>
                                        </td>
                                        <td>
                                            <?php echo $viewDataObat['databarangkeluar_tanggal']; ?>
                                        </td>
                                        <td>
                                            <div class="btn-edit-dataobat">
                                                <a
                                                    href="edit_databarangkeluar.php?databarangkeluar_id=<?php echo $viewDataObat['databarangkeluar_id']; ?>">
                                                    <p>Edit</p>
                                                </a>
                                                <a
                                                    href="hapus_databarangkeluar.php?databarangkeluar_id=<?php echo $viewDataObat['databarangkeluar_id']; ?>">
                                                    <p>Hapus</p>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php }
                            } else {
                                echo "<tr><td colspan=11>Data pada tanggal tersebut tidak ditemukan!</td></tr>";
                            }
                            ?>
                        </table>

                        <!-- Pagination links -->
                        <?php
                        $total_records_sql = "SELECT COUNT(*) AS total_records FROM dataobatkeluar_tb WHERE databarangkeluar_tanggal LIKE '%" . $cari . "%'";
                        $total_records_result = mysqli_query($conn, $total_records_sql);
                        $total_records_row = mysqli_fetch_assoc($total_records_result);
                        $total_records = $total_records_row['total_records'];
                        // Calculate total pages
                        $total_pages = ceil($total_records / $results_per_page);

                        // Pagination links
                        echo '<ul class="pagination">';

                        for ($i = 1; $i <= $total_pages; $i++) {
                            if ($i == $page) {
                                echo '<li><span class="current">' . $i . '</span></li>';
                            } else {
                                if ($i == 1 || $i == $total_pages || ($i >= $page - 2 && $i <= $page + 2)) {
                                    echo '<li><a href="search_dataobat_keluar.php?cari=' . urlencode($cari) . '&page=' . $i . '">' . $i . '</a></li>';
                                } elseif ($i < $page - 2 && $i > 1) {
                                    echo '<li class="ellipsis">...</li>';
                                    $i = $page - 2;
                                } elseif ($i > $page + 2 && $i < $total_pages) {
                                    echo '<li class="ellipsis">...</li>';
                                    $i = $total_pages - 1;
                                }
                            }
                        }

                        echo '</ul>';
                        ?>

                    </div>
                </div>
            </div>
            <!-- Content end -->
        </div>
</body>

</html>