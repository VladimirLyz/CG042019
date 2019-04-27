<?php

include_once('verdicts.php');
include_once("database.php");

abstract class User{
    public $rating;
    public $id;
    public $username;
    
    abstract public function __construct($_id);
    abstract public function UpdateRating($new_mark){
        if(!isset($_SESSION['id'])){
            fail('Bad login.');
        }
    }
    abstract public function GetInfo($id){
        if(!isset($_SESSION['id'])){
            fail('Bad login.');
        }
    }
    static public function UpdateUser($info){
        $database = new Database(); 
        $conn = $database->getConnection();
        $id = $info['id'];
        $username = $info['username'];
        $email = $info['email'];
        $password = $info['password'];
        $client_rate = $info['client_rate'];
        $deliv_rate = $info['deliv_rate'];
        $client_voted = $info['client_voted'];
        $deliv_voted = $info['deliv_voted'];
        $sql = "UPDATE `users` SET `id`=`$id`,`username`=`$username`,`email`=`$email`,
        `password`=`$password`,`client_rate`=`$client_rate`,`deliv_rate`=`$deliv_rate`,
        `client_voted`=`$client_voted`,`deliv_voted`=`$deliv_voted` WHERE `id`=$id";
        if($conn->quiry($sql)==FALSE){
            fail('Can not update user information in database');
        }
        $database->closeConnection();
    }
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
    public function UpdateRating($new_mark){
        parent::UpdateRating($new_mark);
        $database = new Database(); 
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `users` WHERE `id`='$_id'";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count!=1){
            fail("Can not find user in database.");
        }
        $info = mysqli_fetch_assoc($result);
        $database->closeConnection();
        $rating = $info['client_rate']*$info['client_voted'];
        $info['client_voted']=$info['client_voted']+1;
        $info['client_rate']=($rating+$new_mark)/($info['client_voted']);
        parent::UpdateUser($info);
    }
    public function GetInfo($id)
    {
        $this = Client($id);
        parent::GetInfo($id);
        return array('username'=>$this->username, 'rating'=>$this->rating);
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
    public function UpdateRating($new_mark){
        parent::UpdateRating($new_mark);
        $database = new Database(); 
        $conn = $database->getConnection();
        $sql = "SELECT * FROM `users` WHERE `id`='$_id'";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if($count!=1){
            fail("Can not find user in database.");
        }
        $info = mysqli_fetch_assoc($result);
        $database->closeConnection();
        $rating = $info['deliv_rate']*$info['deliv_voted'];
        $info['deliv_voted']=$info['client_voted']+1;
        $info['deliv_rate']=($rating+$new_mark)/($info['deliv_voted']);
        parent::UpdateUser($info);
    }
    public function GetInfo($id)
    {
        $this = Courier($id);
        parent::GetInfo($id);
        return array('username'=>$this->username, 'rating'=>$this->rating);
    }
}

?>