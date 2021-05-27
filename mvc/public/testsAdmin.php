<?php

class addEvent
{
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

        $mysql = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $max_id_query = "Select eventid from terro_events order by eventid desc limit 1";
        $newID = $formInfo['iyear'] . $formInfo['imonth'] . $formInfo['iday'];


        $res = $mysql->query($max_id_query);
        $maxID = $res->fetch_assoc();
        $lastDigits = substr($maxID["eventid"], strlen($maxID["eventid"]) - 4, 4);
        $newID = $newID . $lastDigits;

        /*
        echo "<br>" . $newID . "<br>";
        var_dump($columns_to_text);
        echo "<br>";
        var_dump($values_to_text);
        echo "<br>";
        */
        $query = "INSERT INTO terro_events (eventid,"
            . $columns_to_text . " ) VALUES ( " . $newID . ",'"
            . $values_to_text . ")";

        if ($mysql->query($query) === TRUE) {
            return "Success";
        } else {
            return "Something went wrong!!! " . $mysql->error;
        }

    }
}
//$data=json_decode(file_get_contents('php://input'), true);
$message = '{"iyear":"2022","imonth":"12","iday":"26","country_txt":"Romania","region_txt":"Eastern Europe","city":"Hirlau","latitude":"47.4278","longitude":"26.9114","suicide":"nu","extended":"nu","attacktype1_txt":"Atac asupra adresei mele personale","targsubtype1_txt":"Eu","success":"nu","weaptype1_txt":"prea multa militarie la ei","nkill":"0","nwound":"999","gname":"Facultate de informatica Iasi","motive":"Prea multe proiecte","nperps":"999"}';
$data = json_decode($message, true);
 echo "<br>".addEvent::insertData($data);
//echo json_encode('{"a":1,"b":2,"c":3,"d":4,"e":5}');
/*
{"iyear":"2022","imonth":"12","iday":"26","country_txt":"Romania","region_txt":"Eastern Europe","city":"Hirlau","latitude":"47.4278","longitude":"26.9114","vecinity":"Iasi,Botosani,Pascani,Piatra Neamt","suicide":"nu","extended":"nu","attacktype1_txt":"Atac asupra adresei mele personale","targsubtype1_txt":"Eu","success":"nu","weaptype1_txt":"prea multa militarie la ei","nkill":"0","nwound":"999","gname":"Facultate de informatica Iasi","motive":"Prea multe proiecte","nperps":"999"}
*/