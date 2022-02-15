<?php

    session_start();

    include('../wfhome/wfh_app.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();

    $empInfo->SetEmployeeInformation($_SESSION['userid']);

    $empCode = $empInfo->GetEmployeeCode();
    $empReportingTo = $empInfo->GetEmployeeReportingTo();

    $wfhApp = new WfhApp(); 

    $wfhApplication = json_decode($_POST["data"]);

    if($wfhApplication->{"Action"} == "ApplyWfhApp"){

        $attachment = $wfhApplication->{"attachment"};
        $remarks = $wfhApplication->{"remarks"};
        $arr = $wfhApplication->{"wfhdate"} ;

        foreach($arr as $value){
            $wfhDate = $value;

        $wfhApp->InsertAppliedWfhApp($empCode,$empReportingTo,$wfhDate,$remarks,$attachment);

        }

    }else{
    }
       

?>