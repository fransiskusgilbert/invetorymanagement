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
                <th>Nama Perusahaan</th>
                <th>Kode Perusahaan</th>
                <th>Sales Perusahaan</th>
                <th>Kontak Sales</th>
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
            $getDataPerusahaan = "SELECT * FROM perusahaan_tb ORDER BY perusahaan_kode ASC LIMIT $start_from, $results_per_page";
            $showDataPerusahaan = mysqli_query($conn, $getDataPerusahaan);
            $noLoop = 1;
            $spasi = "  ";

            while ($viewDataPerusahaan = mysqli_fetch_array($showDataPerusahaan)) {
                ?>
                <tr>
                    <td>
                        <?php echo $noLoop++ + $start_from; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPerusahaan['perusahaan_nama']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPerusahaan['perusahaan_kode']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPerusahaan['perusahaan_namaSales']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPerusahaan['perusahaan_noSales']; ?>
                    </td>
                    <td>
                        <div class="btn-edit-dataobat">
                            <a
                                href="function/edit_dataperusahaan.php?perusahaan_id=<?php echo $viewDataPerusahaan['perusahaan_id']; ?>">
                                <p>Edit</p>
                            </a>
                            <a href="function/hapus_dataperusahaan.php?perusahaan_id=<?php echo $viewDataPerusahaan['perusahaan_id']; ?>"
                                onclick="return confirm('Apakah ingin menghapus data tersebut?')" ;">
                                <p>Hapus</p>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <!-- Pagination links -->
        <?php
        $sql = "SELECT * FROM perusahaan_tb";
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
                echo "<a href='halaman_dataperusahaan.php?page=" . $i . "' class='pagination'>" . $i . "</a>";
            }
        }

        if ($end_link < $total_pages) {
            echo "<span class='ellipsis'>...</span>";
            echo "<a href='halaman_dataperusahaan.php?page=" . $total_pages . "' class='pagination'>" . $total_pages . "</a>";
        }
        echo "</div>";
        ?>
    </div>

</body>

</html>