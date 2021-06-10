<?php
class requestDeleteEventController extends Controller{
    public function index(){
        for($i=1; $i<=$_POST['chooseCounter']; $i++){
            if( isset($_POST['c_' . ($i-1)]) ){
                $delete =$this->model("deleteEvent");
                $delete->deleteFromDB( $_POST['c_' . ($i-1)] );
            }
        }
    }
}
