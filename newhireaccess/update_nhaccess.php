<?php 

    function UpdateEmployeeLevel($department,$position,$location,$emp_type,$emp_level,$work_sched_type,$minimum_wage,$pay_type,$reporting_to,$rowid)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.employee_profile SET department = :department,position = :position,location = :location,emp_type = :emp_type,ranking = :emp_level,work_sched_type = :work_sched_type,minimum_wage = :minimum_wage,pay_type = :pay_type,reporting_to = :reporting_to  where emp_code = :rowid ");
            $cmd->bindValue('department',$department);
            $cmd->bindValue('position',$position);
            $cmd->bindValue('location',$location);
            $cmd->bindValue('emp_type',$emp_type);
            $cmd->bindValue('emp_level',$emp_level);
            $cmd->bindValue('work_sched_type',$work_sched_type);
            $cmd->bindValue('minimum_wage',$minimum_wage);
            $cmd->bindValue('pay_type',$pay_type);
            $cmd->bindValue('reporting_to',$reporting_to);
            $cmd->bindValue('rowid', $rowid);
            $cmd->execute();
    }


?>
