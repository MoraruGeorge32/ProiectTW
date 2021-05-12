<?php

class Controller{
    protected function model($model_type='sadsa')
    {
        //echo $model_type ;
        require_once '../app/models/'.$model_type.'.php';
        /**
         * TODO check daca exista
         */
        return new $model_type();
    }

    public function view($view_path,$data=[]){
        //echo $view_path;
        //print_r($data);
        require_once '../app/views/'.$view_path.'.php';

    }
}