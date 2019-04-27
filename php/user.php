<?php

include_once('verdicts.php');
include_once("database.php");

abstract class User{
    public $rating;
    public $id;
    public $username;
    
    abstract public function __construct($_id);
}

class Client extends User{
    public function __construct($_id){
        $database = new Database(); 
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `users` WHERE `id`='$_id'";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count!=1){
            fail("Can not find user in database.");
        }
        $info = mysqli_fetch_assoc($result);
        $this->rating = $info["client_rate"];
        $this->username = $info["username"];
        $this->id = $_id;
        $database->closeConnection();
    }
}
class Courier extends User{
    public function __construct($_id){
        $database = new Database(); 
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `users` WHERE `id`='$_id'";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count!=1){
            fail("Can not find user in database.");
        }
        $info = mysqli_fetch_assoc($result);
        $this->rating = $info["deliv_rate"];
        $this->username = $info["username"];
        $this->id = $_id;
        $database->closeConnection();
    }
}

?>