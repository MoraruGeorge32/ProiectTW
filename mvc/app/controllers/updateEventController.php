<?php
function eJSONValid($sir)
{ // verifică dacă datele JSON sunt corecte
    json_decode($sir);
    return json_last_error() == JSON_ERROR_NONE;
}
$date = trim(file_get_contents("php://input"));
if (eJSONValid($date)) { 
    header("Content-type: application/json");
    echo json_encode($date);
} else
    die('Date incorecte');
