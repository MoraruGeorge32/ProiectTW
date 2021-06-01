<?php
    
    $dbconn = new mysqli("localhost", "root", "", "terrorismdatabase");
    if($dbconn->connect_error) {
        exit('Could not connect');
      }
    $sql = "SELECT eventid, iyear, imonth, iday, country_txt FROM terro_events ORDER BY eventid LIMIT ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("i", $_GET['counter']);
    $stmt->execute();
   // $stmt->store_result();
   // $stmt->bind_result($evid, $an, $luna, $zi, $tara);
   // while( $stmt->fetch() ){
   //     echo htmlspecialchars($evid . " " . $an . " " . $luna . " " . $zi . " " . $tara . "\n");
   // }
    $result = $stmt->get_result();
    $out = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    echo json_encode($out);
?>