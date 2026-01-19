<?php
    session_start();
    session_destroy();
    
    setcookie('status', 'true', time() - 10, '/');
    //print_r($_SESSION);
    
    header('location: ../view/php/homePage.php');
?>
