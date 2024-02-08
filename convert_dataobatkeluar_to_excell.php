<?php
include('database/db_koneksi.php');
require __DIR__ . '/vendor/autoload.php'; // Include PhpSpreadsheet autoloader

// Nama file excell
$fileName = 'Data obat keluar keseluruhan .xlsx'; // Change file extension to xlsx

// Create a new PhpSpreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Colum table
$collName = array('No.', 'Nama Obat', 'Jumlah Stock Awal', 'Jumlah Stock Keluar', 'Jumlah Sisa Stock', 'Tanggal Update');

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
$query = mysqli_query($conn, "SELECT * FROM dataobatkeluar_tb ORDER BY databarangkeluar_tanggal DESC");
$no = 1;

if ($query) {
    // Output each row of the data 
    $rowIndex = 2; // Start from the second row for data
    while ($row = $query->fetch_assoc()) {
        // Format numbers as currency (inside the loop)

        $lineData = array(
            $no++,
            $row['databarangkeluar_nama'],
            $row['databarangkeluar_stockAwal'],
            $row['databarangkeluar_stockKeluar'],
            $row['sisaStock'],
            $row['databarangkeluar_tanggal'],
        );

        // Set values for each cell in the current row
        $columnIndex = 1;
        foreach ($lineData as $cellValue) {
            $cell = $sheet->getCellByColumnAndRow($columnIndex, $rowIndex);
            $cell->setValue($cellValue);

            // Set borders for data cells
            $sheet->getStyleByColumnAndRow($columnIndex, $rowIndex)->applyFromArray($styleArray);

            // Apply text color only to 'Jumlah Sisa Stock' column
            if ($columnIndex == 5) { // Assuming 'Jumlah Sisa Stock' is the 5th column
                $sisaStock = (int) $row['sisaStock'];
                if ($sisaStock < 10) {
                    $cell->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                } else {
                    $cell->getStyle()->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_GREEN);
                }
            }

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
    $sheet->getColumnDimensionByColumn($columnIndex)->setWidth(20); // You can adjust the width as needed
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