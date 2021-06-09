<?php
// include_once "../../models/AdminDataBase/addEvent.php";
// include_once "../../core/Controller.php";
class requestAddEventController extends Controller
{
    public function index(){
        $dataEvent =  json_decode(file_get_contents('php://input'), true);
        $model=$this->model("addEvent");
        $message=$model->insertData($dataEvent);
        $response=array("message"=>$message);
        echo json_encode($response);
    }
}
//requestAddEventDataBase::index();