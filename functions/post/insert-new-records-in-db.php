<?php
    $insertNewRecordsFromExcelToDb  = "INSERT INTO " .$tableName. " (stockID, stockName,action,entryDate,entryPrice,targetPrice,stopLoss,exitDate,exitPrice ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($insertNewRecordsFromExcelToDb)) {

        $stmt->bind_param("sssssssss", $stockID, $stockName,$action,$entryDate,$entryPrice,$targetPrice,$stopLoss,$exitDate,$exitPrice);


        foreach($allRowsAsArrayFromExcel as $row) {
            if(count($row)>0) {
                $values             = array_values($row);

                $stockID            = $row["A"];
                $stockName          = $row["B"];
                $action             = $row["C"];
                $entryDate          = $row["D"];
                $entryPrice         = $row["E"];
                $targetPrice        = $row["F"];
                $stopLoss           = $row["G"];
                $exitDate           = $row["H"];
                $exitPrice          = $row["I"];

                $stmt->execute();
            }
        }
        echo "New records created successfully";

        $stmt->close();
    }
    else {
        echo '<br><b style          =color:#f00;>Error - </b>' . $conn->error;
    }
?>
