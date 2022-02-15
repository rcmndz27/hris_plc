<?php
    session_start();
    require_once( '../TCPDF/tcpdf.php' );
    include("../config/db.php");

    $series = ( isset($_GET['data']) ) ? $_GET['data']: '0';

    header('Content-Type: application/pdf');

    global $connL;

    $query = 'SELECT medicalfile FROM mf_leave WHERE rowid IN (SELECT MAX(rowid)rowid FROM employee_leave_list WHERE series = :series)';
    $param = array(':series' => $series);
    $stmt = $connL->prepare($query);
    $stmt->execute($param);

    $result = $stmt->fetch();

    $medFile = (isset($result['medicalfile'])?$result['medicalfile']:'0');

    echo base64_decode($medFile,true);

    
?>