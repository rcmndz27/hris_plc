<?php  

   function ApprovePayView($empCode,$pfrom,$pto,$ppay)
    {
            global $connL;

            $query_pay = $connL->prepare('EXEC hrissys_test.dbo.payroll_summary :period_from, :period_to , :location, :emp_code');
            $query_pay->bindValue(':period_from',$pfrom);
            $query_pay->bindValue(':period_to',$pto);
            $query_pay->bindValue(':location','Makati');
            $query_pay->bindValue(':emp_code',$empCode);
            $query_pay->execute();
            // $q = $query_pay->fetch();

    }

   function ApprovePayView30($empCode,$pfrom,$pto,$pfrom30,$pto30,$ppay)
    {
            global $connL;

            $query_pay = $connL->prepare('EXEC hrissys_test.dbo.payroll_summary_30th :period_from, :period_to , :period_from30, :period_to30 , :location, :emp_code');
            $query_pay->bindValue(':period_from',$pfrom);
            $query_pay->bindValue(':period_to',$pto);
            $query_pay->bindValue(':period_from30',$pfrom30);
            $query_pay->bindValue(':period_to30',$pto30);            
            $query_pay->bindValue(':location','Makati');
            $query_pay->bindValue(':emp_code',$empCode);
            $query_pay->execute();
            // $q = $query_pay->fetch();

    }    

 ?>