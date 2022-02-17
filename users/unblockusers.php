<?php 


function UnblockeUsers($emp_code)
    {
            global $connL;

            $cmd = $connL->prepare("DELETE from dbo.logs where emp_code = :emp_code");
            $cmd->bindValue('emp_code',$emp_code);
            $cmd->execute();
    }


?>
