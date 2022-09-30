<?php

function UpdateAvatar($empCode,$up_avatar){

            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.employee_profile SET up_avatar = :up_avatar where emp_code = :emp_code");
            $cmd->bindValue('emp_code',$empCode);
            $cmd->bindValue('up_avatar',$up_avatar);
            $cmd->execute();  

}


function UpdateSignature($empCode,$up_sign){

            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.employee_profile SET up_sign = :up_sign where emp_code = :emp_code");
            $cmd->bindValue('emp_code',$empCode);
            $cmd->bindValue('up_sign',$up_sign);
            $cmd->execute();  

}

?>