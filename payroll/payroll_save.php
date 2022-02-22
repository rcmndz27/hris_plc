<?php  

   function ApprovePayView($empCode)
    {
            global $connL;

            $q_logs = 'SELECT* FROM dbo.payroll_period_logs WHERE rowid = (SELECT MAX(rowid) AS id from dbo.payroll_period_logs where emp_code = :emp_cd)';
            $paramq = array(":emp_cd" => $empCode);
            $stmt_q =$connL->prepare($q_logs);
            $stmt_q->execute($paramq);
            $rs = $stmt_q->fetch();

            $prf = date('m/d/Y', strtotime($rs['period_from']));
            $prt = date('m/d/Y', strtotime($rs['period_to']));
            $loc = $rs["location"];

            $query_pay = $connL->prepare('EXEC hrissys_test.dbo.payroll_summary :period_from, :period_to , :location, :emp_code');
            $query_pay->bindValue(':period_from',$prf);
            $query_pay->bindValue(':period_to',$prt);
            $query_pay->bindValue(':location',$loc);
            $query_pay->bindValue(':emp_code',$empCode);
            $query_pay->execute();
            // $q = $query_pay->fetch();

    }

 ?>