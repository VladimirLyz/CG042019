<?php

    include_once ('verdicts.php');

    if (session_status() == PHP_SESSION_NONE) 
    {
        session_start();
    }
    
    if(isset($_SESSION["id"]))
    {
        fail("Autorization has been already completed.");
    }
    include_once "database.php";
    if (isset($_POST["email"]) and isset($_POST["password"])) {
        $database = new Database();
        $conn = $database->getConnection();
        $email = $_POST["email"];
        $imail = strtolower($email);
        $password =  $_POST["password"];
        $sql = "SELECT * FROM `users` WHERE `email`='$email' and `password`='$password'";
        $result = mysqli_query($conn, $sql) or fail(mysqli_error($conn));
        $count = mysqli_num_rows($result);
        if ($count == 1) {
            ok();
            $row = $result->fetch_assoc();
            $_SESSION['id'] = $row['id'];
        } else {
            fail("Can not find user in database.");
        }
        $database->closeConnection();
    }
    else {
        fail("Incorrect login post.");
    }
    
?>