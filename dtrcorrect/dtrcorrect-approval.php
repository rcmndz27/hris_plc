<?php

    Class DtrCorrectApproval{

        function GetDtrCorrectSummary($empCode){

            global $connL;
            
            $query = "SELECT count(dtrc_date) as [dtrc],b.firstname,b.middlename,b.lastname,a.emp_code from tr_dtrcorrect a left join employee_profile b on a.emp_code = b.emp_code  WHERE b.reporting_to = :reporting_to and status = 1 GROUP BY b.firstname,b.middlename,b.lastname,a.emp_code";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empCode);
            $stmt->execute($param);
            $result = $stmt->fetch();


            echo "
                <table id='employeeDTRCSummaryList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Filed DTR Total (days) for Approval</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{
                    $dtrcFiled = (isset($result['dtrc']) ? $result['dtrc'] : 0);
                    $dtrcFiled = ($dtrcFiled === ".00" ? 0 : $dtrcFiled);
                    echo"
                        <tr>
                            <td>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</td>
                            <td>"."<button style='width: 9.375rem;' class='penLeave btnPending' id='".$result['emp_code']."' 
                            type='submit'>".$dtrcFiled."</button>
                            <button id='alertdtrc' value='".$dtrcFiled."' hidden></button></td>
                        </tr>";
                } while($result = $stmt->fetch());

                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="2" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function GetDtrCorrectDetails($empReportingTo,$empId){

            global $connL;

            $query = "SELECT a.rowid,b.firstname,b.middlename,b.lastname,a.emp_code,a.dtrc_date,a.time_in,a.time_out,a.remarks,a.date_filed,a.status from tr_dtrcorrect a left join employee_profile b on a.emp_code = b.emp_code WHERE a.reporting_to = :reporting_to AND a.emp_code = :emp_code and status = 1";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empReportingTo , ":emp_code" => $empId );
            $stmt->execute($param);
            $result = $stmt->fetch();

            echo "
                <table id='employeeDtrCorrectDetailList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th colspan ='6' class='text-center'>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</th>
                        </tr>
                        <tr>
                            <th>Date Filed</th>
                            <th>DTR Date</th>
                            <th>Time-In</th>
                            <th>Time-Out </th>
                            <th>Reason</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{
                    echo"
                        <tr id='clv".$result['rowid']."'>
                            <td>".date('m-d-Y',strtotime($result['date_filed']))."</td>
                            <td>".date('m-d-Y', strtotime($result['dtrc_date']))."</td>
                            <td>".date('h:i a', strtotime($result['time_in']))."</td>
                            <td>".date('h:i a', strtotime($result['time_out']))."</td>
                            <td>".$result['remarks']."</td>
                            <td>".
                                "<button class='chckbt btnApproved' id='".$result['rowid']."'><i class='fas fa-check'></i></button> &nbsp".
                                "<button class='rejbt btnRejectd' id='".$result['rowid']."'><i class='fas fa-times'></i></button>"."</td>
                        </tr>";                                
                } while($result = $stmt->fetch());
                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="6" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function ApproveDtrCorrect($empReportingTo,$empId,$rowId){

            global $connL;

            $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empReportingTo";
            $sparam = array(':empReportingTo' => $empReportingTo);
            $sstmt =$connL->prepare($squery);
            $sstmt->execute($sparam);
            $sresult = $sstmt->fetch();
            $sname = $sresult['fullname'];

            $querys = "INSERT INTO logs_dtrc (dtrc_id,emp_code,emp_name,remarks,audituser,auditdate) 
            VALUES(:dtrc_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";

            $stmts =$connL->prepare($querys);

            $params = array(
                ":dtrc_id" => $rowId,
                ":emp_code"=> $empId,
                ":emp_name"=> $sname,
                ":remarks" => 'Approved by '.$sname,
                ":audituser" => $empReportingTo,
                ":auditdate"=>date('m-d-Y')
            );

            $results = $stmts->execute($params);

            echo $results;

            $query = " UPDATE tr_dtrcorrect SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate 
            WHERE reporting_to = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

            $stmt =$connL->prepare($query);

            $param = array(
                ":emp_code" => $empId,
                ":rowid" => $rowId,
                ":reporting_to" => $empReportingTo,
                ":apvd_stat" => 2,
                ":audituser" => $empReportingTo,
                ":auditdate" => date('m-d-Y')
            );

            $result = $stmt->execute($param);

            echo $result;         
        }

        function RejectDtrCorrect($empReportingTo,$empId,$rjctRsn,$rowId){

            global $connL;


            $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empReportingTo";
            $sparam = array(':empReportingTo' => $empReportingTo);
            $sstmt =$connL->prepare($squery);
            $sstmt->execute($sparam);
            $sresult = $sstmt->fetch();
            $sname = $sresult['fullname'];

            $querys = "INSERT INTO logs_dtrc (dtrc_id,emp_code,emp_name,remarks,audituser,auditdate) 
            VALUES(:dtrc_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";

            $stmts =$connL->prepare($querys);

            $params = array(
                ":dtrc_id" => $rowId,
                ":emp_code"=> $empId,
                ":emp_name"=> $sname,
                ":remarks" => 'Rejected by '.$sname.'. Reason:'.$rjctRsn,
                ":audituser" => $empReportingTo,
                ":auditdate"=>date('m-d-Y')
            );

            $results = $stmts->execute($params);

            echo $results;

            $query = "UPDATE tr_dtrcorrect SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate, reject_reason = :reject_reason WHERE reporting_to = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

            $stmt =$connL->prepare($query);

            $param = array(
                ":apvd_stat" => 3,
                ":emp_code" => $empId,
                ":rowid" => $rowId,
                ":reporting_to" => $empReportingTo,
                ":reject_reason" => $rjctRsn,
                ":audituser" => $empReportingTo,
                ":auditdate" => date('m-d-Y')
            );

            $result = $stmt->execute($param);

            echo $result;
            
        }

        function GetEmployeeList($employee){

            global $connL;
    
            $query = 'SELECT emp_code, employee FROM dbo.view_employee WHERE employee LIKE :employee ORDER BY employee';
            $param = array(':employee' => $employee);
            $stmt =$connL->prepare($query);
            $stmt->execute($param);
    
            $result = $stmt->fetchAll();
    
            $employeeList = '';
            $employeeList =  '<ul id="empList">';
    
            foreach ($result as $key => $value) {
                $employeeList.= '<li value="'.$value['emp_code'].'">'.$value['employee'].'</li>';
            }
    
            $employeeList.= '</ul>';
    
            echo  $employeeList;
        }    
        
    }
?>