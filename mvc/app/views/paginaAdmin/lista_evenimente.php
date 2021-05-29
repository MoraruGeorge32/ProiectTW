<?php
    
    $dbconn = new mysqli("localhost", "Robert", "robert", "globalterrorismdb");
    if($dbconn->connect_error) {
        exit('Could not connect');
      }
    $sql = "SELECT eventid, iyear, imonth, iday, country_txt FROM globalterrorismdb_0718dist ORDER BY eventid LIMIT ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $_GET['counter']);
    $stmt->execute();
    $result = $stmt->get_result();
    $out = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    echo json_encode($out);
?>