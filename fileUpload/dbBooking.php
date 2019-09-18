<?php

$pdo = include 'dbConnection.php';
$sqlInsert = "INSERT INTO public.bookings (Id, Officeid, Type, Bkgs) VALUES (?, ?, ?, ?)";
$sqlUpdate = "UPDATE public.bookings SET Officeid = ?, Type = ?, Bkgs = ? WHERE Id = ?";
$sqlSearch = "SELECT * FROM public.bookings WHERE id=? LIMIT 1";
$sqlSearchFk = "SELECT * FROM public.offices WHERE name=? LIMIT 1";
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
    $stmtSearchFk->execute([$_POST[$i]["OfficeId"]]);
    $valuesFk = $stmtSearchFk->fetch();
    
    if($valuesFk['name'] == $_POST[$i]["OfficeId"]){
        if($values['id'] == ''){
            if(!($stmtInsert->execute([$_POST[$i]["Id"], $_POST[$i]["OfficeId"], $_POST[$i]["Type"], $_POST[$i]["Bkgs"]]))){            
                $notInserted++;
            } else {
                $inserted++;
            }
            
        } else {
            if(!($stmtUpdate->execute([$_POST[$i]["OfficeId"], $_POST[$i]["Type"], $_POST[$i]["Bkgs"], $_POST[$i]["Id"]]))){
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

exit(json_encode($listResults));

?>