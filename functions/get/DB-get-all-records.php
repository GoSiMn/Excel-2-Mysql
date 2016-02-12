<?php

$getAllStockIDs = "SELECT * FROM " .$tableName. "";

$results = $conn->query($getAllStockIDs);
//print_r($results);
$i=0;
if ($results->num_rows>0) {
    //echo $results->num_rows;

    while($row = $results->fetch_assoc()){
        //echo $row->stockID. '<br>';
        $allRecordsFromDB[$i]['id'] = $row['stockID'];
    $i++;
    }
//    echo "<b>DB - <em>(All Records)</em></b> - <br>";
//    echo '<pre>';
//    print_r($allRecordsFromDB);
//    echo '</pre>';
} else {
    echo "Sorry... No record found!";
}
?>
<br><br>

