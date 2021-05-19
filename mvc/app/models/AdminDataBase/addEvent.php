<?php

class addEvent
{
    public static function insertData($columnsList, $valuesList)
    {
        $mysql = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $columns = "";
        $values = "";
        foreach ($columnsList as $column) {
            $columns = $columns . $column . ",";
        }
        $columns = substr($columns, 0, -1);
        foreach ($valuesList as $value) {
            $values = $values . $value . ",";
        }
        $values=substr($values,0,-1);
        echo $columns . "<br><br><br>" . $values;
        /*
        $values=substr($values,0,-1);
        $query = "INSERT INTO terro_events ("
                    .$columns." ) VALUES ( "
                    .$values.")";
        if($mysql->query($query)===TRUE){
            echo "done";
        }
        $mysql->close();*/
    }
}
