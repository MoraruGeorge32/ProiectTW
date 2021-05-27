<?php
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
        $mysqlConnect = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
        $stmt = $mysqlConnect->prepare("select ".$column." from terro_events where country_txt=? and iyear = ?");
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
                $stmt->bind_param("sd", $currentCountry, $year);
                $stmt->execute();
                $stmt->bind_result($resultCount);
                while ($stmt->fetch()) {
                    $countvalues = $countvalues + $resultCount;
                }
                array_push($valuesCountry, $countvalues);
            }
            array_push($sendData, array("name" => $currentCountry, "data" => $valuesCountry));
        }

        $mysqlConnect->close();

        return $sendData;
    }
}