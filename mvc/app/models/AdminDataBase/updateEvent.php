<?php
include_once "../Utilitati/Conexiune.php";

class updateEvent{
    public static function updateData($data){
        $dbconn = getConnection();
        $column_values="";
        $query = "UPDATE terro_events SET ";
        foreach($data as $key => $value)
        {
            if($key !== "eventid"){
                $column_values = $column_values.$key."=".$value.",";    
            }
        }
        
        $column_values=substr($column_values,0,-1);//sters ultima virgula
        $query = $query . $column_values." WHERE eventid=".$data['eventid'];
        if($dbconn->query($query)===false){
            echo "Error at updating the ".$data['eventid']." event";
        }
        else{
            echo "OK";
        }
    }
}
