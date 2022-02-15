<?php
    session_start();

    include('profileSettings.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();
    $empInfo->SetEmployeeInformation($_SESSION['userid']);
    $empCode = $empInfo->GetEmployeeCode();

    $profileSetting = json_decode($_POST["data"]);

    

    // $emp = $_POST['empId'];
    // $option = $_POST['option'];
    // $action = $_POST['action'];

    // if ($action == "SHOW")
    // {
    //     switch($option)
    //     {
    //         case 0: // Basic
    //             ShowBasicDetails($emp);
    //             break;
    //         case 1: // Family
    //             ShowFamilyDetails($emp);
    //             break;
    //         case 2: // Education
    //             ShowEducationDetails($emp);
    //             break;
    //         case 3:
    //             ShowSettings($emp);
    //             break;
    //         default:
    //             break;
    //     }
    // }
    // else if ($action == "EDIT")
    // {
    //     switch($option)
    //     {
    //         case 0: // Basic
    //             EditBasicDetails($emp, $_POST['info']);
    //             ShowBasicDetails($emp);
    //             break;
    //         case 1: // Family
    //             EditFamilyDetails($emp, $_POST['info']);
    //             ShowFamilyDetails($emp);
    //             break;
    //         case 2: // Education
    //             EditEducationDetails($emp, $_POST['info']);
    //             ShowEducationDetails($emp);
    //             break;
    //         case 3:
    //             EditPassword($emp, $_POST['pass']);
    //             ShowSettings($emp);
    //         default:
    //             break;
    //     }
    // }
    // else {}




?>