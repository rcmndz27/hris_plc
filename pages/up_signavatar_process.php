<?php

    session_start();

    include('../pages/up_signavatar.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $empCode = $_POST["emp_code"];

    if($action == 1){
        $up_avatar = $_POST["up_avatar"];
        UpdateAvatar($empCode,$up_avatar);
    }else{
        $up_sign = $_POST["up_sign"];
        UpdateSignature($empCode,$up_sign);

    }
       

?>