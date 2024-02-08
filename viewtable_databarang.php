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
                <th>Batch</th>
                <th>Nama Obat</th>
                <th>Harga Modal</th>
                <th>Harga Jual</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Expired</th>
                <th>Jumlah Stock</th>
                <th>Prediksi Hasil Penjualan</th>
                <th>Kode Perusahaan</th>
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

            // Menggunakan Query untuk membuat limit dalam satu table
            $getDataObat = "SELECT * FROM dataobat_tb ORDER BY dataobat_tglMasuk  DESC LIMIT $start_from, $results_per_page";
            $showDataObat = mysqli_query($conn, $getDataObat);
            $noLoop = 1;
            $spasi = "  ";

            while ($viewDataObat = mysqli_fetch_array($showDataObat)) {
                ?>
                <tr>
                    <td>
                        <?php echo $noLoop++ + $start_from; ?>
                    </td>
                    <td>
                        <?php echo $viewDataObat['dataobat_batch']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataObat['dataobat_namaObat']; ?>
                    </td>
                    <td>
                        <?php echo 'Rp ' . number_format($viewDataObat['dataobat_hargaModal'], 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php echo 'Rp ' . number_format($viewDataObat['dataobat_hargaJual'], 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php echo date('d-m-Y', strtotime($viewDataObat['dataobat_tglMasuk'])); ?>
                    </td>
                    <td>
                        <?php echo date('d-m-Y', strtotime($viewDataObat['dataobat_tglExpired'])); ?>
                    </td>
                    <td>
                        <?php echo $viewDataObat['dataobat_jlhStockMasuk'] . $spasi . $viewDataObat['dataobat_format']; ?>
                    </td>
                    <td>
                        <?php echo 'Rp ' . number_format(($viewDataObat['dataobat_hargaJual'] * $viewDataObat['dataobat_jlhStockMasuk']), 0, ',', '.'); ?>
                    </td>
                    <td>
                        <?php echo $viewDataObat['perusahaan_kode']; ?>
                    </td>
                    <td>
                        <div class="btn-edit-dataobat">
                            <a href="function/edit_dataobat.php?dataobat_id=<?php echo $viewDataObat['dataobat_id']; ?>">
                                <p>Edit</p>
                            </a>
                            <a href="function/hapus_dataobat.php?dataobat_id=<?php echo $viewDataObat['dataobat_id']; ?>&dataobat_batch=<?php echo $viewDataObat['dataobat_batch']; ?>"
                                onclick="return confirm('Apakah ingin menghapus data tersebut?')">
                                <p>Hapus</p>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <?php
        $sql = "SELECT * FROM dataobat_tb";
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
                echo "<a href='halaman_databarang.php?page=" . $i . "' class='pagination'>" . $i . "</a>";
            }
        }

        if ($end_link < $total_pages) {
            echo "<span class='ellipsis'>...</span>";
            echo "<a href='halaman_databarang.php?page=" . $total_pages . "' class='pagination'>" . $total_pages . "</a>";
        }
        echo "</div>";
        ?>
    </div>

</body>

</html>