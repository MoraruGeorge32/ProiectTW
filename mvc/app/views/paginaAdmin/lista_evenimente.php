<?php
    class ListaEvenimente(){
        public function __construct(){
            $this->parse();
        }
        public function parse(){
            if(isset($_GET['start']&&)&&isset($_GET['counter'])){
                echo "<script>console.log("."bravo!!".")</script>";
            }
        }
    } 
    //new ListaEvenimente();
    echo $_GET['start'].$_GET['counter'];
?>