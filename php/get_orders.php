<?php
include_once('order.php');
$orders = Order::GetAllOrdersId();
echo json_encode($orders);