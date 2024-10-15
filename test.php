<?php
echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

$sql = "SELECT userid,username,fname,sname,email,signup FROM membs WHERE username = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['username']]);




?>