<?php
    function fail($why)
    {
        $verdict = array('status'=>'fail', 'message'=>$why);
        echo json_encode (  $verdict);
        exit;
    }
    function ok()
    {
        $verdict =  array('status'=>'ok');
        echo json_encode ( $verdict);
    }
    function ok_message($message)
    {
        $verdict =  array('status'=>'ok', $message);
        echo json_encode ( $verdict);
    }
?>