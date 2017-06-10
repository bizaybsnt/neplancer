<?php
    session_start();
    include_once("Functions.php");
    
    $funObj = new Functions;
    $funObj->connect_db();
    
?>