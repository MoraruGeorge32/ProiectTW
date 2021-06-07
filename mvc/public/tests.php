<?php

include "../app/Utilitati/Conexiune.php";
class DataBarChart
{
    public static function getData($dataToProcess)
    {
        $numartari = $dataToProcess['numarTari'];
        $contor = 1;
        $dataPoints = array();
        //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $dbconn = getConnection();
        $rez = array();
        $stmt = '';
        $interval = $dataToProcess['perioadaStatistica'];
        $beginYear = $dataToProcess['beginYear'];
        $lastYear = $dataToProcess['lastYear'];
        $list = [];
        for ($year = $beginYear; $year <= $lastYear; $year++) {
            array_push($list, $year);
        }
        $arrayYears = implode(',', $list);
        switch ($dataToProcess['tipStatistica']) {
            case 'numarDecese': {
                    $stmt = $dbconn->prepare("select sum(cast( nkill as unsigned)) from terro_events where country_txt=? and iyear IN (" . $arrayYears . ")");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("select count(*) from terro_events where country_txt=? and iyear IN (" . $arrayYears . ")");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("select sum(cast(nwound as unsigned)) from terro_events where country_txt=? and iyear IN (" . $arrayYears . ")");
                    break;
                }
        }
        if ($stmt === false) {
            die("Something went wrong");
        }
        for ($contor = 1; $contor <= $numartari; $contor++) {
            $currentCountry = $dataToProcess['tara' . $contor];
            $countValues = 0;
            $stmt->bind_param("s", $currentCountry);
            $stmt->execute();
            $stmt->bind_result($countValues);
            if ($stmt->fetch()) {
                if($countValues===NULL) $countValues=0;
                $rez[$currentCountry] = $countValues;
            }
        }
        for ($contor = 1; $contor <= $numartari; $contor++) {
            $currentCountry = $dataToProcess['tara' . $contor];
            array_push($dataPoints, array("name" =>$currentCountry , "data" => $rez[$currentCountry]));
        }
        return $dataPoints;
    }
}

class DataGraphic
{
    public static function getData($requestData, $valuesCount, $searchedColumn)
    {
        /*
        ce am nevoie sa intorc:
        numele tarilor + numarul de evenimente (raniti/omoruri etc) ---> pt series in js
        anii pentru axa Ox (pt fiecare an si pt fiecare tara este cate un numar de incidente)  ---> pt xaxis in js


        select nkill from terro_events where country_txt='China' and iyear = 1994
        */
        $column = "";
        $dbconn = getConnection();
        $numarlocatii = $valuesCount;
        $beginYear = $requestData['beginYear'];
        $lastYear = $requestData['lastYear'];
        switch ($requestData['tipStatistica']) {
            case 'numarDecese': {
                    $stmt = $dbconn->prepare("SELECT sum(nkill),iyear FROM terro_events where "
                        . $searchedColumn . "=? and iyear >=" . $beginYear . " AND iyear <=" . $lastYear . " GROUP BY iyear");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("SELECT count(*),iyear FROM terro_events where "
                        . $searchedColumn . "=? and iyear >=" . $beginYear . " AND iyear <=" . $lastYear . " GROUP BY iyear");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("SELECT sum(nwound),iyear FROM terro_events where "
                        . $searchedColumn . "=? and iyear >=" . $beginYear . " AND iyear <=" . $lastYear . " GROUP BY iyear");
                    break;
                }
        }
        //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        /*
        alta idee
        se selectez coloana cu numarul si anul pentru iyear >=2017-interval */

        $sendData = array();

        for ($contor = 1; $contor <= $numarlocatii; $contor++) {
            //per country   
            $currentCountry = $requestData["locatie" . $contor];
            $year = 1970;
            $currentYear=$beginYear;
            $valuesCountry = array();
            $countvalues = 0;
            $stmt->bind_param("s", $currentCountry);
            $stmt->execute();
            $stmt->bind_result($countvalues, $year);
            while ($stmt->fetch()) {
                for(;$currentYear<$year&&$currentYear<=$lastYear;$currentYear++){
                    array_push($valuesCountry,array("count"=>0,"year"=>$currentYear));//filling with 0 for the year that isn't any recorded data
                }
                $currentYear=$year+1;
                array_push($valuesCountry,array("count"=>$countvalues,"year"=>$year ));
            }
            array_push($sendData, array("name" => $currentCountry, "data" => $valuesCountry));
        }

        $dbconn->close();

        return $sendData;
    }
}
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
                        ." group by iyear,imonth,iday HAVING sum(nwound)>0");
                    break;
                }
        }
        if($stmt===false){
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
                array_push($dataValue, array($year . "-" . $month . "-" . $day, $count));//standard format
            }
            array_push($dataForChart, array("name"=>$currentLocation,"data"=> $dataValue));
        }
        return( $dataForChart);
    }
}

//$requestData=["numarTari"=>4,"tara1"=>"Romania","tara2"=>"Hungary","tara3"=>"Italy","tara4"=>"Ucraina","perioadaStatistica"=>15,"tipStatistica"=>"numarDecese"];
$requestData = ["numarTari" => 3, "locatie1" => "Mexico", "perioadaStatistica" => 15, "tipStatistica" => "numarDecese", "beginYear" => 2010, "lastYear" => 2012];
$bigData=["numarTari"=>3,"locatie1"=>"Mexico","locatie2"=>"Canada","locatie3"=>"United States","tipStatistica" => "numarDecese", "beginYear" => 1970, "lastYear" => 2017];
$bigData2=["numarTari"=>1,"locatie1"=>"Pakistan","tipStatistica" => "numarDecese", "beginYear" => 1970, "lastYear" => 2017];
//var_dump(DataGraphic::getData($bigData,3,'country_txt'));
var_dump(DataGraphic::getData($bigData2,1,'country_txt'));
//numarTari=4&tara1=Romania&tara2=Hungary&tara3=Italy&tara4=Germany&tipStatistica=numarDecese&perioadaStatistica=15&tipRedare=barChart
/*
$requestData=["numarTari"=>2,"tara1"=>"China","tara2"=>"Iran","perioadaStatistica"=>10,"tipStatistica"=>"numarAtacuri"];
var_dump($requestData);
echo "<br>";
$datas=DataGraphic::getData($requestData);
var_dump($datas);
echo "<br>";
echo json_encode($datas);
echo "<br>";
echo count($datas);*/