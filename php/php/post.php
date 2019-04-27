<?php
    
    $iarr = parse_ini_file("post.ini");
    $_POST['username']=$iarr['username'];
    $_POST['email']=$iarr['email'];
    $_POST['password']=$iarr['password'];

?>