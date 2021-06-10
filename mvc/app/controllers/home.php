<?php
class Home extends Controller
{
    public function index()
    {
        //default method
        echo '---home/index----';
    }
    public function test()
    {
        echo '<br>++++sunt un test+++<br>';
    }
    public function indexWithParam( $var = '',$name='default')
    {
       $user=$this->model($var);
       $user->setName($name);
       echo $user->getName()."<br>";
       var_dump($user);
       $this->view('home/index',['name'=>$user->getName()]);
    }
}
