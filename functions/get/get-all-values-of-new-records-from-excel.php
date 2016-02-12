<?php
$j = 0;
foreach ($allRowsAsArrayFromExcel as $singleRow) {


    $findDbRowHavingSameKey = "SELECT stockID, stockName,action,entryDate,entryPrice,targetPrice,stopLoss,exitDate,exitPrice
                        FROM ". $tableName ."
                        WHERE stockID = '".$singleRow['A']."' ";

    $duplicateRecordsFoundInDb = $conn->query($findDbRowHavingSameKey);

    if ($duplicateRecordsFoundInDb->num_rows>0) {
        $dbRowArray = $duplicateRecordsFoundInDb->fetch_assoc();

//        echo 'DB Array - ';
//        echo '<pre>';
//        print_r($dbRowArray);
//        echo '</pre><hr>';

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

//        echo 'Excel array - ';
//        echo '<pre>';
//        print_r($excelRowArray);
//        echo '</pre><hr>';

        $getColumnsHavingDifferentValue = array_diff_assoc($excelRowArray,$dbRowArray);


        //echo "diff -";
        //print_r($getColumnsHavingDifferentValue);
        if(count($getColumnsHavingDifferentValue)>0) {
            $colName = '';
            foreach ($getColumnsHavingDifferentValue as $key => $value) {
                $colName .= $key.' = "'.$value.'",';
            }
            $colName = substr($colName,0,-1);

            echo $updateColumnHavingNewValue = 'UPDATE ' .$tableName. ' SET ' .$colName. ' WHERE stockID = "' .$singleRow["A"]. '" ';

            if($updateColumnHavingNewValue = $conn->query($updateColumnHavingNewValue) === TRUE) {
                echo "Values modified successfully";
            }
            else {
                echo '<br><b style=color:#f00;>Error - </b>' . $conn->error ;
            }
            echo "<br>diff -";
            print_r($getColumnsHavingDifferentValue);
            echo '</pre>';
        }
        else {
            $j++;
        }


    }
    else {
         echo '<b style="color:#00f;">New row found in excel sheet</b><br>';
        include_once '/../post/insert-new-records-in-db.php';
    }

}
//echo $j;
if($j > 1) {
    echo '<br><b style="color:#00f;">No updation found in existing records.</b>';
}
?>
