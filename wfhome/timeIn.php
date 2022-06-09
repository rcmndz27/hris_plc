<?php 
date_default_timezone_set('Asia/Manila');

    function TimeIn($wfhid,$emp_code)
    {
        global $connL;


        $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :emp_code";
        $sparam = array(':emp_code' => $emp_code);
        $sstmt =$connL->prepare($squery);
        $sstmt->execute($sparam);
        $sresult = $sstmt->fetch();
        $sname = $sresult['fullname'];

        $queryf = "INSERT INTO employee_attendance (emp_code,name,punch_date,timein) 
            VALUES(:emp_code,:name,:punch_date,:timein) ";

            $stmtf =$connL->prepare($queryf);

            $paramf = array(
                ":emp_code"=> substr($emp_code,3),
                ":name"=> $sname,
                ":punch_date" => date('Y-m-d'),
                ":timein" => date('Y-m-d H:i:s')
            );  

            $resultf = $stmtf->execute($paramf);      

        $qry = 'SELECT max(rowid) as maxid FROM tr_workfromhome WHERE emp_code = :emp_code';
        $prm = array(":emp_code" => $emp_code);
        $stm =$connL->prepare($qry);
        $stm->execute($prm);
        $rst = $stm->fetch();

        $querys = "INSERT INTO logs_wfh (wfh_id,emp_code,emp_name,remarks,audituser,auditdate) 
            VALUES(:wfh_id,:emp_code,:emp_name,:remarks,:audituser, :auditdate) ";

            $stmts =$connL->prepare($querys);

            $params = array(
                ":wfh_id" => $rst['maxid'],
                ":emp_code"=> $emp_code,
                ":emp_name"=> $sname,
                ":remarks" => 'User Time in: '.date('h:i A'),
                ":audituser" => $emp_code,
                ":auditdate"=>date('m-d-Y')
            );

        $results = $stmts->execute($params);

        echo $results;

    }

    ?>