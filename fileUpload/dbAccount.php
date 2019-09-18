<?php

$pdo = include 'dbConnection.php';
$sqlInsert = "INSERT INTO public.accounts (Id, Name, ParentId, Segment) VALUES (?, ?, ?, ?)";
$sqlUpdate = "UPDATE public.accounts SET Name = ?, ParentId = ?, Segment = ? WHERE Id = ?";
$sqlSearch = "SELECT * FROM public.accounts WHERE id=? LIMIT 1";
$stmtInsert = $pdo->prepare($sqlInsert);
$stmtUpdate = $pdo->prepare($sqlUpdate);
$stmtSearch = $pdo->prepare($sqlSearch);
$inserted = 0;
$notInserted = 0;
$updated = 0;
$notUpdated = 0;


for($i = 0; $i < sizeof($_POST); $i++){
    $stmtSearch->execute([$_POST[$i]["Id"]]);
    $values = $stmtSearch->fetch(); 
    
    if($values['id'] == ''){
        if(!($stmtInsert->execute([$_POST[$i]["Id"], $_POST[$i]["Name"], $_POST[$i]["ParentId"], $_POST[$i]["Segment"]]))){
            $notInserted++;
        } else {
            $inserted++;
        }
            
    } else {
        if(!($stmtUpdate->execute([$_POST[$i]["Name"], $_POST[$i]["ParentId"], $_POST[$i]["Segment"], $_POST[$i]["Id"]]))){
            $notUpdated++;
        } else {
            $updated++;
            
        }
    }
}
$listResults = Array("Inserted" => $inserted, "Not Inserted" => $notInserted, "Updated" => $updated, "Not Updated" => $notUpdated);

include 'verifySyncAccount.php';

exit(json_encode($listResults));

?>