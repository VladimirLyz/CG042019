<?php

function Pay($order_id){
    include_once('order.php');
    $order = Order::GetById($order_id);
    $order->completed = 1;
    Order::UpdateOrderWithId($order_id, $order);
}

?>