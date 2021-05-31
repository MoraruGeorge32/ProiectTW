<?php
require_once "../Utilitati/Conexiune.php";
class DataBarChart
{
    public static function getData($dataToProcess)
    {
        $numartari = $dataToProcess['numarTari'];
        $contor = 1;
        $dataPoints = array();
        //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $dbconn=getConnection();
        $rez = array();
        $stmt = '';
        $interval = $dataToProcess['perioadaStatistica'];
        switch ($dataToProcess['tipStatistica']) {
            case 'numarDecese': {
                    $stmt = $dbconn->prepare("select sum(cast( nkill as unsigned)) from terro_events where country_txt=? and iyear>=" . (2017 - $interval));
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("select count(*) from terro_events where country_txt=? and iyear>=" . (2017 - $interval));
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("select sum(cast(nwound as unsigned)) from terro_events where country_txt=? and iyear>=" . (2017 - $interval));
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
