<?php
include_once "../Utilitati/Conexiune.php";

class updateEvent
{
    public static function updateData($data)
    {
        /**
         * UPDATE terro_events SET 
         * city=San Francisco,
         * suicide=1,
         * extended=1,
         * success=1 WHERE 
         * eventid=197000000001
         */
        $dbconn = getConnection();
        $column_values = "";
        $query = "UPDATE terro_events SET ";
        foreach ($data as $key => $value) {
            if ($key !== "eventid") {
                if (
                    $key == "city" ||
                    $key == "region_txt" ||
                    $key == "country_txt" ||
                    $key == "attacktype1_txt" ||
                    $key == "targsubtype1_txt" ||
                    $key == "weaptype1_txt" ||
                    $key == "motive" ||
                    $key == "gname" ||
                    $key == "summary"
                )
                    $column_values = $column_values . $key . "='" . $value . "',";
                else
                    $column_values = $column_values . $key . "=" . $value . ",";
            }
        }

        $column_values = substr($column_values, 0, -1); //sters ultima virgula
        $query = $query . $column_values . " WHERE eventid=" . $data['eventid'];
        if ($dbconn->query($query) === false) {
            echo "Error at updating the " . $data['eventid'] . " event" . "  " . $dbconn->error;
        } else {
            echo "OK";
        }
    }
}
