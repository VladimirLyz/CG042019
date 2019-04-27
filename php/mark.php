<?php

function Mark($mark, $user)
{
    include_once('user.php');
    $user->UpdateRating($mark);
}

?>