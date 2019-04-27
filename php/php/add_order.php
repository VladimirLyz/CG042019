<?php
    
    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    if (isset($_SESSION['id']) and isset($_POST["text"]) and isset($_POST["cost"])) {
        include_once("database.php");
        $database = new Database();
        $conn = $database->getConnection();
        $id = $_SESSION["id"];
        $text =  $_POST["text"];
        $cost = $_POST["cost"];
        include_once('order.php');
        $order = new Order($id, $text, $cost);
        Order::Publish($order);
    }
    else
    {
        fail('Invalid order');
    }
    
?>