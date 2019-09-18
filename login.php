<?php

$username = $_POST["username"];
$password = $_POST["password"];

$pdo = include 'fileUpload/dbConnection.php';


$stmtCount = $pdo->prepare("SELECT * FROM verifylogin WHERE username = ? and password = ?");
$stmtCount->execute([$username, $password]);
$values = $stmtCount->fetch();

if($values["username"] != '' && $values["password"] != '' && $values["username"] == $username && $values["password"] == $password){
    session_start();
    $_SESSION["admin"] = $values["username"];
    $_SESSION["name"] = $values["name"];
    exit("0");
}

exit("1");

?>
