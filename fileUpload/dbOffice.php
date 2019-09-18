<?php

$pdo = include 'dbConnection.php';
$sqlInsert = "INSERT INTO public.offices (Id, Name, AccountId) VALUES (?, ?, ?)";
$sqlUpdate = "UPDATE public.offices SET Name = ?, AccountId = ? WHERE Id = ?";
$sqlSearch = "SELECT * FROM public.offices WHERE id=? LIMIT 1";
$sqlSearchFk = "SELECT * FROM public.accounts WHERE id=? LIMIT 1";
$stmtInsert = $pdo->prepare($sqlInsert);
$stmtUpdate = $pdo->prepare($sqlUpdate);
$stmtSearch = $pdo->prepare($sqlSearch);
$stmtSearchFk = $pdo->prepare($sqlSearchFk);
$inserted = 0;
$notInserted = 0;
$updated = 0;
$notUpdated = 0;

for($i = 0; $i < sizeof($_POST); $i++){
    $stmtSearch->execute([$_POST[$i]["Id"]]);
    $values = $stmtSearch->fetch();
    $stmtSearchFk->execute([$_POST[$i]["AccountId"]]);
    $valuesFk = $stmtSearchFk->fetch();
    
    if($valuesFk['id'] == $_POST[$i]["AccountId"]){
        if($values['id'] == ''){
            if(!($stmtInsert->execute([$_POST[$i]["Id"], $_POST[$i]["Name"], $_POST[$i]["AccountId"]]))){
                 $notInserted++;
            } else {
                $inserted++;
            }
        } else {
            if(!($stmtUpdate->execute([$_POST[$i]["Name"], $_POST[$i]["AccountId"], $_POST[$i]["Id"]]))){
                $notUpdated++;
            } else {
                $updated++;
            }     
        } 
    } else {
        $notInserted++;
    }
    
}

$listResults = Array("Inserted" => $inserted, "Not Inserted" => $notInserted, "Updated" => $updated, "Not Updated" => $notUpdated);

include 'verifySyncOffice.php';

exit(json_encode($listResults));

?>
