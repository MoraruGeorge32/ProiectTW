<?php
require_once "../../Utilitati/Conexiune.php";
// @$dbconn = new mysqli (
// 	'localhost', // locatia serverului (aici, masina locala)
// 	'Robert',       // numele de cont
//     'robert',		// parola (atentie, in clar!)
// 	'terrorismdatabase'   // baza de date
// 	);
@$dbconn=getConnection();
if (mysqli_connect_errno()) {
    echo mysqli_connect_errno();
    die('Conexiunea a esuat...');
}
if (isset($_POST['Username']) && isset($_POST['Password'])) {
    $admin_user = $_POST['Username'];
    $admin_password = $_POST['Password'];
    $stmt = $dbconn->prepare('select nume from admins where nume= ?  AND parola= ? ');
    $stmt->bind_param("ss", $admin_user, $admin_password);
    $stmt->execute();
    $result= $stmt->get_result();
    $row = $result->fetch_assoc();
    if (isset($row['nume'])) {
        $_SESSION['user'] = $admin_user;
        $_SESSION['password']=$admin_password;
        header("Location: ../paginaAdmin/index.php", TRUE, 303);
    } else {
        header("Location: ./reject_connection.php", TRUE, 303);
    }
}
