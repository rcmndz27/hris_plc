<?php
    session_start();

    
    
    include('../controller/dtr.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();
    $empInfo->SetEmployeeInformation($_SESSION['userid']);
    $empCode = $empInfo->GetEmployeeCode();

    $employeedtr = new EmployeeDTR();

    $dtr = json_decode($_POST["data"]);

    if($dtr->{"Action"} == "GetAttendanceList"){
        $datestart = $dtr->{"datefrom"};
        $dateend = $dtr->{"dateto"};
      //  $empcode = $dtr->{"empcode"};

        $empcode = (empty($empcode) ? $empCode : $empcode);
        
        $employeedtr->GetAttendanceList($datestart, $dateend, $empcode);
    }



?>