<?php
class mapModel
{
    public static function mapEvent($data)
    {
        $dbconn = getConnection();
        $resultsToSend = [];
        $currentRow = array();
        $selectResults = array();
        $selectResults = $dbconn->query($data);
        if ($dbconn === false) {
            die("Murim cu gratie");
            echo $dbconn->error;
        }
        if ($selectResults !== false)
            while ($row = $selectResults->fetch_assoc()) {
                foreach ($row as $key => $value) {
                    $currentRow[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                    
                }
                array_push($resultsToSend, $currentRow);
            }
        $dbconn->close();
        return $resultsToSend;
    }
}
