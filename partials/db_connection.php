<?php
    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $db = 'as_form';

$conn = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (mysqli_connect_errno())
  {
  echo "<b style='color:#FF0000'>Failed to connect to MySQL: " . mysqli_connect_error(). "</b>";
  }
else {
    echo "<b style='color:#73AD21'>Connection Established Successfully</b><br>";
}
