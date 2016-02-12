<?php
    require_once 'constants.php';

    $conn = new mysqli($host, $user, $pass, $db);

    if($conn->connect_error) {
        die("<b style='color:#f00;'>Connection Failed - </b><em>" . $conn->connect_error) . '</em><br>';
    }
    else {
        /*  Table  Query  */
        $createTable = "CREATE TABLE IF NOT EXISTS ". $tableName ." (
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
        )";

        /*  Create table    */
        if($conn->query($createTable) === TRUE) {
            echo "Table '". $tableName ."' created successfully.";
        }
        else {
            echo '<b style="color:#f00;">Error while creating new table "' .$tableName. '" - </b>' . $conn->error;
        }
    }
?>
<br>
