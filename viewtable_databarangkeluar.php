<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="homestyle.css">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>

<body>
    <div class="tb-dataobat">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Obat</th>
                <th>Jumlah Stock Awal</th>
                <th>Jumlah Stock Keluar</th>
                <th>Jumlah Sisa Stock</th>
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

            // Menggunakan Query untuk membuat limit dalam satu table
            $getDataObatKeluar = "SELECT * FROM dataobatkeluar_tb ORDER BY databarangkeluar_nama  ASC LIMIT $start_from, $results_per_page";
            $showDataObatKeluar = mysqli_query($conn, $getDataObatKeluar);
            $noLoop = 1;
            $spasi = "  ";

            while ($viewDataObatKeluar = mysqli_fetch_array($showDataObatKeluar)) {
                ?>
                <tr>
                    <td>
                        <?php echo $noLoop++ + $start_from; ?>
                    </td>
                    <td>
                        <?php echo $viewDataObatKeluar['databarangkeluar_nama']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataObatKeluar['databarangkeluar_stockAwal']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataObatKeluar['databarangkeluar_stockKeluar']; ?>
                    </td>
                    <td class="viewSisaStock">
                        <?php echo $viewDataObatKeluar['sisaStock']; ?>
                    </td>
                    <td>
                        <?php echo date('d-m-Y', strtotime($viewDataObatKeluar['databarangkeluar_tanggal'])); ?>
                    </td>
                    <td>
                        <div class="btn-edit-dataobat">
                            <a
                                href="function/edit_databarangkeluar.php?databarangkeluar_id=<?php echo $viewDataObatKeluar['databarangkeluar_id']; ?>">
                                <p>Edit</p>
                            </a>
                            <a href="function/hapus_databarangkeluar.php?databarangkeluar_id=<?php echo $viewDataObatKeluar['databarangkeluar_id']; ?>&databarangkeluar_nama=<?php echo $viewDataObatKeluar['databarangkeluar_nama'] ?>"
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
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var tableSisa = document.querySelectorAll(".tb-dataobat");

                tableSisa.forEach(function (table) {
                    var sisaStockElements = table.querySelectorAll(".viewSisaStock");

                    sisaStockElements.forEach(function (element) {
                        var sisaStock = parseInt(element.textContent.trim(), 10);

                        if (sisaStock <= 10) {
                            element.style.color = "red";
                        } else {
                            element.style.color = "green";
                        }

                        console.log(sisaStock);
                    });
                });
                // console.log(tableSisa);
            });

        </script>

        <?php
        $sql = "SELECT * FROM dataobatkeluar_tb";
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
                echo "<a href='halaman_databarangkeluar.php?page=" . $i . "' class='pagination'>" . $i . "</a>";
            }
        }

        if ($end_link < $total_pages) {
            echo "<span class='ellipsis'>...</span>";
            echo "<a href='halaman_databarangkeluar.php?page=" . $total_pages . "' class='pagination'>" . $total_pages . "</a>";
        }
        echo "</div>";
        ?>
    </div>


</body>

</html>