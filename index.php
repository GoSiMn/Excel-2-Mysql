<?php
/**
* PHPExcel
*/
include_once 'classes/class_Excel2Mysql.php';
//require_once dirname(__FILE__) . '/../../PHPExcel/Classes/PHPExcel.php';

$host  = 'localhost';
$user  = 'root';
$pass  = '';
$db    = 'as_excel';
$table = 'report_performance';

$inputFileName = './workbooks/Research Performance Tracker.xlsx';
$inputFileType = 'Excel2007';
$sheetname     = 'Equity';
?>

<?php

    $equity = new Excel2Mysql($host, $user, $pass, $db);

    $equity->create_table($table);


    $equity->get_records_from_excel($inputFileName, $inputFileType, $sheetname, $table);

    //$equity->get_duplicate_records_from_db();


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
