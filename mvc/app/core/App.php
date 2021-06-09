<?php
class App
{
    //aplicatia in sine
    //functioneaza ca un router
    protected $controller = 'homePage'; //default controller

    protected $method = 'index'; //default method

    protected $param = []; //parameters from the URI

    public function __construct()
    {
        $url = $this->parseURL();
        //print_r($url);
        if (isset($url[0])) {
            if (file_exists('../app/controllers/' . $url[0] . '.php')) {
                $this->controller = $url[0];
                unset($url[0]);
            }
        }
        require_once '../app/controllers/' . $this->controller . '.php';
        //echo $this->controller . '<br>';
        $this->controller = new $this->controller;
        if (isset($url[1])) 
        {
            if(method_exists($this->controller,$url[1]))//verificat daca in classname dat exista metoda cu numele $url[1]
            {
                $this->method=$url[1];
                unset($url[1]);//folosit pentru a scoate elementele din array. sa ramanem in url doar cu parametrii dati
            }
        }
        $this->param=$url?array_values($url):[];//rebase adica reindexarea elementelor ce o ramas in $url
        call_user_func_array([$this->controller ,$this->method],$this->param);//apelez functia din controller cu parametrii dati
    }

    public function parseURL()
    {
        if (isset($_GET['url'])) {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL)); //obtinem vectorul de parametrii/locatia unui controler cred
            //primele 2 valori:prima ii controller a doua metoda restul sunt parametri
        }
    }
}
