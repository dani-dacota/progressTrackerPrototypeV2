<?php
    include 'json.php';

    $qs = $_POST['qs'];
    $date = $_POST['date'];
    $notes = $_POST['notes'];
    $action = $_POST['action'];
    
    if ($qs != ''){
        $data = readJSON();
        if ($action != "Delete"){
            $data["progress"][$date] = array("qs"=>$qs, "notes"=>$notes);
            echo "adding";
        }
        else {
            echo "deleting";
            unset($data["progress"][$date]);
        }
        writeJSON($data);
    } 
    else {
        header("Refresh:0; url=index.php");
    }
?>