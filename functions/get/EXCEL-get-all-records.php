<?php

function is_not_null($cellVal){
        return !is_null($cellVal);
    }

foreach($sheetData as $sheetRow) {

    $allSheetRows = array_filter($sheetRow, 'is_not_null');

    if(count($allSheetRows)>0) {

           $allColumnsFromExcel[] = $allSheetRows['A'];

           $allRowsAsArrayFromExcel[] = $allSheetRows;

    }
}

// echo "<b>Excel - </b>";
// print_r($allColumnsFromExcel);
// echo '<br><br>';

//echo "<b>Excel <em>(All records)</em> - </b><br>";
//echo '<pre>';
//print_r($allRowsAsArrayFromExcel);
//echo '</pre>';
?>
<br><hr>
