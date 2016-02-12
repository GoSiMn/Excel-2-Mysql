<?php
require_once ('/PHPExcel/Classes/PHPExcel.php');

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Asia/Dili');
/** Error reporting */

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




    class Excel2Mysql extends MyReadFilter
    {
        public $conn;
        private $excelSheetDataArray;
        private $table;
        private $duplicateRecordsFoundInDb;


        function __construct($host, $user, $pass, $db)
        {
            $this->conn = new mysqli($host, $user, $pass);

            if($this->conn->connect_error === TRUE)
            {
                die("Connection Failed : " . $this->conn->connect_error).'<br>';

            }
            else
            {
                echo "Connection Setup Successfully. <br>";
                $this->create_and_select_db($db);
            }
        }

        /*  Create and select Database  */
        private function create_and_select_db($db)
        {
            $createDB = 'CREATE DATABASE IF NOT EXISTS '.$db;

            if ($this->conn->query($createDB))
            {
                echo 'Database "' .$db. '" created successfully. <br>';
                $this->conn->select_db($db);
            }
            else
            {
                echo 'Found error while creating database - ' . $this->conn->error .'<br>';
            }
        }


        /*  Create and select Database  */
        public function create_table($table)
        {
            $createTable = 'CREATE TABLE IF NOT EXISTS '. $table .' (
                ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                stockID VARCHAR(12) NOT NULL,
                stockName VARCHAR(50) NOT NULL,
                action VARCHAR(12) NOT NULL,
                entryDate VARCHAR(12) NOT NULL,
                exitDate VARCHAR(12) NOT NULL,
                entryPrice VARCHAR(12) NOT NULL,
                exitPrice VARCHAR(12) NOT NULL,
                targetPrice VARCHAR(12) NOT NULL,
                stopLoss VARCHAR(12) NOT NULL,
                callStartDate TIMESTAMP
            )';

            if ($this->conn->query($createTable) === TRUE)
            {
                echo 'Table "' .$table. '" created successfully.<br>';
            }
            else
            {
                echo 'Found Error while creating table - ' .$this->conn->error.'<br>';
            }

        }

        public function get_records_from_db()
        {
            $getAllRecordsFromDB = 'SELECT stockID, stockName,action,entryDate,entryPrice,targetPrice,stopLoss,exitDate,exitPrice FROM ' .$table. ' WHERE stockID ="' .$singleRow['A']. '"';
        }

        public function get_records_from_excel($inputFileName, $inputFileType, $sheetname, $table)
        {
            /**  Create an Instance of our Read Filter, passing in the cell range  **/
            $filterSubset = new MyReadFilter(2,50,range('A','I'));

            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setLoadSheetsOnly($sheetname);
            $objReader->setReadFilter($filterSubset);
            $objPHPExcel = $objReader->load($inputFileName);

            $excelSheetDataArray = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
//            echo '<pre>';
//            print_r($excelSheetDataArray);
//            echo '</pre>';


            $this->get_duplicate_records_from_db($excelSheetDataArray, $table);

        }

        protected function get_unique_records_from_excel()
        {

        }

        protected function insert_records_in_db()
        {

        }

        public function get_duplicate_records_from_db($excelSheetDataArray, $table)
        {
            foreach ($excelSheetDataArray as $excelrow) {
                if(!empty($excelrow['A'])) {
                    echo '<pre>';
            print_r($excelrow);
            echo '</pre>';


                echo $findDbRowHavingSameKey =  "SELECT
                                                stockID, stockName,
                                                action,
                                                entryDate,
                                                entryPrice,
                                                targetPrice,
                                                stopLoss,
                                                exitDate,
                                                exitPrice
                                            FROM ". $table ."
                                            WHERE stockID = '".$excelrow['A']."' <br>";
                }
            }

            //$duplicateRecordsFoundInDb = $this->conn->query($findDbRowHavingSameKey);
            $duplicateRecordsFoundInDb = $this->conn->query($findDbRowHavingSameKey);

            if (!$duplicateRecordsFoundInDb) {
                throw new Exception("Database Error [{$this->conn->errno}] {$this->conn->error}");
            }


            //if ($duplicateRecordsFoundInDb->num_rows>0) {
            $dbRowArray = $duplicateRecordsFoundInDb->fetch_assoc();

                    echo 'DB Array - ';
                    echo '<pre>';
                    print_r($dbRowArray);
                    echo '</pre><hr>';

            $excelRowArray = array(
                                'stockID'     =>$singleRow['A'],
                                'stockName'   =>$singleRow['B'],
                                'action'      =>$singleRow['C'],
                                'entryDate'   =>$singleRow['D'],
                                'entryPrice'  =>$singleRow['E'],
                                'targetPrice' =>$singleRow['F'],
                                'stopLoss'    =>$singleRow['G'],
                                'exitDate'    =>$singleRow['H'],
                                'exitPrice'   =>$singleRow['I']
                               );
          //  }


        }

        protected function update_column_having_new_values() {

        }

    }
?>
