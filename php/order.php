<?php

class Order
{
    public $id;
    public $client;
    public $text;
    public $cost;
    public $completed;
    public $courier = null;

    protected function __construct()
    {
        
    }



    static function CreateNew($client_id, $text, $cost, $courier = null, $completed = 0)
    {
        include_once('verdicts.php');
        $res = new Order();
        if (!is_scalar($client_id))
        {
            fail('Invalid client id.');
        }
        if (!is_string($text))
        {
            fail('Invalid order content.');
        }
        if (!is_scalar($cost))
        {
            fail('Invalid cost.');
        }
        include_once('user.php');
        $res->client = new Client($client_id);
        $res->text = $text;
        $res->cost = $cost;
        $res->courier = $courier;
        $res->completed = $completed;
        return $res;
    }

    static function GetAllOrdersId()
    {
        include_once('verdicts.php');
        include_once('database.php');
        $database = new Database();
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `orders` WHERE `courier_id`=NULL AND `completed`=0";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $orders_id = array();
        while ($row = $result->fetch_assoc()) {
            array_push($orders_id, $row['id']);
        }
        $database->closeConnection();
        return $orders_id;
    }

    static function Publish($order)
    {
        include_once('verdicts.php');
        if (!is_object($order) or !get_class($order) == 'Order')
        {
            fail('Invalid order');
        }
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
        include_once('database.php');
        $database = new Database(); 
        $conn = $database->getConnection();
        var_dump($order->client->id);
        $sql = 'INSERT INTO `orders` (`text`, `client_id`, `cost`)
    VALUES ("' . $order->text . '", ' . $order->client->id . ', ' . $order->cost . ')';
        if ($conn->query($sql) === FALSE)
        {
            fail("Can't add new order");
        }
        $sql = 'SELECT * FROM `orders` WHERE `id` = LAST_INSERT_ID()';
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count<1) {
            fail("Can not find user in database.");
        }
        else {
           ok();
            $info = mysqli_fetch_assoc($result);
            $_SESSION['order_id'] = $info['id'];
        }
        $database->closeConnection();
    }

   

    static function GetById($_id)
    {
        include_once('verdicts.php');
        include_once('database.php');
        $database = new Database(); 
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `orders` WHERE `id`='$_id'";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count!=1){
            fail("Can not find order in database.");
        }
        $info = mysqli_fetch_assoc($result);
        $res = new Order();
        include_once('user.php');
        $res->client = new Client($info['client_id']);
        $res->text = $info["text"];
        $res->cost = $info["cost"];
        $res->completed = $info["completed"];
        $res->id = $_id;
        if ($info['courier_id'] != null)
        {
            $res->courier = new Courier($info['courier_id']); 
        }
        $database->closeConnection();
        return $res;
    }

    static function UpdateOrderWithId($order_id, $new_order)
    {
        include_once('verdicts.php');
        $order = Order::GetById($order_id);
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
        include_once('database.php');
        $database = new Database();
        $sql = "UPDATE `orders` SET `id`=$new_order->id,`text`=$new_order->text,`client_id`=" 
            . $new_order->client->id . ",`cost`=$new_order->cost,`completed`=$new_order->completed,
            `courier_id`=$new_order->courier_id WHERE `id`=$order_id";
        $conn = $database->getConnection();
        if($conn->query($sql)==FALSE){
            fail("Can not update order info.");
        }
    }
}