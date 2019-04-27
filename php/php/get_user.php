<?php
    class UserPage {
        public function getUserPage($username) {
            include_once("database.php");
            $database = new Database();
            $conn = $database->getConnection();
            if (session_status() == PHP_SESSION_NONE) 
            {
                session_start();
            }
            /*if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
            }*/
            $sql = "SELECT * FROM `posts` WHERE `user`='$username' ORDER BY `date` DESC, `time` DESC";
           
            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $i = 1;
            while ($row = $result->fetch_assoc()) {
                echo '<div class="container" style="margin-top: 30px;"><div class="card"><div class="card-header">';
                echo $row['label'];
                echo '</div><div class="card-body"><small class="card-title">';
                echo $row['date'] . " " . $row['time'];
                echo '</small><p class="card-text">';
                echo $row['content'];
                echo '</p><a href="/user/' . strtolower($row['user']) . '" class="">';
                echo $row['user'] . "</a></div></div></div>";
                $i++;
                if ($i > 20) {
                    break;
                }
            }
        }
    }
?>