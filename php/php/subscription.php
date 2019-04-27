<?php

class Subscription
{
    public $order_id;
    public $courier_id;

    static function ChooseSubscription($_order_id, $_courier_id)
    {
        include_once('order.php');
        $order = Order::GetById($_order_id);
        if (session_status() == PHP_SESSION_NONE) 
        {
            session_start();
        }
        if (!isset($_SESSION['id']))
        {
            fail('Bad login.');
        }
        if ($_SESSION['id'] != $order->client->id)
        {
            fail('Bad login.');
        }
        Order::UpdateOrderWithId($_order_id, Order::CreateNew($order->client->id, $order->text, $order->cost, $_courier_id));

    }

    static function GetSubscriptions($_order_id)
    {
        include_once('verdicts.php');
        include_once('database.php');
        $database = new Database();
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `subscriptions` WHERE `order_id`=$_order_id";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $subscriptions_id = array();
        while ($row = $result->fetch_assoc()) {
            array_push($subscriptions_id, $row['courier_id']);
        }
        $database->closeConnection();
        return $subscriptions_id;
    }    

    static function AddSubscription($order_id)
    {
        if (session_status() == PHP_SESSION_NONE) 
        {
            session_start();
        }
        if (!isset($_SESSION['id']))
        {
            fail('Bad login.');
        }
        $database = new Database();
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `orders` WHERE `order_id`=$_order_id";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count!=1){
            fail('Can not find order in database.');
        }
        $courier_id = $_SESSION["id"];
        $sql = "INSERT INTO `subscriptions`(`order_id`, `courier_id`) VALUES (`$_order_id`,`$courier_id`)";
        if($conn->quiry(sql)==false){
            fail('Can not add subscribtion in database.');
        }
    }
}