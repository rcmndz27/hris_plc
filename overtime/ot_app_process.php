<?php

    session_start();

    include('../overtime/ot_app.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();

    $empInfo->SetEmployeeInformation($_SESSION['userid']);

    $empCode = $empInfo->GetEmployeeCode();
    $empReportingTo = $empInfo->GetEmployeeReportingTo();

    $otApp = new OtApp(); 

    $otApplication = json_decode($_POST["data"]);

    
    if($otApplication->{"Action"} == "ApplyOtApp"){

        $otStartDtime = $otApplication->{"otstartdtime"};
        $otEndDtime = $otApplication->{"otenddtime"};
        $otReqHrs = $otApplication->{"otreqhrs"};
        $remarks = $otApplication->{"remarks"};
        $arr = $otApplication->{"otdate"} ;

        foreach($arr as $value){
            $otDate = $value;

        $otApp->InsertAppliedOtApp($empCode,$empReportingTo,$otDate,$otStartDtime,$otEndDtime,$otReqHrs, 
            $remarks);

        }

    }else{

    }
    

    

?>