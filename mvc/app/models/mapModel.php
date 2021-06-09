<?php
include_once "../../Utilitati/Conexiune.php";

class mapModel
{
    public static function mapEvent($data)
    {
        $dbconn = getConnection();
        $resultsToSend = [];
        $currentRow = array();
        $selectResults = array();
        $selectResults = $dbconn->query($data);
        if ($dbconn === false)
            die("Murim cu gratie");
        if ($selectResults !== false)
            while ($row = $selectResults->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $currentRow[$key] = $value;
                }
                array_push($resultsToSend, $currentRow);
            }
        $dbconn->close();
        return $resultsToSend;
    }
}
