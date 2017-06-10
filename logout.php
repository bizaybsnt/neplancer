<?php
    include_once("includes/application_top.php");
    session_destroy();
    unset($_SESSION);
    
    $url = "index.php";
    $funObj->redirect($url);
    
?>