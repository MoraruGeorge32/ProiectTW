<?php
session_start();
require_once 'Conexiune.php';
function console_log($data) //functie utila ca sa putem afisa la consola mai simplu
{
    echo '<script>';
    echo 'console.log(' . json_encode($data) . ')';
    echo '</script>';
}
if (!(isset($_SESSION['user']) && isset($_SESSION['password']))) {
    header("Location: ../homePage/home.html", TRUE, 403);
    exit();
} else if (isset($_SESSION['user']) && isset($_SESSION['password'])) {
    $conn = getConnection();
    $admin_user=$_SESSION['user'];
    $admin_password=$_SESSION['password'];
    $query=sprintf("SELECT nume FROM admins WHERE nume='%s' AND parola='%s'"
    ,$conn->real_escape_string($admin_user),$conn->real_escape_string($admin_password));
    $rez =$conn->query($query);
    $row = $rez->fetch_assoc();
    if (!isset($row['nume'])) {
        // $_SESSION['user'] = $admin_user;
        // $_SESSION['password'] = $admin_password;
        // header("Location: ../paginaAdmin/index.php", TRUE, 303);
        header("Location: ./reject_connection.php", TRUE, 303);
    } 
}
