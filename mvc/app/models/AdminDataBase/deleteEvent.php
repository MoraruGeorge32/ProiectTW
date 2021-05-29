<?php
    class deleteEvent{
        public function deleteFromDB($id){
            $dbconn = new mysqli("localhost", "Robert", "robert", "globalterrorismdb");
            if($dbconn->connect_error) {
                exit('Could not connect');
              }
            $sql = "DELETE FROM globalterrorismdb_0718dist WHERE eventid = " . $id;
            if ($dbconn->query($sql) === TRUE) {
                echo "Record deleted successfully<br>";
            } 
            else {
                echo "Error deleting record: " . $dbconn->error;
            }
              
              $dbconn->close();
        }
    }
?>