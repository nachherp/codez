<?php
mysqli_report(MYSQLI_REPORT_OFF);

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "denthub";

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}
?>
