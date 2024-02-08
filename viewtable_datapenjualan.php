<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homestyle.css">
    <title>Document</title>
</head>

<body>
    <div class="tb-dataobat">
        <table>
            <tr>
                <th>No</th>
                <th>Total Tagihan Kredit</th>
                <th>Total Tagihan Cash</th>
                <th>Total Omzet</th>
                <th>Total Penjualan</th>
                <th>Shift</th>
                <th>Tanggal Shift</th>
                <th>Nama Petugas</th>
                <op
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

            // Menggunakan Query untuk membuat limit dalam satu table
            $getDataPenjualan = "SELECT * FROM datapenjualan_tb ORDER BY datapenjualan_tglShift  DESC LIMIT $start_from, $results_per_page";
            $showDataPenjualan = mysqli_query($conn, $getDataPenjualan);
            $noLoop = 1;
            $spasi = "  ";

            while ($viewDataPenjualan = mysqli_fetch_array($showDataPenjualan)) {
                ?>
                <tr>
                    <td>
                        <?php echo $noLoop++ + $start_from; ?>
                    </td>
                    <td>
                        <?php echo 'Rp ' . number_format($viewDataPenjualan['datapenjualan_kredit'], 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php echo 'Rp ' . number_format($viewDataPenjualan['datapenjualan_cash'], 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php echo 'Rp ' . number_format($viewDataPenjualan['datapenjualan_omzet'], 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php echo 'Rp ' . number_format($viewDataPenjualan['datapenjualan_totalPenjualan'], 0, ',', '.'); ?>
                    </td>
                    <td class="jenisShift">
                        <?php echo $viewDataPenjualan['datapenjualan_shift']; ?>
                    </td>
                    <td>
                        <?php echo date('d-m-Y', strtotime($viewDataPenjualan['datapenjualan_tglShift'])); ?>
                    </td>
                    <td>
                        <?php echo $viewDataPenjualan['nama_pegawai']; ?>
                    </td>

                </tr>
                <?php
            }
            ?>
        </table>
        <script src="js/shift.js"></script>

        <!-- Pagination links -->
        <?php
        $sql = "SELECT * FROM datapenjualan_tb";
        $result = mysqli_query($conn, $sql);
        $num_rows = mysqli_num_rows($result);
        $total_pages = ceil($num_rows / $results_per_page);

        $max_links = 2; // Maximum number of pagination links to display
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        $start_link = max(1, min($current_page - floor($max_links / 2), $total_pages - $max_links + 1));
        $end_link = min($start_link + $max_links - 1, $total_pages);

        echo "<div class='pagination'>";
        for ($i = $start_link; $i <= $end_link; $i++) {
            if ($i == $current_page) {
                echo "<span class='current'>" . $i . "</span>";
            } else {
                "<a href='halaman_datapenjualan.php?page=" . $i . "' class='pagination'>" . $i . "</a>";
            }
        }

        if ($end_link < $total_pages) {
            echo "<span class='ellipsis'>...</span>";
            echo "<a href='halaman_datapenjualan.php?page=" . $total_pages . "' class='pagination'>" . $total_pages . "</a>";
        }
        echo "</div>";
        ?>
    </div>

</body>

</html>