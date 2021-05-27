<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['password']);
session_destroy();
$GLOBALS['connection'] = null;
header("Location: ../homePage/home.html", TRUE, 303);
