<?php
    session_destroy();
    $GLOBALS['connection']=null;
    header("Location: ../homePage/home.html",TRUE,303);
