<?php
// require_once "../../Utilitati/Conexiune.php";
    class deleteEvent{
        public function deleteFromDB($id){
            //$dbconn = new mysqli("localhost", "Robert", "robert", "terrorismdatabase");
            $dbconn=getConnection();
            if($dbconn->connect_error) {
                exit('Could not connect');
              }
            $sql = "DELETE FROM terro_events WHERE eventid = ?";
            $stmt = $dbconn->prepare($sql);
            $stmt->bind_param("i", $id);
            if ($stmt->execute() === TRUE) {
                echo "Evenimentul cu id-ul " . $id . " a fost sters cu succes!<br>";
            } 
            else {
                echo "Error deleting record: " . $dbconn->error;
            }
              
              $dbconn->close();
        }
    }
?>