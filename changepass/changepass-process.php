<?php
session_start();

include("../changepass/changepass.php");
include('../controller/empInfo.php');

$changePass = new ChangePassword();

$empInfo = new EmployeeInformation();

$empInfo->SetEmployeeInformation($_SESSION['userid']);

$empCode = $empInfo->GetEmployeeCode();




$changepass = json_decode($_POST["data"]);
   
if($changepass->{"Action"} == "UpdatePassword"){

    $userpassword = $changepass->{"userpassword"};

    $changePass->UpdatePassword($empCode,$userpassword);

}

?>