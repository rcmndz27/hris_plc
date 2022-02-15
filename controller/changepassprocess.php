<?php

    session_start();

    include('../controller/changepass.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();

    $empInfo->SetEmployeeInformation($_SESSION['userid']);

    $empCode = $empInfo->GetEmployeeCode();

    $changePassApp = new ChangePasswordApplication();

    $changePassApplication = json_decode($_POST["data"]);

    if($changePassApplication->{"Action"} == "ChangePass"){

        $newpassword = $changePassApplication->{"newpassword"};
        $confirmpassword = $changePassApplication->{"confirmpassword"};
        
        $changePassApp->ChangePasswordApp($empCode,$newpassword,$confirmpassword);

    }else{
                $newpassword = $changePassApplication->{"newpassword"};
        $confirmpassword = $changePassApplication->{"confirmpassword"};
        
        $changePassApp->ChangePasswordApp($empCode,$newpassword,$confirmpassword);

    }
     

?>