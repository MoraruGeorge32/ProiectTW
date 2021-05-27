<?php


class DataBarChart
{
    public static function getData($dataToProcess)
    {
        $numartari = $dataToProcess['numarTari'];
        $contor = 1;
        $dataPoints = array();
        $mysqlConnect = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $rez = array();
        $stmt = '';
        $interval = $dataToProcess['perioadaStatistica'];
        switch ($dataToProcess['tipStatistica']) {
            case 'numarDecese': {
                    $stmt = $mysqlConnect->prepare("select sum(cast( nkill as unsigned)) from terro_events where country_txt=? ");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $mysqlConnect->prepare("select count(*) from terro_events where country_txt=? ");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $mysqlConnect->prepare("select sum(cast(nwound as unsigned)) from terro_events where country_txt=?");
                    break;
                }
        }

        for ($contor = 1; $contor <= $numartari; $contor++) {
            $currentCountry = $dataToProcess['tara' . $contor];
            $stmt->bind_param("s", $currentCountry);
            $stmt->execute();
            $countKills = 0;
            $stmt->bind_result($countKills);
            $stmt->fetch();
            $rez[$currentCountry] = $countKills;
        }
        for ($contor = 1; $contor <= $numartari; $contor++) {
            $currentCountry = $dataToProcess['tara' . $contor];
            array_push($dataPoints, array("y" => $rez[$currentCountry], "label" => $currentCountry));
        }
        return $dataPoints;
    }
}

/*
class DataGraphic
{
    public static function getData($requestData)
    {
        /*
        ce am nevoie sa intorc:
        numele tarilor + numarul de evenimente (raniti/omoruri etc) ---> pt series in js
        anii pentru axa Ox (pt fiecare an si pt fiecare tara este cate un numar de incidente)  ---> pt xaxis in js


        select nkill from terro_events where country_txt='China' and iyear = 1994
        *//*
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
        $mysqlConnect = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $stmt = $mysqlConnect->prepare("select " . $column . " from terro_events where country_txt=? and iyear = ?");
        $numartari = $requestData['numarTari'];
        $currentYear = 2017;
        $interval = $requestData['perioadaStatistica'];

        $sendData = array();

        for ($contor = 1; $contor <= $numartari; $contor++) {
            //per country
            $currentCountry = $requestData["tara" . $contor];
            $valuesCountry = array();
            for ($year = $currentYear - $interval; $year <= $currentYear; $year++) {
                //per year
                $countvalues = 0;
                $resultCount = 0;
                $stmt->bind_param("sd", $currentCountry, $year);
                if (!$stmt->execute()) continue;
                $stmt->bind_result($resultCount);
                while ($stmt->fetch()) {
                    $countvalues = $countvalues + $resultCount;
                    echo $currentCountry;
                }
                array_push($valuesCountry, $countvalues);
            }
            array_push($sendData, array("name" => $currentCountry, "data" => $valuesCountry));
        }

        $mysqlConnect->close();
        echo $sendData;
        return $sendData;
    }
}*/
//$requestData=["numarTari"=>4,"tara1"=>"Romania","tara2"=>"Hungary","tara3"=>"Italy","tara4"=>"Ucraina","perioadaStatistica"=>15,"tipStatistica"=>"numarDecese"];
$requestData=["numarTari"=>1,"tara1"=>"Italy","perioadaStatistica"=>15,"tipStatistica"=>"numarDecese"];
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