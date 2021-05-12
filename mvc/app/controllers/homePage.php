<?php
class homePage extends Controller{
    public function index(){
        $this->view('/homePage/index',[]);
    }
}