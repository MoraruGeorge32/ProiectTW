<?php
require_once "../../Utilitati/Conexiune.php";
    //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
    $dbconn=getConnection();
    if($dbconn->connect_error) {
        exit('Could not connect');
      }
    $sql = "SELECT eventid, iyear, imonth, iday, country_txt FROM terro_events ORDER BY eventid LIMIT ?, ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("ii", $_GET['start'], $_GET['counter']);
    $stmt->execute();
    $result = $stmt->get_result();
    $out = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    echo json_encode($out);
?>