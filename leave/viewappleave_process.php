<?php

    include('../leave/leaveApplication.php');
    include('../overtime/ot_app.php');
    include('../wfhome/wfh_app.php');
    include('../ob/ob_app.php');
    include('../dtrcorrect/dtrcorrect_app.php');
    include('../config/db.php');

    $dtr = json_decode($_POST["data"]);
    $lv = new LeaveApplication();
    $ot = new OtApp();
    $wfh = new WfhApp();
    $ob = new ObApp();
    $dtrc = new DtrCorrectApp();

    if($dtr->{"Action"} == "GetAppLeave"){
        $date_from = $dtr->{"date_from"};
        $date_to = $dtr->{"date_to"};
        $lv->GetAllLeaveHistory($date_from,$date_to);
    }else if($dtr->{"Action"} == "GetAppOt"){
        $date_from = $dtr->{"date_from"};
        $date_to = $dtr->{"date_to"};
        $ot->GetAllOtAppHistory($date_from,$date_to);        
    }else if($dtr->{"Action"} == "GetAppWfh"){
        $date_from = $dtr->{"date_from"};
        $date_to = $dtr->{"date_to"};
        $wfh->GetAllWfhAppHistory($date_from,$date_to);        
    }else if($dtr->{"Action"} == "GetAppOb"){
        $date_from = $dtr->{"date_from"};
        $date_to = $dtr->{"date_to"};
        $ob->GetAllObAppHistory($date_from,$date_to);        
    }else if($dtr->{"Action"} == "GetAppDtrc"){
        $date_from = $dtr->{"date_from"};
        $date_to = $dtr->{"date_to"};
        $dtrc->GetAlldtrcorrectAppHistory($date_from,$date_to);        
    }




?>