<?php

require_once "../Utilitati/Conexiune.php";
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
        $dbconn=getConnection();
        $stmt = $dbconn->prepare("select ".$column." from terro_events where country_txt=? and iyear = ?");
        /*
        alta idee
        se selectez coloana cu numarul si anul pentru iyear >=2017-interval */
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
                $stmt->bind_param("sd", $currentCountry, $year); // completezi query-ul
                $stmt->execute();// executi query-ul
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