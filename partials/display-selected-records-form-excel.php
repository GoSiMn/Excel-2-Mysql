
<?php
function is_not_null($cellVal){
        return !is_null($cellVal);
    }

foreach($sheetData as $row) {

    $row = array_filter($row, 'is_not_null');

    if(count($row)>0) {

        foreach($row as $col => $val) {
            echo $col . ' - ' . $val. ' | ';
        }
        //print_r($row);
        echo '<br>';
    }
}
?>
