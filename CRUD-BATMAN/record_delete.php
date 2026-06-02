<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
include("conn.php");

$tableMap = [
    'comics'   => ['db'=>'comics',           'pk'=>'comic_id'],
    'movies'   => ['db'=>'live action movies','pk'=>'movie_id'],
    'animated' => ['db'=>'animated series',  'pk'=>'series_id'],
    'artworks' => ['db'=>'artworks',         'pk'=>'artwork_id'],
];
$t   = isset($_GET['table']) && array_key_exists($_GET['table'], $tableMap) ? $_GET['table'] : 'comics';
$cfg = $tableMap[$t];
$id  = (int)$_GET['sid'];

mysqli_query($conn, "DELETE FROM `{$cfg['db']}` WHERE `{$cfg['pk']}`='$id'");
$_SESSION['status'] = "✔ RECORD #$id DELETED.";
header("Location: manage.php?table=$t");
exit();
