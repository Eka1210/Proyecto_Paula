<?php

namespace Controllers;

use MVC\Router;
use Model\Sale;
use Model\Usuario;
use Model\client;
use Model\Product;
use Model\Productxsale;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportController
{
    public static function reporte(Router $router)
    {
        isAdmin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $startDate = $_POST['start_time'];
            $endDate = $_POST['end_time'];

            $sales = Sale::getSales($startDate, $endDate);

            // Create and populate the spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Set main headers
            $sheet->setCellValue('A1', 'ID')
                ->setCellValue('B1', 'Description')
                ->setCellValue('C1', 'Total Amount')
                ->setCellValue('D1', 'Date')
                ->setCellValue('E1', 'Discount')
                ->setCellValue('F1', 'Username')
                ->setCellValue('G1', 'Products');

            // Style headers
            $headerStyle = [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
            ];
            $sheet->getStyle('A1:G1')->applyFromArray($headerStyle);

            $rowNumber = 2;
            foreach ($sales as $sale) {
                $user = client::find($sale->userId);

                $productsxsale = Productxsale::whereAll('salesID', $sale->id);

                // Build products string
                $productsDetail = [];
                $totalItems = 0;

                foreach ($productsxsale as $pxs) {
                    $product = Product::find($pxs->productID);
                    $productsDetail[] = sprintf(
                        "%s (Cantidad: %d Total: $%.2f)",
                        $product->name,
                        $pxs->quantity,
                        $pxs->price
                    );
                    $totalItems += $pxs->quantity;
                }

                // Format date
                $fecha = date('Y-m-d H:i', strtotime($sale->fecha));

                // Set values
                $sheet->setCellValue('A' . $rowNumber, $sale->id)
                    ->setCellValue('B' . $rowNumber, $sale->description)
                    ->setCellValue('C' . $rowNumber, '$' . number_format($sale->monto, 2))
                    ->setCellValue('D' . $rowNumber, $fecha)
                    ->setCellValue('E' . $rowNumber, '$' . number_format($sale->discount, 2))
                    ->setCellValue('F' . $rowNumber, $user->name)
                    ->setCellValue('G' . $rowNumber, implode("\n", $productsDetail));

                // Adjust row height for products list
                $sheet->getRowDimension($rowNumber)->setRowHeight(-1);

                // Set text wrapping for products column
                $sheet->getStyle('G' . $rowNumber)
                    ->getAlignment()
                    ->setWrapText(true)
                    ->setVertical(Alignment::VERTICAL_TOP);

                $rowNumber++;
            }

            // Auto-size columns
            foreach (range('A', 'G') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

            // Set headers for file download
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="sales_report.xlsx"');
            header('Cache-Control: max-age=0');

            // Clear any previous output
            ob_end_clean();

            // Save the Excel file to output
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            exit;
        }

        $router->render('/reportes/reporte');
    }
}
