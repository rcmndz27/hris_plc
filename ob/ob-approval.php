<?php

    Class ObApproval{

        function GetOBSummary($empCode){

            global $connL;
            
            $query = "SELECT COUNT(ob_date) as ob_cnt,b.firstname,b.middlename,b.lastname,a.emp_code from tr_offbusiness a left join employee_profile b on a.emp_code = b.emp_code  WHERE b.reporting_to = :reporting_to and status = 1 GROUP BY b.firstname,b.middlename,b.lastname,a.emp_code";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empCode);
            $stmt->execute($param);
            $result = $stmt->fetch();

            echo "
                <table id='employeeOBSummaryList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Filed OB Total (Days)for Approval</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{
                    $obFiled = (isset($result['ob_cnt']) ? $result['ob_cnt'] : 0);
                    $obFiled = ($obFiled === ".00" ? 0 : $obFiled);
                    echo"
                        <tr>
                            <td>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</td>
                            <td>"."<button style='width: 9.375rem;' class='penLeave btnPending' id='".$result['emp_code']."' type='submit'>".$obFiled."</button>
                            <button id='alertob' value='".$obFiled."' hidden></button></td>
                        </tr>";
                } while($result = $stmt->fetch());

                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="2" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function GetOBDetails($empReportingTo,$empId){

            global $connL;

            $query = "SELECT count(a.ob_date) as obcnt, a.ob_date ,a.ob_destination,a.ob_time,a.ob_purpose,a.ob_percmp,b.firstname,b.middlename,b.lastname,a.emp_code,a.remarks,a.rowid from tr_offbusiness a left join employee_profile b on a.emp_code = b.emp_code WHERE a.ob_reporting = :reporting_to AND a.emp_code = :emp_code and status = 1 GROUP BY a.ob_date,a.ob_destination,a.ob_time,a.ob_purpose,a.ob_percmp,b.firstname,b.middlename,b.lastname,a.emp_code,a.remarks,a.rowid";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empReportingTo , ":emp_code" => $empId );
            $stmt->execute($param);
            $result = $stmt->fetch();

            echo "
                <table id='employeeOBDetailList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th colspan ='7' class='text-center'>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</th>
                        </tr>
                        <tr>
                            <th>OB Date</th>
                            <th>Destination</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Person/Company to See</th>
                            <th hidden>OB Days</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{

                    $actualOB = (isset($result['obcnt']) ? $result['obcnt'] : 0);

                    echo"
                        <tr id='clv".$result['rowid']."'>
                            <td>".date('m-d-Y',strtotime($result['ob_date']))."</td>
                            <td>".$result['ob_destination']."</td>
                            <td>".date('h:i a', strtotime($result['ob_time']))."</td>
                            <td>".$result['ob_purpose']."</td>
                            <td>".$result['ob_percmp']."</td>
                            <td hidden>"."<input type='number' class='form-control' value='".round($actualOB,2)."'  max='".round($actualOB,2)."' onkeydown='return false' min='0'>"."</td>
                            <td>".
                                "<button class='chckbt btnApproved' id='".$result['rowid']."'><i class='fas fa-check'></i></button> &nbsp".
                                "<button class='rejbt btnRejectd' id='".$result['rowid']."'><i class='fas fa-times'></i></button>"."</td>
                        </tr>";
                } while($result = $stmt->fetch());
                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="7" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function ApproveOB($empReportingTo,$empId,$apvdob,$rowid){

            global $connL;

                $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empReportingTo";
                $sparam = array(':empReportingTo' => $empReportingTo);
                $sstmt =$connL->prepare($squery);
                $sstmt->execute($sparam);
                $sresult = $sstmt->fetch();
                $sname = $sresult['fullname'];                

                $querys = "INSERT INTO logs_ob (ob_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:ob_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":ob_id" => $rowid,
                    ":emp_code"=> $empId,
                    ":emp_name"=> $sname,
                    ":remarks" => 'Approved '.$apvdob.' day/s by '.$sname,
                    ":audituser" => $empReportingTo,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;


            $query = " UPDATE tr_offbusiness SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate 
            WHERE ob_reporting = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

            $stmt =$connL->prepare($query);

            $param = array(
                ":rowid" => $rowid,
                ":emp_code" => $empId,
                ":reporting_to" => $empReportingTo,
                ":apvd_stat" => 2,
                ":audituser" => $empReportingTo,
                ":auditdate" => date('m-d-Y')
            );

            $result = $stmt->execute($param);

            echo $result;

             
        }

        function RejectOB($empReportingTo,$empId,$rjctRsn,$rowid){

            global $connL;

                $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empReportingTo";
                $sparam = array(':empReportingTo' => $empReportingTo);
                $sstmt =$connL->prepare($squery);
                $sstmt->execute($sparam);
                $sresult = $sstmt->fetch();
                $sname = $sresult['fullname'];                  

                $querys = "INSERT INTO logs_ob (ob_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:ob_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
            $params = array(
                ":ob_id" => $rowid,
                ":emp_code"=> $empId,
                ":emp_name"=> $sname,
                ":remarks" => 'Rejected by '.$sname.'. Reason:'.$rjctRsn,
                ":audituser" => $empReportingTo,
                ":auditdate"=>date('m-d-Y')
            );

            $results = $stmts->execute($params);

            echo $results;


            $query = " UPDATE tr_offbusiness 
            SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate, reject_reason = :reject_reason
            WHERE ob_reporting = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

            $stmt =$connL->prepare($query);

            $param = array(
                ":apvd_stat" => 3,
                ":emp_code" => $empId,
                ":rowid" => $rowid,
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
    
        function GetApprovedList($employee){
            
            global $connL;

            $query = 'SELECT b.firstname,b.middlename,b.lastname,a.date_filed,a.ob_destination,a.ob_time,a.ob_purpose,a.ob_percmp,a.ob_date FROM dbo.tr_offbusiness a left join employee_profile b on a.emp_code = b.emp_code WHERE a.emp_code = :emp_code and a.status = 2';
            $param = array(':emp_code' => $employee);
            $stmt = $connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();
    
    
            echo '
            <table id="approvedList" class="table table-striped table-sm">
            <thead>
                <tr>
                            <th>Employee</th>
                            <th>Date Filed</th>
                            <th>OB Date</th>
                            <th>Destination</th>
                            <th>Time</th>
                            <th>Purpose</th>
                            <th>Person/Company to See</th>                  
                </tr>
            </thead>
            <tbody>';
    
            
            if($result){
                do { 
                    echo '
                    <tr>
                    <td>'.$result['lastname'].",".$result['firstname']." ".$result['middlename'].'</td>
                    <td>' . date('m-d-Y', strtotime($result['date_filed'])) . '</td>
                    <td>' . date('m-d-Y', strtotime($result['ob_date'])) . '</td>
                    <td>' . $result['ob_destination'] . '</td>
                    <td>' . date('h:i a', strtotime($result['ob_time'])). '</td>
                    <td>' . $result['ob_purpose'] . '</td>
                    <td>' . $result['ob_percmp'] . '</td>
                    </tr>';
    
                } while ($result = $stmt->fetch());
    
                echo '</tbody>';
    
            }else { 
                echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
            }
            echo '</table>';
        } 
    
        
    }
?>