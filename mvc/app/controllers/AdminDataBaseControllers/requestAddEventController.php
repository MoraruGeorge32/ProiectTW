<?php
include_once "../../models/AdminDataBase/addEvent.php";
include_once "../../core/Controller.php";
class requestAddEventDataBase extends Controller
{
    public static function index(){
        addEvent::insertData($_GET);
    }
}
requestAddEventDataBase::index();