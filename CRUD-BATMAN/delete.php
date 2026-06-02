<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$id = (int)$_GET['sid'];
include('conn.php');

mysqli_query($conn, "DELETE FROM $tablelog WHERE comic_id='$id'");

$_SESSION['status'] = "✔ COMIC #$id HAS BEEN REMOVED FROM THE DATABASE.";
header('Location: index.php');
exit();
?>
