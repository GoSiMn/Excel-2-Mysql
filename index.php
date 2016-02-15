<?php
/**
* PHPExcel
* OPPs reference - http://www.codeproject.com/Articles/880238/CRUD-Operation-by-MySqli-OOP-way-in-PHP
*/
include_once 'classes/class_Excel2Mysql.php';

$host  = 'localhost';
$user  = 'root';
$pass  = '';
$db    = 'as_excel';
$table = 'report_performance';

$inputFileName = './workbooks/Research Performance Tracker.xlsx';
$inputFileType = 'Excel2007';
$sheetname     = 'Equity';


$columns = array('stockID', 'stockName', 'action', 'entryDate', 'entryPrice', 'targetPrice', 'stopLoss', 'exitDate', 'exitPrice');

$recordsToInsert = array('stockID' => '15648', 'stockName' => 'anu');
?>

<?php

    $equity = new Excel2Mysql($host, $user, $pass, $db);

    $equity->create_table($table);

    //  Insert records in database

    // $equity->insert_records_in_db($table, $recordsToInsert);

    //  Store table data in a varriable
    $tableData = $equity->fetch_records_from_db($table, $columns);

    //  Show data form table
//      echo "Database data - <pre>";
//      print_r($tableData);
//      echo "</pre>";

    $sheetData = $equity->get_records_from_excel($inputFileName, $inputFileType, $sheetname);

    //  Show data form table
    //  echo "<pre>";
    //  print_r($sheetData);
    //  echo "</pre>";

    //$duplicatecols = $equity->get_duplicate_records_from_db($sheetData, $table, $columns);

   //print_r($duplicatecols);

    $a = array ( 'A' => 'EQ0001', 'B' => 'SBI', 'C' => 'BUY', 'D' => '42229', 'E' => '2399', 'F' => '2415', 'G' => '2385', 'H' => '42234', 'I' => '2392' );


    print_r($a);
echo "<br>";    
//$a = array_values($a);

function array_flatten($array) { 
  if (!is_array($array)) { 
    return false; 
  } 
  $result = array(); 
  foreach ($array as $key => $value) { 
    if (is_array($value)) { 
      $result = array_merge($result, array_flatten($value)); 
    } else { 
      $result[$key] = $value; 
    } 
  } 
  return $result; 
}

$ab = array_flatten($a);

echo "<br>";
var_dump($ab);

echo "<br>";
print_r($columns);
echo "<br>";
$b = array_fill_keys($columns, $a);
echo "<br><pre>";
print_r($b);
echo "<br></pre>";




?>



























<?php //include 'functions/set/connect-to-host.php'; ?>
<?php //include 'functions/set/create-db.php'; ?>
<?php //include 'functions/set/create-table.php'; ?>
<?php //include 'functions/get/DB-get-all-records.php'; ?>

<?php //include 'functions/get/EXCEL-prepare-worksheet-data-as-per-filter.php'; ?>
<?php //include 'functions/get/EXCEL-get-all-records.php'; ?>

<?php //include 'functions/get/get-new-records-from-excel.php'; ?>

<?php //include 'functions/get/get-all-values-of-new-records-from-excel.php' ?>

<?php //include 'functions/post/insert-new-records-in-db.php'; ?>
