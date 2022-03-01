<?php

    session_start();

    include('../ob/ob_app.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();

    $empInfo->SetEmployeeInformation($_SESSION['userid']);

    $empCode = $empInfo->GetEmployeeCode();
    $empReportingTo = $empInfo->GetEmployeeReportingTo();

    $obApp = new ObApp(); 

    $obApplication = json_decode($_POST["data"]);

    
    if($obApplication->{"Action"} == "ApplyObApp"){

        $ob_time = $obApplication->{"ob_time"};
        $ob_destination = $obApplication->{"ob_destination"};
        $ob_purpose = $obApplication->{"ob_purpose"};
        $ob_percmp = $obApplication->{"ob_percmp"};
        $arr = $obApplication->{"ob_date"} ;

        foreach($arr as $value){
            $obDate = $value;

        $obApp->InsertAppliedObApp($empCode,$empReportingTo,$ob_time,$ob_destination,$ob_purpose,$ob_percmp, 
            $obDate);

        }

    }else{

    }
    

    

?>