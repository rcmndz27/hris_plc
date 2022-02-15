<?php

    session_start();

    include('../config/db.php');
    include('otApplication.php');

    $empCode = $_POST["_code"];
    $date = $_POST["_date"];
    $hrs = $_POST["_hrs"];
    $hrs2 = $_POST["_hrs2"];
    $rem = $_POST["_rem"];
    $base64 = $_POST["_base64"];

    InsertOt($empCode, $date, $hrs, $hrs2, $rem, $base64);
    GetOTHistory($empCode);

    echo "<script>location.replace(window.location.href.split('#')[0]);</script>";

?>