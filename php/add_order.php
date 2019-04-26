<?php
    include_once "database.php";
    session_start();
    echo $_SESSION['username'];
    if (isset($_SESSION['username']) and isset($_POST["label"]) and isset($_POST["content"])) {
        echo "After if";
        $database = new Database();
        $date = date('Y-m-d');
        $time = date('H:i:s');
        $conn = $database->getConnection();
        $user = $_SESSION["username"];
        $content =  $_POST["content"];
        $label = $_POST["label"];
        $sql = "INSERT INTO `posts` (`user`, `date`, `time`, `content`, `label`)
    VALUES ('$user', '$date', '$time', '$content', '$label')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        echo "<br>" . $user . "<br>" . $date . " " . $time . "<br>" . $content;
        $database->closeConnection();
    }
    header('Location: ../posts');
    
?>