<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
  <title>All posts</title>
</head>
<body class="bg-light">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

    <?php
                session_start();
                if (isset($_SESSION['username'])) {
                        $username = $_SESSION['username'];
                }
    ?>

    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="/posts"><h1><span class="badge badge-pill badge-dark">neBlog</span></h1></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav mr-auto">
                                    <li class="nav-item">
                                    <?php 
                                        if (isset($_SESSION['username'])) {
                                            echo "<a class='nav-link' href='/user/" . strtolower($username) . "'>" . $username . "</a>";
                                        } else {
                                            echo "<a class='nav-link' href='/register'>Create new account</a>";
                                        }
                                    ?>
                                    </li>
                                    <li class="nav-item">
                                    <?php 
                                        if (isset($_SESSION['username'])) {
                                            echo "<a class='nav-link' href='/publication'>New post</a>";
                                        }
                                    ?>
                                    </li>
                                    <li class="nav-item">
                                            <a class="nav-link" href="/logout">Logout</a>
                                    </li>
                            </ul>
            </div>
        </nav>
        <?php
            include_once("php/database.php");
            //echo "database.php";
            $database = new Database();
            $conn = $database->getConnection();
            //echo "\$conn = \$database->getConnection();";
            $sql = "SELECT * FROM `posts` ORDER BY `date` DESC, `time` DESC";
            //echo "Forming of SQL query.";
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
        ?>
    </div>
</body>
</html>