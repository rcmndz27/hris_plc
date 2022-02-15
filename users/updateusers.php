<?php 


function UpdateUsers($emp_code,$userpassword,$status,$usertype)
    {
            global $connL;

            $hashpassword = hash('sha256', $userpassword);

            $cmd = $connL->prepare("UPDATE dxbo.mf_user SET 
                userpassword = :hashpassword,
                status = :status, x
                usertype = :usertype
                where userid = :emp_code");
            $cmd->bindValue('emp_code',$emp_code);
            $cmd->bindValue('hashpassword',$hashpassword);
            $cmd->bindValue('status',$status);
            $cmd->bindValue('usertype',$usertype);
            $cmd->execute();
    }


?>
