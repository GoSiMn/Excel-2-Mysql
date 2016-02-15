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

$recordsToInsert = array ( 'stockID' => 'EQ0001', 'stockName' => 'SBI', 'action' => 'BUY', 'entryDate' => '42229', 'entryPrice' => '2399', 'targetPrice' => '2415', 'stopLoss' => '2385', 'exitDate' => '42234', 'exitPrice' => '2392' );
?>

<?php

    $equity = new Excel2Mysql($host, $user, $pass, $db);

    $equity->create_table($table);

    $sheetData = $equity->get_records_from_excel($inputFileName, $inputFileType, $sheetname);
    //  Show data form table
    //  echo "<pre>";
    //  print_r($sheetData);
    //  echo "</pre>";


    //  Store table data in a varriable
    $tableData = $equity->fetch_records_from_db($table, $columns);

    //  Show data form table
    //      echo "Database data - <pre>";
    //      print_r($tableData);
    //      echo "</pre>";

    //  Insert records in database
    //$equity->insert_records_in_db($table, $recordsToInsert);



    $duplicatecols = $equity->get_duplicate_records_from_db($sheetData, $table, $columns);

   //print_r($duplicatecols);

?>

