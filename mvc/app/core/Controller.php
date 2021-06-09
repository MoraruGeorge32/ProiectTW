<?php

class Controller{
    protected function model($model_type)
    {
        require_once '../app/models/'.$model_type.'.php';
        require_once '../app/Utilitati/Conexiune.php';
        return new $model_type();
    }

    public function view($view_path){
        require_once '../app/views/'.$view_path.'.php';

    }
}