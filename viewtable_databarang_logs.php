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
                <th>Log Deskripsi</th>
                <th>Log Waktu</th>
            </tr>
            <?php
            // Jumlah konten per table
            $results_per_page = 4;

            // Validasi halaman yang sedang digunakan
            if (!isset($_GET['page'])) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }

            $start_from = ($page - 1) * $results_per_page;

            // Menggunakan Query untuk membuat limit dalam satu table
            $getDataObatLogs = "SELECT * FROM inputbaranglogs_tb ORDER BY logs_time  DESC LIMIT $start_from, $results_per_page";
            $showDataObatLogs = mysqli_query($conn, $getDataObatLogs);
            $noLoop = 1;
            $spasi = "  ";

            while ($viewDataObatLogs = mysqli_fetch_array($showDataObatLogs)) {
                ?>
                <tr>
                    <td>
                        <?php echo $noLoop++ + $start_from; ?>
                    </td>
                    <td>
                        <?php echo $viewDataObatLogs['logs_description']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataObatLogs['logs_time']; ?>
                    </td>
                </tr>
                <?php
            }
            ?>
        </table>

        <?php
        $sql = "SELECT * FROM inputbaranglogs_tb";
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
                echo "<a href='halaman_databarang_logs.php?page=" . $i . "' class='pagination'>" . $i . "</a>";
            }
        }

        if ($end_link < $total_pages) {
            echo "<span class='ellipsis'>...</span>";
            echo "<a href='halaman_databarang_logs.php?page=" . $total_pages . "' class='pagination'>" . $total_pages . "</a>";
        }
        echo "</div>";
        ?>
    </div>

</body>

</html>