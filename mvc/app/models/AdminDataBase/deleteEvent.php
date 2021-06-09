<?php
require_once "../../Utilitati/Conexiune.php";
    class deleteEvent{
        public function deleteFromDB($id){
            //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
            $dbconn=getConnection();
            if($dbconn->connect_error) {
                exit('Could not connect');
              }
            $sql = "DELETE FROM terro_events WHERE eventid = " . $id;
            if ($dbconn->query($sql) === TRUE) {
                echo "Evenimentul cu id-ul " . $id . " a fost sters cu succes!<br>";
            } 
            else {
                echo "Error deleting record: " . $dbconn->error;
            }
              
              $dbconn->close();
        }
    }
?>