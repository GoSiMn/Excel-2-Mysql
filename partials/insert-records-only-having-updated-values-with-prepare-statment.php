<?php

function as_is_not_null($cellVal){
        return !is_null($cellVal);
    }

$totalStockIds = $conn->query("SELECT ID FROM reports_performance WHERE stockID = 'sb2' ");

if(count($totalStockIds)>0) {		// If any record found
	while($row = $totalStockIds->fetch_object()) {
		echo $row->ID. '| ';
	}
}
else {
	if ($stmt = $conn->prepare("INSERT INTO reports_performance (stockID, stockName, action, entryDate, entryPrice, target, stopLoss, exitDate, exitPrice, plUnit, plLac, grossROI, finalResult) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)")) {

    $stmt->bind_param("sssssssssssss", $stockID, $stockName, $action, $entryDate, $entryPrice, $target, $stopLoss, $exitDate, $exitPrice, $plUnit, $plLac, $grossROI, $finalResult);


    foreach($sheetData as $row) {

        $row = array_filter($row, 'as_is_not_null');



        if(count($row)>0) {

            $values = array_values($row);

            $stockID = $values[0];
            $stockName = $values[1];
            $action = $values[2];
            $entryDate = $values[3];
            $entryPrice = $values[4];
            $target = $values[5];
            $stopLoss = $values[6];
            $exitDate = $values[7];
            $exitPrice = $values[8];
            $plUnit = $values[9];
            $plLac = $values[10];
            $grossROI = $values[11];
            $finalResult = $values[12];
            $stmt->execute();
        }
    }
    echo "New records created successfully";

    $stmt->close();
}
else {
    printf("Errormessage: %s\n", $conn->error);
}

}









?>
