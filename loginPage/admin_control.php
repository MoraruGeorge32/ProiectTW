<?php
session_start();
if (isset($_POST['Username']) && isset($_POST['Password'])) {
    $admin_user = $_POST['Username'];
    $admin_password = $_POST['Password'];
    $dbServer = 'localhost';
    $dbName = 'terrorismdatabase';
    @$connection = new mysqli($dbServer, $admin_user, $admin_password, $dbName);
    if ($connection->connect_errno==0) {
        $_SESSION['user'] = $admin_user;
        $_SESSION['password'] = $admin_password;
        header("Location: ../paginaAdmin/index.php", TRUE, 303); {
        }
    } else {
        header("Location: ./reject_connection.php",TRUE,303);
    }
}
