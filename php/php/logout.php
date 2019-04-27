<?php
    include_once('verdicts.php');
    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    if(!isset($_SESSION['id'])){
        fail('Logout has been already completed');
    }
    session_destroy();
    ok();
    exit;
?>