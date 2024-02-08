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
                <th>Nama Pegawai</th>
                <th>Nomor Pegawai</th>
                <th>Username</th>
                <th>Rules</th>
                <th>Status Pegawai</th>
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
            $getDataPegawai = "SELECT * FROM pegawai_tb   WHERE rules = 'user' ORDER BY pegawai_status DESC LIMIT $start_from, $results_per_page";
            $showDataPegawai = mysqli_query($conn, $getDataPegawai);
            $noLoop = 1;
            $spasi = "  ";

            while ($viewDataPegawai = mysqli_fetch_array($showDataPegawai)) {
                ?>
                <tr>
                    <td>
                        <?php echo $noLoop++ + $start_from; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPegawai['nama_pegawai']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPegawai['nomor_pegawai']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPegawai['user_pegawai']; ?>
                    </td>
                    <td>
                        <?php echo $viewDataPegawai['rules']; ?>
                    </td>
                    <td class="statusOnline">
                        <?php echo $viewDataPegawai['pegawai_status']; ?>
                    </td>
                    <td>
                        <div class="btn-edit-dataobat">
                            <a
                                href="function/edit_datapegawai_beta.php?id_pegawai=<?php echo $viewDataPegawai['id_pegawai']; ?>">
                                <p>Edit</p>
                            </a>
                            <a href="function/hapus_datapegawai.php?id_pegawai=<?php echo $viewDataPegawai['id_pegawai']; ?>"
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
        $sql = "SELECT * FROM pegawai_tb WHERE rules = 'user'";
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
                echo "<a href='halaman_datapegawai.php?page=" . $i . "' class='pagination'>" . $i . "</a>";
            }
        }

        if ($end_link < $total_pages) {
            echo "<span class='ellipsis'>...</span>";
            echo "<a href='halaman_datapegawai.php?page=" . $total_pages . "' class='pagination'>" . $total_pages . "</a>";
        }
        echo "</div>";
        ?>
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                var pegTable = document.querySelectorAll(".tb-dataobat");

                pegTable.forEach(function (table) {
                    var pegStatusElement = table.querySelectorAll(".statusOnline");


                    pegStatusElement.forEach(function (element) {
                        var pegStatus = parseInt(element.textContent.trim(), 2);

                        if (pegStatus == 0) {
                            element.innerText = "Tidak Aktif";
                            element.style.color = "red";
                        }
                        else {
                            element.innerText = "Aktif";
                            element.style.color = "green";
                        }

                        console.log(pegStatus);
                    });
                });
            });
        </script>
    </div>

</body>

</html>