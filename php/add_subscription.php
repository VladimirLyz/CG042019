<?php

    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    if(!isset($_SESSION['order_id'])||!isset($_POST['courier_id'])){
        fail("Incorrect post request.");
    }
    include_once('subscription.php');
    Subscription::AddSubscription($_SESSION['order_id']);
    include_once('verdicts.php');
    ok();
?>