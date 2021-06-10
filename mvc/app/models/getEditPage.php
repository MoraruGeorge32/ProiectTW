<?php

// require_once "../Utilitati/Conexiune.php";

class getEditPage{
    public static function createLink($id){
        $paramLink="";
        $dbconn=getConnection();
        $query = "SELECT eventid,iyear,imonth,iday,country_txt,region_txt,city,latitude,longitude,suicide,extended,attacktype1_txt,targsubtype1_txt,success,weaptype1_txt,nkill,nwound,gname,motive,nperps from terro_events where eventid = ?";///completat cu ce coloane vrem
        $stmt = $dbconn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row_values=$res->fetch_assoc();
        foreach($row_values as $key=>$value){
            $paramLink=$paramLink.$key."=".$value."&";
        }
        $paramLink=substr($paramLink,0,-1);//deleting the last &
        $paramLink="../editView/edit.php?".$paramLink;
        return $paramLink;
    }
}