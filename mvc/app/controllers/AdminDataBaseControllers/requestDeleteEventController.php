<?php
include_once "../../core/Controller.php";
include_once "../../models/AdminDataBase/deleteEvent.php";
class requestDeleteEvent extends Controller{
    public function index(){
        for($i=1; $i<=$_POST['chooseCounter']; $i++){
            if( isset($_POST['c_' . ($i-1)]) ){
                $delete = new deleteEvent();
                $delete->deleteFromDB( $_POST['c_' . ($i-1)] );
            }
        }
    }
}

$id = new requestDeleteEvent();
$id->index();
?>