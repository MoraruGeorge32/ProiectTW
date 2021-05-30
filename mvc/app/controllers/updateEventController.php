<?php
include_once "../../models/AdminDataBase/updateEvent.php";
include_once "../../core/Controller.php";
class requestUpdateEventDataBase extends Controller
{
    public static function index(){
        $dataEvent =  json_decode(file_get_contents('php://input'), true);
        //echo json_encode($dataEvent);
        $message=addEvent::insertData($dataEvent);
        $response=array("message"=>$message);
        echo json_encode($response);
    }
}
requestAddEventDataBase::index();