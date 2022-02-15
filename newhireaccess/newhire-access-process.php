<?php

session_start();

include("../controller/global-function.php");
include('../config/db.php');
include("../newhireaccess/newhire-access.php");
include('../controller/empInfo.php');

$globalFunction = new GlobalFunction();
$newHireAccess = new NewHireAccess();
$empInfo = new EmployeeInformation();

$empInfo->SetEmployeeInformation($_SESSION['userid']);
$empCode = $empInfo->GetEmployeeCode();



$newhireaccess = json_decode($_POST["data"]);

if($newhireaccess->{"Action"} == "GetCompanyList")
{
    $globalFunction->GetCompanyList();

}elseif($newhireaccess->{"Action"} == "GetLocationList")
{
    $globalFunction->GetLocationList();

}elseif($newhireaccess->{"Action"} == "GetDepartmentList")
{
    $globalFunction->GetDepartmentList();
}
elseif($newhireaccess->{"Action"} == "GetPositionList")
{
    $globalFunction->GetPositionList();

}elseif($newhireaccess->{"Action"} == "GetEmployeeTypeList")
{
    $globalFunction->GetEmployeeTypeList();

}elseif($newhireaccess->{"Action"} == "GetEmployeeReportingToList")
{
    $globalFunction->GetEmployeeReportingToList();
}
elseif($newhireaccess->{"Action"} == "GetEmployeeLevelList")
{
    $globalFunction->GetEmployeeLevelList();
}
elseif($newhireaccess->{"Action"} == "AddNewHire")
{
    $employeecode = $newhireaccess->{"employeecode"};
    $firstname = $newhireaccess->{"firstname"};
    $middlename = $newhireaccess->{"middlename"};
    $lastname = $newhireaccess->{"lastname"};
    $company = $newhireaccess->{"companylist"};
    $location = $newhireaccess->{"locationlist"};
    $department = $newhireaccess->{"departmentlist"};
    $position = $newhireaccess->{"positionList"};
    $otherposition = $newhireaccess->{"otherposition"};
    $employeetype= $newhireaccess->{"employeetypelist"};
    $reportingto = $newhireaccess->{"employeereportingtolist"};
    $datehired = $newhireaccess->{"datehired"};
    $level = $newhireaccess->{"levellist"};
    
    $employeeposition = ($position === "Others" ? $otherposition : $position);

    $newHireAccess->AddNewHireAccess($empCode,$employeecode,$firstname,$middlename,$lastname,$company,$location,$department,$employeeposition,$employeetype,$reportingto, $datehired, $level);

}
    




?>