<?php
include_once 'constants.php' ;

$conn = new mysqli ($host, $user, $pass);

if($conn->connect_error) {
    die("<b style='color:#f00;'>Connection Failed - </b><em>" . $conn->connect_error) . '</em><br>';
}
else {
    echo 'Connection successfully established.<br>';
}
?>
