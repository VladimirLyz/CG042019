<?php
    include_once "php/settings.php";
    session_start();

    if ($_SERVER["REQUEST_URI"] == "/") {
        $Page = "index";
        $Module = "index";
    } else {
        $URL_Path = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
        $URL_Parts = explode("/", trim($URL_Path, "/"));
        $Page = array_shift($URL_Parts);
        //echo $Page;
        $Module = array_shift($URL_Parts);
        //var_dump($Module);
        //var_dump($URL_Parts);
        if (!empty($Module)) {
            $Param = array();
            for ($i = 0; $i < count($URL_Parts); $i++)
            {
                $Param[$i] = $URL_Parts[$i];
            }
            //var_dump($Param);
        }
    }

    if ($Page == "index" and $Module == "index") {
        if (isset($_SESSION['username'])) {
            header('Location: publication');
        } else {
            include("main.html");
        }
    } else {
        switch ($Page) {
            case "login":
                include("login.php");
                break;
            case "logout":
                include("php/logout.php");
                break;
            case "register":
                include("register.php");
                break;
            case "publication":
                include("publication.php");
                break;
            case "posts":
                include("get_posts.php");
                break;
            case "user":
                include_once("php/get_user.php");
                $userPage = new UserPage();
                $userPage->getUserPage($Module);
                break;
            default:
                echo "404 Error: Page not found";
                break;
        }
        
    }
?>