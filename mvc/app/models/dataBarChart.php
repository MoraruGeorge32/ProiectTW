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

        $stmt = $mysqlConnect->prepare("select sum(cast(nkill as unsigned)) from terro_events where country_txt=?");
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
