<?php
require_once "../../Utilitati/Conexiune.php";
class listUpdateEvent{
    public function getListFromDb($page){
        $dbconn=getConnection();
        if($dbconn->connect_error) {
            exit('Could not connect');
        }
        $sql = "SELECT eventid, iyear, imonth, iday, country_txt, region_txt FROM terro_events LIMIT ?, ?";
        $stmt = $dbconn->prepare($sql);
        $offset = ($page-1)*15+1;
        $nr_events=15;
        $stmt->bind_param("ii", $offset, $nr_events);
        $stmt->execute();
        $result = $stmt->get_result();
        $out = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return json_encode($out);
    }
}

?>