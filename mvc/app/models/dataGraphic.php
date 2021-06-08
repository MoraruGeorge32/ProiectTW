<?php

require_once "../Utilitati/Conexiune.php";
class DataGraphic
{
    public static function getData($requestData, $valuesCount, $searchedColumn, $columnSearchedValues)
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
        $filtre = "" . $searchedColumn . "=? and iyear >=" . $beginYear . " AND iyear<=" . $lastYear;
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
                    $stmt = $dbconn->prepare("SELECT sum(nkill),iyear FROM terro_events where " . $filtre . " GROUP BY iyear");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("SELECT count(*),iyear FROM terro_events where " . $filtre . " GROUP BY iyear");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("SELECT sum(nwound),iyear FROM terro_events where " . $filtre . " GROUP BY iyear");
                    break;
                }
        }

        $sendData = array();

        for ($contor = 1; $contor <= $numarlocatii; $contor++) {
            //per country   
            $currentCountry = $requestData["locatie" . $contor];
            $year = 1970;
            $currentYear = $beginYear;
            $valuesCountry = array();
            $countvalues = 0;
            $stmt->bind_param("s", $currentCountry);
            $stmt->execute();
            $stmt->bind_result($countvalues, $year);
            while ($stmt->fetch()) {
                for (; $currentYear < $year && $currentYear <= $lastYear; $currentYear++) {
                    array_push($valuesCountry, 0); //filling with 0 for the year that isn't any recorded data
                }
                $currentYear = $year + 1;
                array_push($valuesCountry, $countvalues);
            }
            array_push($sendData, array("name" => $currentCountry, "data" => $valuesCountry));
        }

        $dbconn->close();

        return $sendData;
    }
}
