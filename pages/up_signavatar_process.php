<?php

    session_start();

    include('../pages/up_signavatar.php');
    include('../config/db.php');
    include('../controller/empInfo.php');

    $empInfo = new EmployeeInformation();
    $empInfo->SetEmployeeInformation($_SESSION['userid']);
    $empCode = $empInfo->GetEmployeeCode();

    $upAvatarsign = json_decode($_POST["data"]);

    if($upAvatarsign->{"Action"} == "UploadAvatar"){

        $up_avatar = $upAvatarsign->{"up_avatar"};
        UpdateAvatar($empCode,$up_avatar);

    }else{
        $up_sign = $upAvatarsign->{"up_sign"};
        UpdateSignature($empCode,$up_sign);

    }
       

?>