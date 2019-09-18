<?php
$pdo = include 'dbConnection.php';

$sum = 0;

do {
    $sum = 0;
    sleep(10);
    try{
    $stmtOnPen = $pdo->prepare("select count(_hc_lastop) from tchonlinesalesforce.account where _hc_lastop = 'PENDING'");
    $stmtOnPen->execute();
    $total = $stmtOnPen->fetch();
    $sum += $total[0];
    
    if ($sum == 0){
        $stmtRePen = $pdo->prepare("select count(_hc_lastop) from salesforcetecktail.account where _hc_lastop = 'PENDING'");
        $stmtRePen->execute();
        $total = $stmtRePen->fetch();
        $sum += $total[0];
    }
    if ($sum == 0){
        $stmtOnIn = $pdo->prepare("select count(_hc_lastop) from tchonlinesalesforce.account where _hc_lastop = 'INSERTED'");
        $stmtOnIn->execute();
        $total = $stmtOnIn->fetch();
        $sum += $total[0];
    }
    if ($sum == 0){
        $stmtReIn = $pdo->prepare("select count(_hc_lastop) from salesforcetecktail.account where _hc_lastop = 'INSERTED'");
        $stmtReIn->execute();
        $total = $stmtReIn->fetch();
        $sum += $total[0];
    }  
    } catch (Exception $e){
        echo 'Caught exception: '.  $e->getMessage(). "\n";
        echo  $e->getLine(). "\n";
    }
} while ($sum != 0);

$sqlFunc = "SELECT public.SyncParentteckOnlineRetail()";	
$stmtOnPen = $pdo-> prepare($sqlFunc);
$stmtOnPen->execute();

?>
