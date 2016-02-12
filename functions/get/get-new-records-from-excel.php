<br><br>
<?php 
	$newRecordsFromExcel = array_diff($allColumnsFromExcel, $allRecordsFromDB);
	//$newRecordsFromExcel = array_diff($allRecordsFromDB, $allColumnsFromExcel);

	if(count($newRecordsFromExcel)>0) {
		echo '<b>Total New Records in Excel - </b>';
		echo (count($newRecordsFromExcel));
		echo "<br>";
		echo '<b>New Records <em>(StockIDs)</em> - </b><br>';
		print_r($newRecordsFromExcel);	
	}
	else {
		echo "No New Record Found...!";
	}	
?>