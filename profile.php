<?php

echo'<link rel="stylesheet" href="styles.css">';
include 'db_connect.php';
session_start();

$username = $_SESSION["username"];

$sql = "SELECT userid,username,fname,sname,email,signup FROM membs WHERE username = ?";

$stat = $conn->prepare($sql);
$stat->bindParam(1,$username);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

foreach ($result as $key=>$value) {
    echo $key." : ".$value."<br>";
}

$act = 'log';

$sql = "SELECT date FROM activity WHERE userid = ? AND activity = ? ORDER BY date DESC LIMIT 1 OFFSET 1";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$_SESSION['userid']);
$stat->bindParam(2,$act);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

echo "Last Login: ".date('Y-m-d H:i:s',$result['date'])."<br>";


$sql = "SELECT activity FROM activity WHERE userid = ? ORDER BY date DESC LIMIT 1 OFFSET 1";
$stat = $conn->prepare($sql);
$stat->bindParam(1,$_SESSION['userid']);
$stat -> execute();
$result = $stat->fetch(PDO::FETCH_ASSOC);

foreach ($result as $key=>$value) {

    echo 'Most recent action: ' .$value."<br>";
}

$actions = array("log","spc","apc");

foreach ($actions as $action){
    $sql = "SELECT COUNT(*) AS count FROM activity WHERE userid = ? AND activity = ?";
    $stat = $conn->prepare($sql);
    $stat->bindParam(1,$_SESSION['userid']);
    $stat->bindParam(2,$action);
    $stat -> execute();
    $result = $stat->fetch(PDO::FETCH_ASSOC);
    echo "Action: ".$action."   Times done: ".$result["count"]."<br>";
}


?>
    <form action="update.html">
    <input type="submit" value="change details">
    </form>

<form action="pass.html">
    <input type="submit" value="change password">
</form>



