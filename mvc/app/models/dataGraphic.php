<?php

class DataGraphic
{
    public function getDataSingleLocationMultipleColumns($dataToProcess, $column, $columnSearchedValues)
    {
        //interogare test: 
        //select sum(nkill),count(*),sum(nwound),iyear from terro_events WHERE country_txt='Pakistan' AND iyear>=1970 and iyear<=1990 GROUP by iyear
        $selectColumnForData="";
        foreach($columnSearchedValues as $columnTable)
            $selectColumnForData=$selectColumnForData.$columnTable.",";
        $selectColumnForData=substr($selectColumnForData,0,-1);//eliminare ultima virgula

        $dbconn = getConnection();
        $rez = array();
        $stmt = '';
        $beginYear = $dataToProcess['beginYear'];
        $lastYear = $dataToProcess['lastYear'];
        $resultsSet=[];
        $list=[];//pt ani
        $filtre = "";
        for ($year = $beginYear; $year <= $lastYear; $year++) {
            array_push($list, $year);
        }
        $arrayYears = implode(',', $list);
        $filtre = $filtre . $column . " = ? AND iyear >=".$beginYear." AND iyear <=".$lastYear;//partea de dupa where care reprezinta efectiv filtrele
        //the construction of the string filter
        if (isset($dataToProcess['filtruSuicid']))
            $filtre = $filtre . " AND suicide=" . $dataToProcess['filtruSuicid'];
        if (isset($dataToProcess['filtruExtend']))
            $filtre = $filtre . " AND extended=" . $dataToProcess['filtruExtend'];
        if (isset($dataToProcess['filtruSucces']))
            $filtre = $filtre . " AND success=" . $dataToProcess['filtruSucces'];
        if (isset($dataToProcess['filtruTipAtac']))
            $filtre = $filtre . " AND attacktype1=" . $dataToProcess['filtruTipAtac'];
        $stmt=$dbconn->prepare("SELECT ".$selectColumnForData.",iyear FROM terro_events WHERE ".$filtre." GROUP BY iyear ORDER BY iyear");
        
        $stmt->bind_param("s",$dataToProcess['locatie1']);
        $stmt->execute();
        $contor=$beginYear;
        if(count($columnSearchedValues)==2)
        {
            $resultsSet[$columnSearchedValues[0]]=[];
            $resultsSet[$columnSearchedValues[1]]=[];
            $stmt->bind_result($v1, $v2,$year);
            while($stmt->fetch())
            {
                for (; $contor < $year && $contor <= $lastYear; $contor++) {
                    array_push($resultsSet[$columnSearchedValues[0]],0);
                    array_push($resultsSet[$columnSearchedValues[1]],0);
                }

                $contor = $year + 1;
                array_push($resultsSet[$columnSearchedValues[0]],$v1);
                array_push($resultsSet[$columnSearchedValues[1]],$v2);
            }
        }
        else
        {
            $resultsSet[$columnSearchedValues[0]]=[];
            $resultsSet[$columnSearchedValues[1]]=[];
            $resultsSet[$columnSearchedValues[2]]=[];
            $stmt->bind_result($v1,$v2,$v3,$year); 
            while($stmt->fetch())
            {
                for (; $contor < $year && $contor <= $lastYear; $contor++) {
                    array_push($resultsSet[$columnSearchedValues[0]],0);
                    array_push($resultsSet[$columnSearchedValues[1]],0);
                    array_push($resultsSet[$columnSearchedValues[2]],0);
                }
                $contor = $year + 1;
                array_push($resultsSet[$columnSearchedValues[0]],$v1);
                array_push($resultsSet[$columnSearchedValues[1]],$v2);
                array_push($resultsSet[$columnSearchedValues[2]],$v3);
            }
        }
        $data=[];
        foreach($resultsSet as $key=>$value)
            array_push($data,["name"=>$key,"data"=>$value]);
            //...mvc/public/statisticiController?numarTari=1&locatie1=Mexico&numarRaniti=numarRaniti&numarDecese=numarDecese&numarRedari=2&tipRedare=grafic2D&beginYear=1970&lastYear=1990
        return ["nameLocatie"=>$dataToProcess['locatie1'],"dataColoane"=>$data];

    }
    public function getData($requestData, $valuesCount, $searchedColumn, $columnSearchedValues)
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
                    $stmt = $dbconn->prepare("SELECT sum(nkill),iyear FROM terro_events where " . $filtre . " GROUP BY iyear ORDER BY iyear");
                    break;
                }
            case 'numarAtacuri': {
                    $stmt = $dbconn->prepare("SELECT count(*),iyear FROM terro_events where " . $filtre . " GROUP BY iyear ORDER BY iyear");
                    break;
                }
            case 'numarRaniti': {
                    $stmt = $dbconn->prepare("SELECT sum(nwound),iyear FROM terro_events where " . $filtre . " GROUP BY iyear ORDER BY iyear");
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
