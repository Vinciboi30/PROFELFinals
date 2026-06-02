<?php
$server     = "localhost";
$username   = "root";
$password   = "";
$dbname     = "batman_db";
$tablelog   = "comics";
$tablelogin = "users";

$conn = mysqli_connect($server, $username, $password, $dbname)
    or die("Cannot connect to Batman database.");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>
