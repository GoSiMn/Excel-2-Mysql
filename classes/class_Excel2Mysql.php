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
       // private $duplicateRecordsFoundInDb;



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

            if ($this->conn->query($createDB) === TRUE)
            {
                echo 'Database "' .$db. '" created successfully. <br>';
                $this->conn->select_db($db);
            }
            else
            {
                echo 'Found error while creating database - ' . $this->conn->error .'<br>';
            }
        }


        /*  Create Table  */
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


        /*  Get all records form table  */
        public function fetch_records_from_db($table, array $columns)
        {
            $columns = implode(', ', $columns);
            $selectDbRecords = "SELECT $columns
                                    FROM $table";

            $getAllRecordsFromDB = $this->conn->query($selectDbRecords);

            if ($this->conn->errno)
            {
                die("Fail Select " . $this->conn->error);
            }
            return $getAllRecordsFromDB->fetch_all(MYSQLI_ASSOC);
            //print_r($getAllRecordsFromDB);

        }


        /* Add records in database table    */
        public function insert_records_in_db($table, array $dataToInsert)
        {
            $colNames = implode(', ', array_keys($dataToInsert));

            $i = 0;
            foreach($dataToInsert as $key => $val)
            {
                $strValue[$i] = "'" .$val. "'";
                $i++;
            }

            $colValues = implode(', ', $strValue);

            $insertRecordsInDb = "INSERT INTO $table ($colNames) VALUES ($colValues)";

            if($this->conn->query($insertRecordsInDb) === TRUE)
            {
                echo "<br>inserted <br>";
            }
            else
            {
                echo "Error - " .$this->conn->error;
            }
        }

        public function get_records_from_excel($inputFileName, $inputFileType, $sheetname)
        {
            /**  Create an Instance of our Read Filter, passing in the cell range  **/
            $filterSubset = new MyReadFilter(2,50,range('A','I'));

            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objReader->setLoadSheetsOnly($sheetname);
            $objReader->setReadFilter($filterSubset);
            $objPHPExcel = $objReader->load($inputFileName);

            // $excelSheetDataArray = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
             return $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

//            echo '<pre>';
//            print_r($excelSheetDataArray);
//            echo '</pre>';


            //$this->get_duplicate_records_from_db($excelSheetDataArray, $table);

        }


        public function get_duplicate_records_from_db($sheetData, $table, array $columns)
        {

            $columns = implode(', ', $columns);

            foreach ($sheetData as $excelrow) {
                //echo $excelrow['A'];
                if(!empty($excelrow['A']))
                {

                echo '<hr>Excel Records - <pre>';
                print_r($excelrow);
                echo '</pre>';


                $selectDuplicateRecordsFromDB = "SELECT $columns FROM $table WHERE stockID = '".$excelrow['A']."'";
                    
                    $duplicateRowsFromDB = $this->conn->query($selectDuplicateRecordsFromDB);
                    
                    if($duplicateRowsFromDB === FALSE) 
                    {
                        trigger_error('Wrong SQL : '. $selectDuplicateRecordsFromDB. '<br><b>Error : </b>' .$this->conn->error, E_USER_ERROR);
                    }
                    else 
                    {
                        $duplicateRowsFromDB->data_seek(0);
                        while($row = $duplicateRowsFromDB->fetch_assoc()) {
                            echo 'Database Records - <pre>';
                            print_r($row);
                            echo "</pre>";
                        }
                    }
                    

                    
                }
            }


        }

        protected function get_unique_records_from_excel()
        {

        }
        function update_column_having_new_values() {

        }

    }
?>
