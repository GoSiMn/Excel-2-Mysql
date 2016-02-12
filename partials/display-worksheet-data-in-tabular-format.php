<?php
/*  *********************************
<!--     Display Sheet Data     -->
*************************************/


 //$inputFileName = './workbooks/Research Performance Tracker.xlsx';

/** Load $inputFileName to a PHPExcel Object  **/
//$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);



$objReader = PHPExcel_IOFactory::createReader('Excel2007');
$objReader->setReadDataOnly(true);

$objPHPExcel = $objReader->load($inputFileName);
$objWorksheet = $objPHPExcel->getActiveSheet();

echo '<table>' . "\n";
foreach ($objWorksheet->getRowIterator() as $row) {
  echo '<tr>' . "\n";

  $cellIterator = $row->getCellIterator();
  $cellIterator->setIterateOnlyExistingCells(false); // This loops all cells,
                                                     // even if it is not set.
                                                     // By default, only cells
                                                     // that are set will be
                                                     // iterated.
  foreach ($cellIterator as $cell) {
    echo '<td>' . $cell->getValue() . '</td>' . "\n";
  }

  echo '</tr>' . "\n";
}
echo '</table>' . "\n";
?>
