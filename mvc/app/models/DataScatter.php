<?php
class DataScatter
{
    public function getDataSingleLocationMultipleColumns($requestData,  $column, $columnSearchedValues)
    {
        $dataForChart = array();
        $dbconn = getConnection();
        $stmt = '';
        $beginYear = $requestData['beginYear'];
        $lastYear = $requestData['lastYear'];
        $year = "";
        $month = "";
        $day = "";
        $count = 0;
        $filtre = "" . $column . "=? and iyear >=" . $beginYear . " AND iyear<=" . $lastYear;
        if (isset($requestData['filtruSuicid']))
            $filtre = $filtre . " AND suicide=" . $requestData['filtruSuicid'];
        if (isset($requestData['filtruExtend']))
            $filtre = $filtre . " AND extended=" . $requestData['filtruExtend'];
        if (isset($requestData['filtruSucces']))
            $filtre = $filtre . " AND success=" . $requestData['filtruSucces'];
        if (isset($requestData['filtruTipAtac']))
            $filtre = $filtre . " AND attacktype1=" . $requestData['filtruTipAtac'];
        $bigArray = [];
        foreach ($columnSearchedValues as $columnTable) {
            if ($columnTable == "sum(nwound)") {
                $stmt = $dbconn->prepare("SELECT sum(nwound),iyear,imonth,iday FROM terro_events WHERE " . $filtre . " GROUP BY iyear,imonth,iday HAVING sum(nwound)>0");
                if ($stmt === false) {
                    echo $dbconn->error;
                    die($dbconn->error);
                }
                $dataWound = [];
                $stmt->bind_param("s", $requestData['locatie1']);
                $stmt->execute();
                $stmt->bind_result($values, $year, $month, $day);
                while ($stmt->fetch()) {
                    $day = DataScatter::transform($day);
                    $month = DataScatter::transform($month);
                    array_push($dataWound, array($year . "-" . $month . "-" . $day, $values));
                }
                array_push($bigArray, array("name" => "sum(nwound)", "data" => $dataWound));
            }
            if ($columnTable == "sum(nkill)") {
                $stmt = $dbconn->prepare("SELECT sum(nkill),iyear,imonth,iday FROM `terro_events` WHERE " . $filtre . " GROUP BY iyear,imonth,iday HAVING sum(nkill)>0");
                if ($stmt === false) {
                    echo $dbconn->error;
                    die($dbconn->error);
                }
                $dataKill = [];
                $stmt->bind_param("s", $requestData['locatie1']);
                $stmt->execute();
                $stmt->bind_result($values, $year, $month, $day);
                while ($stmt->fetch()) {
                    $day = DataScatter::transform($day);
                    $month = DataScatter::transform($month);
                    array_push($dataKill, array($year . "-" . $month . "-" . $day, $values));
                }
                array_push($bigArray, array("name" => "sum(nkill)", "data" => $dataKill));
            }
            if ($columnTable == "count(*)") {
                $stmt = $dbconn->prepare("SELECT count(*),iyear,imonth,iday FROM `terro_events` WHERE " . $filtre . " GROUP BY iyear,imonth,iday");
                if ($stmt === false) {
                    echo $dbconn->error;
                    die($dbconn->error);
                }
                $dataTotal = [];
                $stmt->bind_param("s", $requestData['locatie1']);
                $stmt->execute();
                $stmt->bind_result($values, $year, $month, $day);
                while ($stmt->fetch()) {
                    $day = DataScatter::transform($day);
                    $month = DataScatter::transform($month);
                    array_push($dataTotal, array($year . "-" . $month . "-" . $day, $values));
                }
                array_push($bigArray, array("name" => "count(*)", "data" => $dataTotal));
            }
        }

        return ["nameLocatie" => $requestData['locatie1'], "dataColoane" => $bigArray];
    }


    public function getData($requestData, $countLocs, $column, $columnSearchedValues)
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
                    $stmt = $dbconn->prepare("SELECT sum(nkill),iyear,imonth,iday FROM `terro_events` WHERE " . $filtre . " GROUP BY iyear,imonth,iday HAVING sum(nkill)>0");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("SELECT count(*),iyear,imonth,iday FROM `terro_events` WHERE " . $filtre . " GROUP BY iyear,imonth,iday");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("SELECT sum(nwound),iyear,imonth,iday FROM terro_events WHERE " . $filtre . " GROUP BY iyear,imonth,iday HAVING sum(nwound)>0");
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
                $day = DataScatter::transform($day);
                $month = DataScatter::transform($month);
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
        if ($value < 10)   // && strlen($value) == 2)
            return "0" . $value;
        return $value;
    }
}
