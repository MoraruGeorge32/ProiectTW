<?php
require_once "../Utilitati/Conexiune.php";

class DataScatter
{
    public static function getData($requestData, $countLocs, $column)
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
        switch ($requestData['tipStatistica']) {
            case 'numarDecese': {
                    $stmt = $dbconn->prepare("SELECT sum(nkill),iyear,imonth,iday FROM `terro_events` WHERE "
                        . $column . "=? AND iyear>=" . $beginYear . " AND iyear<=" . $lastYear
                        . " GROUP BY iyear,imonth,iday HAVING sum(nkill)>0");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("SELECT count(*),iyear,imonth,iday FROM `terro_events` WHERE "
                        . $column . "=? AND iyear>=" . $beginYear . " AND iyear<=" . $lastYear
                        . " GROUP BY iyear,imonth,iday");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("select sum(nwound),iyear,imonth,iday from terro_events where "
                        . $column . "=? and iyear >= " . $beginYear . " and iyear<= " . $lastYear
                        . " group by iyear,imonth,iday HAVING sum(nwound)>0");
                    break;
                }
        }
        if ($stmt === false) {
            echo $dbconn->error;
            die("murim cu gratie. Eroare de conectare la baza de date");
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
