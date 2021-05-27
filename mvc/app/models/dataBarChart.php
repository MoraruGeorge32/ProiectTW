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
                    $stmt = $mysqlConnect->prepare("select sum(cast( nkill as unsigned)) from terro_events where country_txt=? and iyear>=" . (2017 - $interval));
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $mysqlConnect->prepare("select count(*) from terro_events where country_txt=? and iyear>=" . (2017 - $interval));
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $mysqlConnect->prepare("select sum(cast(nwound as unsigned)) from terro_events where country_txt=? and iyear>=" . (2017 - $interval));
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
