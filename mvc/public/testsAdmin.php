<?php

include "../app/Utilitati/Conexiune.php";
class addEvent
{
    public static function createID($year, $month, $day, $dbconn)
    {
        $max_id_query = "SELECT eventid FROM terro_events WHERE iyear="
            . $year . " AND imonth="
            . $month . " AND iday="
            . $day
            . " ORDER BY eventid DESC LIMIT 1";
        $newID = $year . $month . $day;
        $res = $dbconn->query($max_id_query);
        $maxID = $res->fetch_assoc();

        if ($maxID === NULL) {
            $newID = $newID . "0001";
        } else {
            $lastDigits = substr($maxID["eventid"], strlen($maxID["eventid"]) - 4, 4);
            $contor = 0;
            for (; $lastDigits[$contor] == 0 && $contor < 4; $contor++);
            $currentValue = substr($lastDigits, $contor);
            $currentValue++;
            $currentValue = str_pad($currentValue, 4, "0", STR_PAD_LEFT);
            $newID = $newID . $currentValue;
        }
        return $newID;
    }
    public static function insertData($formInfo)
    {
        $columns = array();
        $datas = array();
        foreach ($formInfo as $data)
            array_push($datas, $data);
        foreach ($formInfo as $key => $value)
            array_push($columns, $key);

        $columns_to_text = "";
        $values_to_text = "";

        foreach ($columns as $column) {
            $columns_to_text = $columns_to_text . $column . ",";
        }
        foreach ($datas as $value) {
            $values_to_text = $values_to_text . $value . "'" . ",'";
        }
        $values_to_text = substr($values_to_text, 0, -2);
        $columns_to_text = substr($columns_to_text, 0, -1);

        $dbconn = getConnection();

        $newID = addEvent::createID(
            $formInfo['iyear'],
            $formInfo['imonth'],
            $formInfo['iday'],
            $dbconn
        );
        $query = "INSERT INTO terro_events (eventid,"
            . $columns_to_text . " ) VALUES ( " . $newID . ",'"
            . $values_to_text . ")";

        if ($dbconn->query($query) === TRUE) {
            return "Success";
        } else {
            return "Something went wrong!!! " . $dbconn->error;
        }
    }
}


//$data=json_decode(file_get_contents('php://input'), true);
$message = '{"iyear":"2017","imonth":"12","iday":"31","country_txt":"Romania","region_txt":"Eastern Europe","city":"Hirlau","latitude":"47.4278","longitude":"26.9114","suicide":"nu","extended":"nu","attacktype1_txt":"Atac asupra adresei mele personale","targsubtype1_txt":"Eu","success":"nu","weaptype1_txt":"prea multa militarie la ei","nkill":"0","nwound":"999","gname":"Facultate de informatica Iasi","motive":"Prea multe proiecte","nperps":"999"}';
//$data = json_decode($message, true);
//echo "<br>".addEvent::insertData($data);
//echo json_encode('{"a":1,"b":2,"c":3,"d":4,"e":5}');
/*
{"iyear":"2022","imonth":"12","iday":"26","country_txt":"Romania","region_txt":"Eastern Europe","city":"Hirlau","latitude":"47.4278","longitude":"26.9114","vecinity":"Iasi,Botosani,Pascani,Piatra Neamt","suicide":"nu","extended":"nu","attacktype1_txt":"Atac asupra adresei mele personale","targsubtype1_txt":"Eu","success":"nu","weaptype1_txt":"prea multa militarie la ei","nkill":"0","nwound":"999","gname":"Facultate de informatica Iasi","motive":"Prea multe proiecte","nperps":"999"}
*/

echo addEvent::insertData(json_decode($message,true));
/*
$dbconn=getConnection();
$formInfo = ["iyear" => 2017, "imonth" => 12, "iday" => 31];
$max_id_query = "SELECT eventid FROM terro_events WHERE iyear="
    . $formInfo['iyear'] . " AND imonth="
    . $formInfo['imonth'] . " AND iday="
    . $formInfo['iday']
    . " ORDER BY eventid DESC LIMIT 1";
$newID = $formInfo['iyear'] . $formInfo['imonth'] . $formInfo['iday'];


//$res = $mysql->query($max_id_query);
$res = $dbconn->query($max_id_query);
$maxID = $res->fetch_assoc();

if($maxID===NULL){
    $newID=$newID."0001";
}
else{
    $lastDigits = substr($maxID["eventid"], strlen($maxID["eventid"]) - 4, 4);
    $contor=0;
    for(;$lastDigits[$contor]==0&&$contor<4;$contor++);
    $currentValue=substr($lastDigits,$contor);
    $currentValue++;
    echo $maxID['eventid']."<br>".$currentValue."<br>";
    $currentValue=str_pad($currentValue,4,"0",STR_PAD_LEFT);

    echo $maxID['eventid']."<br>".$currentValue."<br>";
    $newID = $newID . $currentValue;
}
*/