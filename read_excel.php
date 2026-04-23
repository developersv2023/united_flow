<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$out = '';

// ===== FILE 1: Detalledeventas.xls =====
$spreadsheet = IOFactory::load('C:\\laravel\\uc\\Detalledeventas.xls');

$out .= "=== DETALLEDEVENTAS.XLS ===\n";
$out .= "Sheet count: " . $spreadsheet->getSheetCount() . "\n\n";

foreach ($spreadsheet->getSheetNames() as $idx => $name) {
    $sheet = $spreadsheet->getSheet($idx);
    $maxR = $sheet->getHighestRow();
    $maxC = $sheet->getHighestColumn();
    $out .= "SHEET[$idx]: '$name' - Rows: $maxR - Col: $maxC\n";

    $limit = min(25, $maxR);
    for ($r = 1; $r <= $limit; $r++) {
        $data = [];
        foreach (range('A', $maxC) as $c) {
            $v = $sheet->getCell("$c$r")->getCalculatedValue();
            if ($v !== null && $v !== '') {
                $data[$c] = is_float($v) ? round($v, 2) : $v;
            }
        }
        if (!empty($data)) {
            $out .= "R$r: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        }
    }
    $out .= "---END SHEET---\n\n";
}

$out .= "\n\n=== ESTADODECTAAGENCIAS.XLS ===\n";
$spreadsheet2 = IOFactory::load('C:\\laravel\\uc\\Estadodectaagencias.xls');
$out .= "Sheet count: " . $spreadsheet2->getSheetCount() . "\n\n";

foreach ($spreadsheet2->getSheetNames() as $idx => $name) {
    $sheet = $spreadsheet2->getSheet($idx);
    $maxR = $sheet->getHighestRow();
    $maxC = $sheet->getHighestColumn();
    $out .= "SHEET[$idx]: '$name' - Rows: $maxR - Col: $maxC\n";

    $limit = min(25, $maxR);
    for ($r = 1; $r <= $limit; $r++) {
        $data = [];
        foreach (range('A', $maxC) as $c) {
            $v = $sheet->getCell("$c$r")->getCalculatedValue();
            if ($v !== null && $v !== '') {
                $data[$c] = is_float($v) ? round($v, 2) : $v;
            }
        }
        if (!empty($data)) {
            $out .= "R$r: " . json_encode($data, JSON_UNESCAPED_UNICODE) . "\n";
        }
    }
    $out .= "---END SHEET---\n\n";
}

file_put_contents('C:\\laravel\\united_flow\\analysis.json', $out);
echo "DONE\n";
