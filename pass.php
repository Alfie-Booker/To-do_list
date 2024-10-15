<?php

echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

$password_in = $_POST['password'];
$new_password = $_POST['new_password'];
$new_password2 = $_POST['new_password2'];
$count = 0;
$sql = "SELECT * FROM membs WHERE username = ?";

$stat = $conn->prepare($sql);

$stat->bindParam(1,$_SESSION['username']);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

if($result){
$password = $result['password'];}


if (password_verify($password_in,$password)) {

    if ($new_password == $new_password2) {
        echo "pass match <br>";
        $new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE membs SET password = ? WHERE username = ?";
        $stat = $conn->prepare($sql);
        $stat->bindParam(1,$new_password);
        $stat->bindParam(2,$_SESSION['username']);
        $stat->execute();

    }
    else{ $count = $count + 1;}
}else{$count = $count + 1; }

if($count>0){
    $act = "apc";
}else{
    $act = "spc";
}
$logtime = time();

$sql = "INSERT INTO activity (userid, activity, date) VALUES (?,?,?)";
$stat = $conn->prepare($sql);

$stat->bindParam(1, $_SESSION['userid']);
$stat->bindParam(2, $act);
$stat->bindParam(3, $logtime);
$stat->execute();
header("refresh:1; url=profile.php");
?>
