<?php

namespace Controllers;

use MVC\Router;
use Model\ReportProxy;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportController
{
    public static function reporte(Router $router)
    {
        isAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (
                !isset($_POST['start_time']) ||
                !isset($_POST['end_time']) ||
                !self::isValidMysqlDatetime($_POST['start_time']) ||
                !self::isValidMysqlDatetime($_POST['end_time'])
            ) {
                $alertas['error'][] = 'Las fechas son obligatorias y deben estar en el formato correcto (MM-DD-YYYY)';
                $router->render('/reportes/reporte', ['alertas' => $alertas]);
                return;
            } else {
                $startDate = $_POST['start_time'];
                $endDate = date('Y-m-d', strtotime($_POST['end_time'] . ' +1 day'));


                $reporte = new ReportProxy();
                $salesData = $reporte->getReport($startDate, $endDate);

                $spreadsheet = new Spreadsheet();
                $sheet = $spreadsheet->getActiveSheet();

                // Add headers
                $sheet->setCellValue('A1', 'ID')
                    ->setCellValue('B1', 'Estado')
                    ->setCellValue('C1', 'Monto Total')
                    ->setCellValue('D1', 'Fecha')
                    ->setCellValue('E1', 'Descuento')
                    ->setCellValue('F1', 'Usuario')
                    ->setCellValue('G1', 'Método de Pago')
                    ->setCellValue('H1', 'Método de Envío')
                    ->setCellValue('I1', 'Costo de Envío')
                    ->setCellValue('J1', 'Productos');

                $headerStyle = [
                    'font' => ['bold' => true],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ];
                $sheet->getStyle('A1:J1')->applyFromArray($headerStyle);

                $rowNumber = 2;
                foreach ($salesData as $data) {
                    $sheet->fromArray($data, null, 'A' . $rowNumber);
                    $sheet->getStyle('J' . $rowNumber)->getAlignment()
                        ->setWrapText(true)
                        ->setVertical(Alignment::VERTICAL_TOP);
                    $rowNumber++;
                }

                foreach (range('A', 'J') as $col) {
                    $sheet->getColumnDimension($col)->setAutoSize(true);
                }

                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="sales_report.xlsx"');
                header('Cache-Control: max-age=0');

                ob_end_clean();

                $writer = new Xlsx($spreadsheet);
                $writer->save('php://output');
                exit;
            }
        }

        $router->render('/reportes/reporte');
    }

    public static function isValidMysqlDatetime($datetime)
    {
        $regex = '/^\d{4}-\d{2}-\d{2}$/';
        return preg_match($regex, $datetime) === 1;
    }
}
