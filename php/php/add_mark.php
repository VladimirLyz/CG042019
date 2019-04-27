<?php

    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    if(!isset($_SESSION['order_id'])||!isset($_POST['user_id'])||!isset($_POST['mark'])){
        fail("Incorrect post request.");
    }
    include_once('mark.php');
    include_once('user.php');
    include_once('order.php');
    $order = Order::GetById($_SESSION['order_id']);
    if($order->client_id==$_POST['user_id']) {
        Mark($_POST['mark'],Client($_POST['user_id']));
    }
    else {
        Mark($_POST['mark'],Courier($_POST['user_id']));
    }
    ok();

?>