<?php

require "lib/simple_html_dom.php";
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Параметры
$numberOfPages = 3;
$urlForParse = "https://arlight.ru/news/?loadedPages={$numberOfPages}";
$fileName = 'News';


// Получение страницы
$html = new simple_html_dom();
$html->load_file($urlForParse);

//Создаем экземпляр класса электронной таблицы
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Получение элемента
$titles = $html->find('.info__annotation-title-link');
$lineNumber = 1;

// Добавление в таблицу
foreach ($titles as $title) {
   $sheet->setCellValue("A{$lineNumber}", $title->plaintext);
   $sheet->setCellValue("B{$lineNumber}", "https://arlight.ru" . $title->href);
   $lineNumber++;
}

$writer = new Xlsx($spreadsheet);
$writer->save("{$fileName}.xls");
