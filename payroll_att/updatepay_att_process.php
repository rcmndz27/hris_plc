<?php

    include('../payroll_att/payroll_att.php');
    include('../config/db.php');

    $action = $_POST["action"];
    $tda = $_POST["tda"];
    $tdw = $_POST["tdw"];
    $late = $_POST["late"];
    $ut = $_POST["ut"];
    $regot = $_POST["regot"];
    $resot = $_POST["resot"];
    $reghot = $_POST["reghot"];
    $sphot = $_POST["sphot"];
    $rowid = $_POST["rowid"];


    if ($action == 1)
    {
        UpdatePayAtt($tda,$tdw,$late,$ut,$regot,$resot,$reghot,$sphot,$rowid);
    }
    else {

    }

?>
