<?php
include_once('order.php');
$orders = Order::GetAllOrdersId();
include_once('verdicts.php');
ok_message(array('message' => $orders));