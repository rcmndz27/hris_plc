<?php 


function UpdateAllowances($emp_code,$benefit_id,$period_cutoff,$amount,$effectivity_date)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.employee_allowances_management SET 
                benefit_id = :benefit_id,
                period_cutoff = :period_cutoff,
                amount = :amount,
                effectivity_date = :effectivity_date
             where emp_code = :emp_code");
            $cmd->bindValue('emp_code',$emp_code);
            $cmd->bindValue('benefit_id',$benefit_id);
            $cmd->bindValue('period_cutoff',$period_cutoff);
            $cmd->bindValue('amount',$amount);
            $cmd->bindValue('effectivity_date',$effectivity_date);
            $cmd->execute();
    }


?>
