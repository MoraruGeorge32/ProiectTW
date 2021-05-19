<?php

class addEvent
{
    public static function insertData($formInfo)
    {
        $columns=array();
        $datas=array();
        foreach($formInfo as $data)
            array_push($datas,$data);
        foreach($formInfo as $key => $value)
            array_push($columns,$key);
        $mysql = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $columns_to_text = "";
        $values_to_text = "";
        foreach ($columns as $column) {
            $columns_to_text = $columns_to_text . $column . ",";
        }
        $columns = substr($columns_to_text, 0, -1);
        foreach ($datas as $value) {
            $values_to_text = $values_to_text . $value . ",";
        }
        
        $maxid="Select eventid from terro_events order by eventid desc limit 1";
        $values=substr($values_to_text,0,-1);
        //echo $columns . "<br><br><br>" . $values;
        /*
        $values=substr($values,0,-1);
        $query = "INSERT INTO terro_events ("
                    .$columns." ) VALUES ( "
                    .$values.")";
        if($mysql->query($query)===TRUE){
            echo "done";
        }
        $mysql->close();*/
        echo "Cerere realizata de adaugare a evenimentului";
    }
}
