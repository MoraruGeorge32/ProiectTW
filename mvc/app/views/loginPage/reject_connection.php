<?php
if (isset($_GET['Redirect'])) {
    header("Location: ../../../public/homePage", TRUE, 303);
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <p>Cont de administrator inexistent</p>
    <p>Redirectare către pagina home.</p>
    <form method="GET">
        <button type=submit name="Redirect" value="true">Revin-o la pagina home</button>
    </form>
</body>

</html>