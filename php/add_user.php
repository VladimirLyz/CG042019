
<?php

    include_once ('verdicts.php');

    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    
    //include_once ('post.php');
    if (isset($_POST["username"]) and isset($_POST["email"]) and isset($_POST["password"]))
    {
        include_once("database.php");
        $database = new Database(); 
        $conn = $database->getConnection();
        $user = $_POST["username"];
        $email = $_POST["email"];
        $password =  $_POST["password"];
        $loweremail = strtolower($email);
        $sql = "SELECT * FROM `users` WHERE `email`='$loweremail'";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            fail("Account with this email already exists.");
        }
        $sql = "INSERT INTO `users` (`username`, `email`, `password`)
    VALUES ('$user', '$loweremail', '$password')";
        if ($conn->query($sql) === TRUE) {
            $req = "SELECT * FROM `users` WHERE `email`='$loweremail'";
            $result = mysqli_query($conn, $req) or fail(mysqli_error($conn));
            $count = mysqli_num_rows($result);
            if($count<1) {
                fail("Can not find user in database.");
            }
            else {
                ok();
                $info = mysqli_fetch_assoc($result);
                $_SESSION['id'] = $info['id'];
            }

        } else {
            fail("Error: " . $sql . " " . $conn->error);
        }
        $database->closeConnection();
    }
    else{
        fail("Incorrect post request.");
    }
    
?>