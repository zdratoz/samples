<?php
/*                                         phpinfo.php?p=5&g=0 
http://localhost/dev/Dropbox/BSP01/phpinfo.php?p=5&g=0
*/
session_start();
require 'excelLibs/vendor/autoload.php';
include_once($_SESSION["ROOT_PATH"] . '/config.php');
include_once($_SESSION["ROOT_PATH"] . '/BSP/php/BspFunctions.php');


$sql =   $_POST['sql'];
$table = $_POST['myHeaderInfo'];
$headers = $_POST['headers'];
$totalRows = $_POST['totalRecords'];
$group = $_POST['group'];
$limit = $_POST['limit'];
$file_pref = $_POST['file_pref'];
gc_collect_cycles();

use PhpOffice\PhpSpreadsheet\Spreadsheet;



/*styles*/

$headerStyle = [
    // FONT
    'font' => [
        'bold' => true,

    ],

    // ALIGNMENT
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ],

    // BORDER
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => '00000000']
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            'color' => ['argb' => '00000000']
        ],
        'left' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
            'color' => ['argb' => '00000000']
        ],
        'right' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000']
        ]

    ],
];

$dateStyle = [
    'font' => [
        'bold' => true,
        'underline' => true
    ],

    // ALIGNMENT
    'alignment' => [
        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
    ],

];

$groupStyle = [
    'font' => [
        'bold' => true,

    ],

    // ALIGNMENT
    'alignment' => [

        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
        'color' => ['rgb' => '9abdcc']

    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000']
        ],
        'bottom' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
            'color' => ['argb' => '00000000']
        ],


    ]
];




$spreadsheet = new Spreadsheet();
// execute mysql query to get data from db
$rows = getRecordCollection($sql, array($limit, 10000));

$myWorkSheet = $spreadsheet->getActiveSheet();
insert($myWorkSheet, $rows, $headers, $group, $headerStyle, $dateStyle, $groupStyle);
unset($rows);
unset($headers);
export($spreadsheet, $table, $file_pref);






header('Content-type: application/json');
$response_array['count'] = $file_pref;
echo json_encode($response_array);

function insert($sheet, $rows, $headers,   $group, $headerStyle, $dateStyle, $groupStyle)
{
    date_default_timezone_set('Europe/Athens');
    setlocale(LC_TIME, 'el_GR.UTF-8');
    $letter = 'A';
    $headerLetter = 'A';
    $groupColumn = '';

    /*set headers*/
    foreach ($headers as $header) {
        if ($headers[$group] == $header) {
            $groupColumn = $letter;
        }
        $sheet->setCellValue($letter . '1', $header);
        $sheet->getColumnDimension($letter)->setAutoSize(true);
        $sheet->getCell($letter . '1')->getStyle()->applyFromArray($headerStyle);
        $headerLetter = $letter;
        ++$letter;
    }

    //freeze left columns
    $sheet->freezePane('C1');

    //set Update-Info : date
    $sheet->getRowDimension('2')->setRowHeight(30);
    $sheet->mergeCells("A2:" . $headerLetter . "2");
    $sheet->setCellValue("A2", "Last Update : " . date(" D , Y/m/d H:i:s"));
    $sheet->getCell("A2")->getStyle()->applyFromArray($dateStyle);
    $sheet->getColumnDimension("A")->setAutoSize(true);

    //insert rows

    $rowCntr = 3;
    foreach ($rows as $row) {
        $row = array_values($row);
        if ($group > 0 &&  $row[$group] != $sheet->getCell($groupColumn . ($rowCntr - 1))->getValue()) {
            merge($sheet, $rowCntr, $headerLetter, $row[$group], $groupStyle);
            $rowCntr++;
        }
        $sheet->fromArray($row, NULL, 'A' . $rowCntr);
        $rowCntr++;
    }
}

function merge($sheet, $rowCntr, $headerLetter, $text, $groupStyle)
{
    $sheet->mergeCells("B" . $rowCntr . ":" . $headerLetter . $rowCntr);
    $sheet->setCellValue("B" . $rowCntr, $text);
    $sheet->getStyle("A" . $rowCntr . ":" . $headerLetter . $rowCntr)->applyFromArray($groupStyle);
}

function export($spreadsheet, $table, $file_pref)
{
    $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
    $writer->save($table . '_' . $file_pref . '.xls');
    $spreadsheet->disconnectWorksheets();
    unset($spreadsheet);
}
