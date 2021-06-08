<?php
require_once "../Utilitati/Conexiune.php";

class DataScatter
{
    public static function getData($requestData, $countLocs, $column,$columnSearchedValues)
    {
        //column is the search column exactly  country_txt or region_txt
        $numarlocatii = $countLocs;
        $dataForChart = array();
        //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $dbconn = getConnection();
        $stmt = '';
        $beginYear = $requestData['beginYear'];
        $lastYear = $requestData['lastYear'];
        $count = 0;
        $year = "";
        $month = "";
        $day = "";
        $filtre = "" . $column . "=? and iyear >=" . $beginYear . " AND iyear<=" . $lastYear;
        //the construction of the string filter
        if (isset($requestData['filtruSuicid']))
            $filtre = $filtre . " AND suicide=" . $requestData['filtruSuicid'];
        if (isset($requestData['filtruExtend']))
            $filtre = $filtre . " AND extended=" . $requestData['filtruExtend'];
        if (isset($requestData['filtruSucces']))
            $filtre = $filtre . " AND success=" . $requestData['filtruSucces'];
        if (isset($requestData['filtruTipAtac']))
            $filtre = $filtre . " AND attacktype1=" . $requestData['filtruTipAtac'];


        switch ($columnSearchedValues) {
            case 'numarDecese': {
                    $stmt = $dbconn->prepare("SELECT sum(nkill),iyear,imonth,iday FROM `terro_events` WHERE ".$filtre. " GROUP BY iyear,imonth,iday HAVING sum(nkill)>0");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("SELECT count(*),iyear,imonth,iday FROM `terro_events` WHERE ".$filtre." GROUP BY iyear,imonth,iday");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("SELECT sum(nwound),iyear,imonth,iday FROM terro_events WHERE ".$filtre." GROUP BY iyear,imonth,iday HAVING sum(nwound)>0");
                    break;
                }
        }
        if ($stmt === false) {
            echo $dbconn->error;
            die($dbconn->error);
        }
        for ($i = 1; $i <= $numarlocatii; $i++) {
            $currentLocation = $requestData["locatie" . $i];
            $dataValue = array();
            $stmt->bind_param("s", $currentLocation);
            $stmt->execute();
            $stmt->bind_result($count, $year, $month, $day);
            while ($stmt->fetch()) {
                $day=DataScatter::transform($day);
                $month=DataScatter::transform($month);
                array_push($dataValue, array($year . "-" . $month . "-" . $day, $count)); //standard format
            }
            array_push($dataForChart, array("name" => $currentLocation, "data" => $dataValue));
        }

        return ($dataForChart);
    }
    public static function transform($value)
    {
        //there are entries in the database which do not have a day or a month (the values are 0)
        //
        if ($value == "0")
            return "01";
        if ($value < 10 && strlen($value) == 2)
            return "0".$value;
        return $value;
    }
}
