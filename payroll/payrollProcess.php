<?php
    session_start();

    
    include('../payroll/payroll.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();
    $empInfo->SetEmployeeInformation($_SESSION['userid']);
    $empCode = $empInfo->GetEmployeeCode();

    $payroll = new PayrollPay();

    $dtr = json_decode($_POST["data"]);

    if($dtr->{"Action"} == "GetPayrollList"){
        $datestart = $dtr->{"datefrom"};
        $dateend = $dtr->{"dateto"};
        $location = $dtr->{"location"};
        $empcode = (empty($empcode) ? $empCode : $empcode);
        
        $payroll->GetPayrollList($datestart, $dateend,$location,$empcode);
    }


?>