<?php 

    function UpdateEmployeeLevel($department,$position,$location,$emp_type,$emp_level,$work_sched_type,$minimum_wage,$pay_type,$emp_status,$reporting_to,$lastname,$firstname,$middlename,$emailaddress,$telno,$celno,$rowid)
    {
            global $connL;

            $cmd = $connL->prepare("UPDATE dbo.employee_profile SET lastname = :lastname,firstname = :firstname,middlename = :middlename,emailaddress = :emailaddress,telno = :telno,celno = :celno,department = :department,position = :position,location = :location,emp_type = :emp_type,ranking = :emp_level,work_sched_type = :work_sched_type,minimum_wage = :minimum_wage,pay_type = :pay_type,emp_status = :emp_status,reporting_to = :reporting_to  where emp_code = :rowid ");
            $cmd->bindValue('lastname',$lastname);
            $cmd->bindValue('firstname',$firstname);
            $cmd->bindValue('middlename',$middlename);
            $cmd->bindValue('emailaddress',$emailaddress);
            $cmd->bindValue('telno',$telno);
            $cmd->bindValue('celno',$celno);
            $cmd->bindValue('department',$department);
            $cmd->bindValue('position',$position);
            $cmd->bindValue('location',$location);
            $cmd->bindValue('emp_type',$emp_type);
            $cmd->bindValue('emp_level',$emp_level);
            $cmd->bindValue('work_sched_type',$work_sched_type);
            $cmd->bindValue('minimum_wage',$minimum_wage);
            $cmd->bindValue('pay_type',$pay_type);
            $cmd->bindValue('emp_status',$emp_status);
            $cmd->bindValue('reporting_to',$reporting_to);
            $cmd->bindValue('rowid', $rowid);
            $cmd->execute();
    }


?>
