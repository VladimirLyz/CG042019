<?php
if (session_status() == PHP_SESSION_NONE) 
{
    session_start();
}
include_once('verdicts.php');
if(!isset($_POST['courier_id'])){
    fail("Incorrect post request.");
}

include_once('user.php');
$info = Courier::GetInfo($_POST['courier_id']);
ok_message($info);
?>