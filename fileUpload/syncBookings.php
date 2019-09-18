<?php

session_start();
if(!isset($_SESSION["admin"])){ header("Location: ../");exit();}

$pdo = include 'dbConnection.php';

sleep(10);

$sqlFunc = "SELECT public.syncBookings()";    
$stmtOnPen = $pdo-> prepare($sqlFunc);
$stmtOnPen->execute();
$response = $stmtOnPen->fetch();

exit($response);

?>