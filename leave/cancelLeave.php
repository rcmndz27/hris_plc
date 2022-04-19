<?php 
    function CancelLeave($leaveid,$emp_code)
    {
        global $connL;

        $cmd = $connL->prepare("UPDATE dbo.tr_leave SET approved = 4 where rowid = :leaveid");
        $cmd->bindValue('leaveid',$leaveid);
        $cmd->execute();

            $qry = 'SELECT max(rowid) as maxid FROM tr_leave WHERE emp_code = :emp_code';
            $prm = array(":emp_code" => $emp_code);
            $stm =$connL->prepare($qry);
            $stm->execute($prm);
            $rst = $stm->fetch();

            $querys = "INSERT INTO logs_leave (leave_id,emp_code,remarks,audituser,auditdate) 
                VALUES(:leave_id, :emp_code, :remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":leave_id" => $rst['maxid'],
                    ":emp_code"=> $emp_code,
                    ":remarks" => 'Cancelled/Voided Leave',
                    ":audituser" => $emp_code,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;

    }

    ?>