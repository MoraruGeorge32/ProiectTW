<?php
include_once "../app/Utilitati/Conexiune.php";
class mapModel {
    public static function mapEvent($data){
        $dbconn = getConnection();
        $resultsToSend = array();
        $currentRow= array();
        $selectResults = array();
        $selectResults = $dbconn->query($data);
            while($row = $selectResults->fetch_assoc())
            {
                foreach($row as $key => $value)
                {
                    $currentRow[$key] = $value;
                }
                array_push($resultsToSend,$currentRow);
            }
            return $resultsToSend;
        $dbconn->close();
    }
}


var_dump(mapModel::mapEvent("SELECT eventid, 
iyear, 
imonth,
iday,
country_txt,
region_txt, 
latitude, 
longitude, 
summary, 
attacktype1_txt, 
targtype1_txt, 
gname, 
nperps, 
weaptype1_txt, 
weapsubtype1_txt, 
nkill, 
nwound FROM terro_events WHERE region_txt='North America'"));