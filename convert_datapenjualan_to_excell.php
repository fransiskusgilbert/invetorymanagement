<?php
include('database/db_koneksi.php');
require __DIR__ . '/vendor/autoload.php'; // Include PhpSpreadsheet autoloader

// Nama file excell
$fileName = 'Data penjualan keseluruhan .xlsx'; // Change file extension to xlsx

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
    $sheet->getStyleByColumnAndRow($columnIndex, 1)->applyFromArray($styleArray);

    $columnIndex++;
}

// Fetch records from database 
$query = mysqli_query($conn, "SELECT * FROM datapenjualan_tb ORDER BY datapenjualan_tglShift DESC");
$no = 1;

if ($query) {
    // Output each row of the data 
    $rowIndex = 2; // Start from the second row for data
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


// Set column widths
$columnIndex = 1;
foreach ($collName as $columnName) {
    $sheet->getColumnDimensionByColumn($columnIndex)->setWidth(15); // You can adjust the width as needed
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