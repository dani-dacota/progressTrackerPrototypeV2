<?php
    include 'json.php';

    $parameter = $_POST['parameter'];
    $argument = $_POST['argument'];

    if ($parameter != '' or $argument= ''){
        $data = readJSON();
        if ($parameter == 'dueDate') {
            $data["date"] = $argument;
            echo 'Changed Due Date to '. $data["date"];
        }
        if ($parameter == 'total') {
            $data["total"] = $argument;
            echo 'Changed Total to '. $data["total"];
        }
        writeJSON($data);
    } 
    else {
        header("Refresh:0; url=index.php");
    }
?>