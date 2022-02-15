<?php
    session_start();

    include('leaveApproval.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();

    $empInfo->SetEmployeeInformation($_SESSION['userid']);

    $empCode = $empInfo->GetEmployeeCode();
    $empName = $empInfo->GetEmployeeName();
    $empDept = $empInfo->GetEmployeeDepartment();
    $empReportingTo = $empInfo->GetEmployeeReportingTo();

    // $id = $_POST['row'];
    // $choice = $_POST['choice'];
    // $type = $_POST['leaveType'];
    // $duration = $_POST['duration'];
    
    // if ($choice == 1)
    // {
    //     ApproveLeave($id, $type, $duration, $_POST['approved']);
    // }
    // else if ($choice == 2)
    // {
    //     RejectLeave($id, $type, $duration);
    // }
    // else {}

    $leaveApproval = json_decode($_POST["data"]);
   
    // if($leaveApproval->{"Action"} == "GetLeaveList"){

    //     $employee = $leaveApproval->{"employee"};
    //     $leavetype = $leaveApproval->{"leavetype"};

    //     if(empty($employee) && empty($leavetype)){
    //         $type = '0'; //show all per approval
    //         $employee = $empID;
    //     }elseif(!empty($employee) && !empty($leavetype)){
    //         $type = '1'; //show per employee and leavetype
    //     }elseif(empty($employee) && !empty($leavetype)){
    //         $type = '2'; //show all per leavetype
    //         $employee = $empID;
    //     }elseif(!empty($employee) && empty($leavetype)){
    //         $type = '3'; //show all leavetype per employee
    //     }

    //     ViewLeaveSummaryList($employee,$leavetype,$type);

    // }else

    if($leaveApproval->{"Action"} == "GetLeaveList"){

        $employee = $leaveApproval->{"employee"};
        $leavetype = $leaveApproval->{"leavetype"};

        if(empty($employee) && empty($leavetype)){
            $type = '0'; //show all per approval
            $employee = $empID;
        }elseif(!empty($employee) && !empty($leavetype)){
            $type = '1'; //show per employee and leavetype
        }elseif(empty($employee) && !empty($leavetype)){
            $type = '2'; //show all per leavetype
            $employee = $empID;
        }elseif(!empty($employee) && empty($leavetype)){
            $type = '3'; //show all leavetype per employee
        }

        ViewLeaveSummaryList($employee,$leavetype,$type);

    }else

    if($leaveApproval->{"Action"} == "ApproveLeave") {

        $curLeaveType = $leaveApproval->{"curLeaveType"};
        $empName = $leaveApproval->{"empName"};
        $curApproved = $leaveApproval->{"curApproved"};
        $curDateFrom = $leaveApproval->{"curDateFrom"};
        $curDateTo = $leaveApproval->{"curDateTo"};
        $noOfDays = $leaveApproval->{"noOfDays"};
        $thisID = $leaveApproval->{"thisID"};

        ApproveLeave($thisID,$curApproved,$noOfDays,$curDateFrom,$curDateTo,$curLeaveType,$empName);

        // echo $thisID.', '.$curLeaveType.', '.$curApproved.', '.$noOfDays.', '.$curDateFrom.', '.$curDateTo.', '.$empName;

    }elseif ($leaveApproval->{"Action"} == "RejectLeave") {

        $curLeaveType = $leaveApproval->{"curLeaveType"};
        // $curDuration = $leaveApproval->{"curDuration"};
        $empName = $leaveApproval->{"empName"};
        $curApproved = $leaveApproval->{"curApproved"};
        $curDateFrom = $leaveApproval->{"curDateFrom"};
        $curDateTo = $leaveApproval->{"curDateTo"};
        $noOfDays = $leaveApproval->{"noOfDays"};
        $thisID = $leaveApproval->{"thisID"};

        RejectLeave($thisID,$curLeaveType,$curApproved,$noOfDays,$curDateFrom,$curDateTo,$empName);

        // echo $thisID.', '.$curLeaveType.', '.$curApproved.', '.$noOfDays.', '.$curDateFrom.', '.$curDateTo.', '.$empName;

    }elseif($leaveApproval->{"Action"} == "GetPendingList"){

        $employee = $leaveApproval->{"employee"};
        ShowAllLeave($employee);

    }elseif($leaveApproval->{"Action"} == "GetLeaveListBlank"){
    
        ViewLeaveSummaryList($empCode);
    }

    

    






?>