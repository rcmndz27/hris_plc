<?php

    session_start();

    include('../leave/leaveApplication.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();

    $empInfo->SetEmployeeInformation($_SESSION['userid']);

    $empCode = $empInfo->GetEmployeeCode();
    $empName = $empInfo->GetEmployeeName();
    $empDept = $empInfo->GetEmployeeDepartment();
    $empReportingTo = $empInfo->GetEmployeeReportingTo();


    $leaveApp = new LeaveApplication();

    $leaveApplication = json_decode($_POST["data"]);

    if($leaveApplication->{"Action"} == "ApplyLeave"){

        $leaveType = $leaveApplication->{"leavetype"};
        $dateBirth = $leaveApplication->{"datebirth"};
        $dateStartMaternity = $leaveApplication->{"datestartmaternity"};
        $dateFrom = $leaveApplication->{"datefrom"};
        $dateTo = $leaveApplication->{"dateto"};
        $leaveDesc = $leaveApplication->{"leavedesc"};
        $medicalFile = (isset($leaveApplication->{"medicalfile"}) ? $leaveApplication->{"medicalfile"} : '' );
        $leaveCount = $leaveApplication->{"leaveCount"};
        $allhalfdayMark = $leaveApplication->{"allhalfdayMark"};
        
        $leaveApp->ApplyLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType,$dateBirth,$dateStartMaternity,$dateFrom, $dateTo, $leaveDesc, 
            $medicalFile, $leaveCount, $allhalfdayMark);

    }elseif($leaveApplication->{"Action"} == "GetNumberOfDays"){
        
        $dateFrom = $leaveApplication->{"datefrom"};
        $dateTo = $leaveApplication->{"dateto"};

        $leaveApp->Countdays($dateFrom,$dateTo);

    }
    

    

?>