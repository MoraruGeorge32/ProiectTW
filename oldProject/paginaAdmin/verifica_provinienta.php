<?php
session_start();
function console_log($data)//functie utila ca sa putem afisa la consola mai simplu
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}
if (!(isset($_SESSION['user'])&&isset($_SESSION['password']))) {
    header("Location: ../homePage/home.html",TRUE,403);
    exit();
}