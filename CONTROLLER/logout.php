<?php 
    session_start();
    session_unset();               
    header("Location: ../web/account.php");
?>