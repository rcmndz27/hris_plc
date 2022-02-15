<?php
    session_start();

    $_SESSION['userid'];

    if(empty($_SESSION['userid']) ?  $empId = "" : $empId = $_SESSION['userid']);

    include('dtr.php');
    include('../config/db.php');

    echo "<script type='text/javascript'>$('body').css('cursor', 'default');</script>";

    $dtr = json_decode($_POST["data"]);

    if($dtr->{"Action"} == "GetAttendanceList"){
        $dateStart = $dtr->{"datefrom"};
        $dateEnd = $dtr->{"dateto"};
        GetAttendanceList($dateStart, $dateEnd, $empId);
    }



?>