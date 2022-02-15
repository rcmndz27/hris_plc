<?php

    session_start();
    require_once( '../TCPDF/tcpdf.php' );
    include("../config/db.php");

    $val = 1;

    header('Content-Type: application/pdf');
    global $connL;

    $cmd = $connL->prepare(@"SELECT upload from dbo.att_ot_filed where rowid = :rid");
    //$cmd->bindValue(":rid", $_POST["_id"]);
    $cmd->bindValue(":rid", $val);
    $cmd->execute();
    
    echo base64_decode($cmd->fetchColumn());

?>