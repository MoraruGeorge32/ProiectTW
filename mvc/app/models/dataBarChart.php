<?php
// require_once "../Utilitati/Conexiune.php";
class DataBarChart
{

    public function getDataSingleLocationMultipleColumns($dataToProcess, $column, $columnSearchedValues)
    {
        $selectColumnForData = "";
        foreach ($columnSearchedValues as $columnTable)
            $selectColumnForData = $selectColumnForData . $columnTable . ",";
        $selectColumnForData = substr($selectColumnForData, 0, -1); //eliminare ultima virgula

        $dbconn = getConnection();
        $rez = array();
        $stmt = '';
        $beginYear = $dataToProcess['beginYear'];
        $lastYear = $dataToProcess['lastYear'];
        $resultsSet = [];
        $list = []; //pt ani
        $filtre = "";
        for ($year = $beginYear; $year <= $lastYear; $year++) {
            array_push($list, $year);
        }
        $arrayYears = implode(',', $list);
        $filtre = $filtre . $column . " = ? AND iyear IN (" . $arrayYears . ")"; //partea de dupa where care reprezinta efectiv filtrele
        //the construction of the string filter
        if (isset($dataToProcess['filtruSuicid']))
            $filtre = $filtre . " AND suicide=" . $dataToProcess['filtruSuicid'];
        if (isset($dataToProcess['filtruExtend']))
            $filtre = $filtre . " AND extended=" . $dataToProcess['filtruExtend'];
        if (isset($dataToProcess['filtruSucces']))
            $filtre = $filtre . " AND success=" . $dataToProcess['filtruSucces'];
        if (isset($dataToProcess['filtruTipAtac']))
            $filtre = $filtre . " AND attacktype1=" . $dataToProcess['filtruTipAtac'];
        $stmt = $dbconn->prepare("SELECT " . $selectColumnForData . " FROM terro_events WHERE " . $filtre);

        if ($stmt === false) {
            die("Something went wrong");
        }

        $nume=array(4);
        for($i=0;$i<count($columnSearchedValues);$i++)
        switch($columnSearchedValues[$i])
        {
            case "sum(nkill)":{
                $nume[$i]="Omorati";
                break;
            }
            case "sum(nwound)":{
                $nume[$i]="Raniti";
                break;
            }
            case "count(*)":{
                $nume[$i]="Total";
                break;
            }
        }

        $stmt->bind_param("s", $dataToProcess['locatie1']);
        $stmt->execute();
        if (count($columnSearchedValues) == 2) {
            $stmt->bind_result($v1, $v2);
            $stmt->fetch();
            $resultsSet[$nume[0]] = $v1;
            $resultsSet[$nume[1]] = $v2;
        } else {
            $stmt->bind_result($v1, $v2, $v3);
            $stmt->fetch();
            $resultsSet[$nume[0]] = $v1;
            $resultsSet[$nume[1]] = $v2;
            $resultsSet[$nume[2]] = $v3;
        }

        $data = [];
        foreach ($resultsSet as $key => $value)
            array_push($data, ["name" => $key, "data" => $value]);
        return ["nameLocatie" => $dataToProcess['locatie1'], "dataColoane" => $data];
    }
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
        $filtre = $filtre . $column . " =? AND iyear IN (" . $arrayYears . ")"; //partea de dupa where care reprezinta efectiv filtrele
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
