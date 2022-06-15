<?php
    session_start();
    
    include('../att_report/att_rep.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();
    $empInfo->SetEmployeeInformation($_SESSION['userid']);
    $empCode = $empInfo->GetEmployeeCode();

    $employeedtr = new AttRepDTR();

    $dtr = json_decode($_POST["data"]);

    if($dtr->{"Action"} == "GetAttRepList"){
        $datestart = $dtr->{"datefrom"};
        $dateend = $dtr->{"dateto"};
       
        $employeedtr->GetAttRepList($datestart, $dateend);
    }



?>