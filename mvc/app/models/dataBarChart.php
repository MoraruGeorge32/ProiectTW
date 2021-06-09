<?php
// require_once "../Utilitati/Conexiune.php";
class DataBarChart
{
    public function getData($dataToProcess, $valuesCount, $column, $columnSearchedValues)
    {
        $numarlocatii = $valuesCount;
        $contor = 1;
        $dataPoints = array();
        //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $dbconn = getConnection();
        $rez = array();
        $stmt = '';
        $beginYear = $dataToProcess['beginYear'];
        $lastYear = $dataToProcess['lastYear'];
        $list = [];
        $filtre = "";
        for ($year = $beginYear; $year <= $lastYear; $year++) {
            array_push($list, $year);
        }
        $arrayYears = implode(',', $list);
        $filtre = $filtre . $column . " =? AND iyear IN (" . $arrayYears . ")";
        //the construction of the string filter
        if (isset($dataToProcess['filtruSuicid']))
            $filtre = $filtre . " AND suicide=" . $dataToProcess['filtruSuicid'];
        if (isset($dataToProcess['filtruExtend']))
            $filtre = $filtre . " AND extended=" . $dataToProcess['filtruExtend'];
        if (isset($dataToProcess['filtruSucces']))
            $filtre = $filtre . " AND success=" . $dataToProcess['filtruSucces'];
        if (isset($dataToProcess['filtruTipAtac']))
            $filtre = $filtre . " AND attacktype1=" . $dataToProcess['filtruTipAtac'];


        switch ($columnSearchedValues) {
            case 'numarDecese': {
                    //$stmt = $dbconn->prepare("select sum(cast( nkill as unsigned)) from terro_events where " . $column . "=? and iyear IN (" . $arrayYears . ")");
                    $stmt = $dbconn->prepare("select sum(cast( nkill as unsigned)) from terro_events where " . $filtre);
                    break;
                }
            case 'numarAtacuri': {
                    //$stmt = $dbconn->prepare("select count(*) from terro_events where " . $column . "=? and iyear IN (" . $arrayYears . ")");
                    $stmt = $dbconn->prepare("select count(*) from terro_events where " . $filtre);
                    break;
                }
            case 'numarRaniti': {
                    //$stmt = $dbconn->prepare("select sum(cast(nwound as unsigned)) from terro_events where " . $column . "=? and iyear IN (" . $arrayYears . ")");
                    $stmt = $dbconn->prepare("select sum(cast(nwound as unsigned)) from terro_events where " . $filtre);
                    break;
                }
        }

        if ($stmt === false) {
            die("Something went wrong");
        }
        for ($contor = 1; $contor <= $numarlocatii; $contor++) {
            $currentCountry = $dataToProcess['locatie' . $contor];
            $countValues = 0;
            $stmt->bind_param("s", $currentCountry);
            $stmt->execute();
            $stmt->bind_result($countValues);
            if ($stmt->fetch()) {
                if ($countValues === NULL) $countValues = 0;
                $rez[$currentCountry] = $countValues;
            }
        }
        for ($contor = 1; $contor <= $numarlocatii; $contor++) {
            $currentCountry = $dataToProcess['locatie' . $contor];
            array_push($dataPoints, array("name" => $currentCountry, "data" => $rez[$currentCountry]));
        }
        return $dataPoints;
    }
}