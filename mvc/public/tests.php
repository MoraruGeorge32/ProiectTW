<?php

include "../app/Utilitati/Conexiune.php";class DataBarChart
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
    public static function getData($requestData)
    {
        /*
        ce am nevoie sa intorc:
        numele tarilor + numarul de evenimente (raniti/omoruri etc) ---> pt series in js
        anii pentru axa Ox (pt fiecare an si pt fiecare tara este cate un numar de incidente)  ---> pt xaxis in js


        select nkill from terro_events where country_txt='China' and iyear = 1994
        */
        $column = "";
        switch ($requestData['tipStatistica']) {
            case 'numarDecese': {
                    $column = "nkill";
                    break;
                }
            case 'numarAtacuri': {
                    $column = "count(*)";
                    break;
                }
            case 'numarRaniti': {
                    $column = "nwound";
                    break;
                }
        }
        //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $dbconn = getConnection();
        $stmt = $dbconn->prepare("select " . $column . " from terro_events where country_txt=? and iyear = ?");
        /*
        alta idee
        se selectez coloana cu numarul si anul pentru iyear >=2017-interval */
        $numartari = $requestData['numarTari'];
        $beginYear = $requestData['beginYear'];
        $lastYear = $requestData['lastYear'];

        $sendData = array();

        for ($contor = 1; $contor <= $numartari; $contor++) {
            //per country
            $currentCountry = $requestData["tara" . $contor];
            $valuesCountry = array();
            for ($year = $beginYear; $year <= $lastYear; $year++) {
                //per year
                $countvalues = 0;
                $resultCount = 0;
                $stmt->bind_param("sd", $currentCountry, $year); // completezi query-ul
                $stmt->execute(); // executi query-ul
                $stmt->bind_result($resultCount); //rez obtinut de la fetch il voi prelua din $resultCount
                while ($stmt->fetch()) {
                    $countvalues = $countvalues + $resultCount;
                }
                array_push($valuesCountry, $countvalues);
            }
            array_push($sendData, array("name" => $currentCountry, "data" => $valuesCountry));
        }

        $dbconn->close();

        return $sendData;
    }
}
//$requestData=["numarTari"=>4,"tara1"=>"Romania","tara2"=>"Hungary","tara3"=>"Italy","tara4"=>"Ucraina","perioadaStatistica"=>15,"tipStatistica"=>"numarDecese"];
$requestData = ["numarTari" => 1, "tara1" => "China", "perioadaStatistica" => 15, "tipStatistica" => "numarDecese", "beginYear" => 2005, "lastYear" => 2017];
var_dump(DataBarChart::getData($requestData));
//var_dump(DataGraphic::getData($requestData));
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