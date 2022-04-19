<?php 
    function CancelOb($obid,$emp_code)
    {
        global $connL;

        $cmd = $connL->prepare("UPDATE dbo.tr_offbusiness SET status = 4 where rowid = :obid");
        $cmd->bindValue('obid',$obid);
        $cmd->execute();

        $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :emp_code";
        $sparam = array(':emp_code' => $emp_code);
        $sstmt =$connL->prepare($squery);
        $sstmt->execute($sparam);
        $sresult = $sstmt->fetch();
        $sname = $sresult['fullname'];

        $qry = 'SELECT max(rowid) as maxid FROM tr_offbusiness WHERE emp_code = :emp_code';
        $prm = array(":emp_code" => $emp_code);
        $stm =$connL->prepare($qry);
        $stm->execute($prm);
        $rst = $stm->fetch();

        $querys = "INSERT INTO logs_ob (ob_id,emp_code,emp_name,remarks,audituser,auditdate) 
            VALUES(:ob_id,:emp_code,:emp_name,:remarks,:audituser, :auditdate) ";

            $stmts =$connL->prepare($querys);

            $params = array(
                ":ob_id" => $rst['maxid'],
                ":emp_code"=> $emp_code,
                ":emp_name"=> $sname,
                ":remarks" => 'Cancelled/Voided Official Business',
                ":audituser" => $emp_code,
                ":auditdate"=>date('m-d-Y')
            );

        $results = $stmts->execute($params);

        echo $results;

    }

    ?>