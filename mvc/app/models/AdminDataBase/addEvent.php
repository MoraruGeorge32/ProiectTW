<?php
include "../../Utilitati/Conexiune.php";
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

        $dbconn=getConnection();

        //$mysql = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $max_id_query = "Select eventid from terro_events order by eventid desc limit 1";
        $newID = $formInfo['iyear'] . $formInfo['imonth'] . $formInfo['iday'];


        //$res = $mysql->query($max_id_query);
        $res=$dbconn->query($max_id_query);
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

        if (/*$mysql->query($query)*/$dbconn->query($query) === TRUE) {
            return "Success";
        } else {
            return "Something went wrong!!! " . $dbconn->error;
        }

    }
}