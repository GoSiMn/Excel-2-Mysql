<?php
/*  Create DB   */
$createDB = "CREATE DATABASE IF NOT EXISTS $db";

if($conn->query($createDB) === TRUE) {
    echo 'Database "'.$db.'" created successfully. <br>';
}
else {
    echo '<b style="color:#f00">Error in creating new database - </b><em>' . $conn->error . '</em><br>';
}
$conn->close();
?>
