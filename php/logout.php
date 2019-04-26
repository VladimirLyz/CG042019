<?php
    include_once('verdicts.php');
    session_start();
    if(!isset($_SESSION['id'])){
        fail('Logout has been already completed');
    }
    session_destroy();
    ok();
    exit;
?>