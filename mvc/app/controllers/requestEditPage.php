<?php
require_once "../core/Controller.php";
include_once "../models/AdminDataBase/getEditPage.php";
class ControllerEditPage extends Controller{
    public function index(){
            $idEvent=$_GET['idEvent'];
            $linkEdit=getEditPage::createLink($idEvent);
            echo $linkEdit;
    }
}
(new ControllerEditPage())->index();