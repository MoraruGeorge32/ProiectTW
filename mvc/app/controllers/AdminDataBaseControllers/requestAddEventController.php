<?php
include_once "../../models/AdminDataBase/addEvent.php";
include_once "../../core/Controller.php";
class requestAddEventDataBase extends Controller
{
    public static function index(){
        $columns=array();
        $datas=array();
        foreach($_GET as $data)
            array_push($datas,$data);
        foreach($_GET as $key => $value)
            array_push($columns,$key);
        addEvent::insertData($columns,$datas);
    }
}
requestAddEventDataBase::index();