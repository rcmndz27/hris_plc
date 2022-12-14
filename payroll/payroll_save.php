<?php  

   function ApprovePayView($empCode,$pfrom,$pto,$ppay)
    {
            global $connL;

            $query_pay = $connL->prepare('EXEC payroll_summary :period_from, :period_to ,:location,:emp_code,:ppay');
            $query_pay->bindValue(':period_from',$pfrom);
            $query_pay->bindValue(':period_to',$pto);
            $query_pay->bindValue(':location','Makati');
            $query_pay->bindValue(':emp_code',$empCode);
            $query_pay->bindValue(':ppay',$ppay);
            $query_pay->execute();

            $qins = 'INSERT INTO dbo.logs_timekeep (pay_from,pay_to,remarks,audituser,auditdate) 
            VALUES (:pay_from,:pay_to,:remarks,:audituser,:auditdate)';
            $stmt_ins =$connL->prepare($qins);                                 
            $params = array(
                ":pay_from" => $pfrom,
                ":pay_to" => $pto,
                ":remarks" => 'GENERATED',
                ":audituser" => $empCode,
                ":auditdate" => date('Y-m-d H:i:s'),
            );                                
            $result = $stmt_ins->execute($params);

            echo $result;            

    }

   function ApprovePayView30($empCode,$pfrom,$pto,$pfrom30,$pto30,$ppay)
    {
            global $connL;

// exec [payroll_summary_30th] '2022-07-23','2022-08-07','2022-08-08','2022-08-22','makati','system','30th'            

            // echo $pfrom;
            // echo  "\r\n";
            // echo  $pto;
            // echo  "\r\n";
            // echo $pfrom30;
            // echo  "\r\n";
            // echo  $pto30;
            // echo  "\r\n";            
            // exit();
            
            $query_pay = $connL->prepare('EXEC payroll_summary_30th :period_from,:period_to,:period_from30, :period_to30,:location,:emp_code,:ppay');
            $query_pay->bindValue(':period_from',$pfrom);
            $query_pay->bindValue(':period_to',$pto);
            $query_pay->bindValue(':period_from30',$pfrom30);
            $query_pay->bindValue(':period_to30',$pto30);            
            $query_pay->bindValue(':location','Makati');
            $query_pay->bindValue(':emp_code',$empCode);
            $query_pay->bindValue(':ppay',$ppay);
            $query_pay->execute();

            $qins = 'INSERT INTO dbo.logs_timekeep (pay_from,pay_to,remarks,audituser,auditdate) 
            VALUES (:pay_from,:pay_to,:remarks,:audituser,:auditdate)';
            $stmt_ins =$connL->prepare($qins);                                 
            $params = array(
                ":pay_from" => $pfrom30,
                ":pay_to" => $pto30,
                ":remarks" => 'GENERATED',
                ":audituser" => $empCode,
                ":auditdate" => date('Y-m-d H:i:s'),
            );                                
            $result = $stmt_ins->execute($params);

            echo $result;              

    }    

 ?>