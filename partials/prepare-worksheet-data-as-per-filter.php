<?php
require_once dirname(__FILE__) . '/../PHPExcel/Classes/PHPExcel.php';

$inputFileName = './workbooks/Research Performance Tracker.xlsx';
$inputFileType = 'Excel2007';
$sheetname     = 'Equity';


    /**  Define a Read Filter class implementing PHPExcel_Reader_IReadFilter  */
class MyReadFilter implements PHPExcel_Reader_IReadFilter
{
    private $_startRow = 0;
    private $_endRow   = 0;
    private $_columns  = array();

    /**  Get the list of rows and columns to read  */
    public function __construct($startRow, $endRow, $columns) {
        $this->_startRow = $startRow;
        $this->_endRow   = $endRow;
        $this->_columns  = $columns;
    }
public function readCell($column, $row, $worksheetName = '') {
        //  Only read the rows and columns that were configured
        if ($row >= $this->_startRow && $row <= $this->_endRow) {
            if (in_array($column,$this->_columns)) {
                return true;
            }
        }
        return false;
    }
}

/**  Create an Instance of our Read Filter, passing in the cell range  **/
$filterSubset = new MyReadFilter(2,25,range('A','I'));

$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setLoadSheetsOnly($sheetname);
$objReader->setReadFilter($filterSubset);
$objPHPExcel = $objReader->load($inputFileName);

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//print_r($sheetData);

//echo '<br><br>';
?>
