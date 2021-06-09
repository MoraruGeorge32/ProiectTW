<?php
// require_once "../../Utilitati/Conexiune.php";
class addEvent
{
    public function createID($year, $month, $day, $dbconn)
    {
        $max_id_query = "SELECT eventid FROM terro_events WHERE iyear="
            . $year . " AND imonth="
            . $month . " AND iday="
            . $day
            . " ORDER BY eventid DESC LIMIT 1";
        if($month<10)
        $month="0".$month;
        if($day<10)
        $day="0".$day;
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
    public function insertData($formInfo)
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

        $newID = $this->createID(
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
