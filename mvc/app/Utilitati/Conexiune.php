<?php
function getConnection(){
    $dbconn = new mysqli("localhost", "root", "", "terrorismdatabase");
    if($dbconn===false){
        return null;
    }
    return $dbconn;
}