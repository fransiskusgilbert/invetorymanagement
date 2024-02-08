<?php
include('database/db_koneksi.php');
require __DIR__ . '/vendor/autoload.php'; // Include PhpSpreadsheet autoloader


$getDate = isset($_GET['cari_data']) ? $_GET['cari_data'] : '';
$formatName = date('d-m-Y', strtotime($getDate));
// Nama file excell
$fileName = 'Data penjualan untuk tanggal ' . $formatName . '.xlsx'; // Change file extension to xlsx

// Create a new PhpSpreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Colum table
$collName = array('No.', 'Total Tagihan Kredit', 'Total Tagihan Cash', 'Total Omzet', 'Total Penjualan', 'Shift', 'Tanggal Shift', 'Nama Petugas');

// Set column headers
$columnIndex = 1;
foreach ($collName as $columnName) {
    $sheet->setCellValueByColumnAndRow($columnIndex, 1, $columnName);

    // Set borders for header cells
    $styleArrayHeader = [
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            ],
        ],
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        ],
    ];
    $sheet->getStyleByColumnAndRow($columnIndex, 1)->applyFromArray($styleArrayHeader);

    $columnIndex++;
}

// Fetch records from database 
if (isset($_GET['cari_data'])) {
    $cari_data = $_GET['cari_data'];

    $query = mysqli_query($conn, "SELECT * FROM datapenjualan_tb WHERE datapenjualan_tglShift LIKE '%" . $cari_data . "%'");
    $no = 1;

    if (mysqli_num_rows($query) > 0) {
        // Output each row of the data 
        $rowIndex = 2; // Start from the second row for data

        // Apply the style outside the loop
        $styleArray = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
        ];

        while ($row = $query->fetch_assoc()) {
            // Format numbers as currency (inside the loop)
            $totalKreditFormatted = 'Rp ' . number_format($row['datapenjualan_kredit'], 0, ',', '.');
            $totalCashFormatted = 'Rp ' . number_format($row['datapenjualan_cash'], 0, ',', '.');
            $totalOmzetFormatted = 'Rp ' . number_format($row['datapenjualan_omzet'], 0, ',', '.');
            $totalPenjualanFormatted = 'Rp ' . number_format($row['datapenjualan_totalPenjualan'], 0, ',', '.');
            $tanggalShiftFormatted = date('d-m-Y', strtotime($row['datapenjualan_tglShift']));

            $lineData = array(
                $no++,
                $totalKreditFormatted,
                $totalCashFormatted,
                $totalOmzetFormatted,
                $totalPenjualanFormatted,
                $row['datapenjualan_shift'],
                $tanggalShiftFormatted,
                $row['nama_pegawai']
            );

            // Set values for each cell in the current row
            $columnIndex = 1;
            foreach ($lineData as $cellValue) {
                $sheet->setCellValueByColumnAndRow($columnIndex, $rowIndex, $cellValue);

                // Set borders for data cells
                $sheet->getStyleByColumnAndRow($columnIndex, $rowIndex)->applyFromArray($styleArray);

                $columnIndex++;
            }

            $rowIndex++;
        }
    } else {
        $sheet->setCellValueByColumnAndRow(1, 2, 'No records found...');
    }
}

// Set column widths
$columnIndex = 1;
$columnWidths = [5, 20, 20, 15, 15, 15, 20, 20]; // Adjust the values as needed

foreach ($collName as $columnName) {
    $sheet->getColumnDimensionByColumn($columnIndex)->setWidth($columnWidths[$columnIndex - 1]);
    $columnIndex++;
}

// Create a writer and output to browser
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

// Headers for download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Save the file to the output
$writer->save('php://output');
?>