<?php 

$show = array();
$hide = array();
$change = array();

function createJSON(){
    $data = array("total" => 0, "date" => "2018/08/05", "progress" => ""); 
    $fp = fopen('data.json', 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
}

function readJSON(){
    $my_file = 'data.json';
    $handle = fopen($my_file, 'r');
    $data = objectToArray(json_decode(fread($handle,filesize($my_file))));
    fclose($handle);
    return $data;
}

function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }
	
    if (is_array($d)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return array_map(__FUNCTION__, $d);
    }
    else {
        // Return array
        return $d;
    }
}

function writeJSON($data){
    $fp = fopen('data.json', 'w');
    fwrite($fp, json_encode($data));
    fclose($fp);
}

function addElementToHide($element){
    global $hide;
    array_push($hide, $element);
}

function addElementToShow($element){
    global $show;
    array_push($show, $element);
}

function addElementToChange($element, $data){
    global $change;
    $change[$element] = $data;
}

//sends json with all arrays included
function sendJSON(){
    global $show, $hide, $change;
    $arrJSON = array("show" => $show, "hide" => $hide, "change" => $change);
    $myJSON = json_encode($arrJSON);
    //echo("hello");
    echo $myJSON;
    die();
}

?> 