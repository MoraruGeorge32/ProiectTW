<?php
function getConnection(){
    $dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
    if($dbconn===false){
        return null;
    }
    return $dbconn;
}