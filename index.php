<?php
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
    if ($Page == 'api')
    {
        switch ($Module)
        {
            case 'login':
                include_once('php/authorize.php');
                break;
            case 'register':
                include_once('php/add_user.php');
                break;
            case 'getallorders':
                include_once('php/get_orders.php');
                break;
            case 'logout':
                include_once('php/logout.php');
                break;
            case 'addorder':
                include_once('php/add_order.php');
                break;
        }
    }
    else
    {
        include_once('php/verdicts.php');
        fail('Page is not found.');
    }
?>