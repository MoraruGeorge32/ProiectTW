<?php
class requestEditPage extends Controller{
    public function index(){
            $idEvent=$_GET['idEvent'];
            $model=$this->model("getEditPage");
            $linkEdit=$model->createLink($idEvent);
            echo $linkEdit;
    }
}