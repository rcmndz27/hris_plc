<?php

    Class WfhApproval{

        function GetWfhSummary($empCode){

            global $connL;
            
            $query = "SELECT count(wfh_date) as [wfh],b.firstname,b.middlename,b.lastname,a.emp_code from tr_workfromhome a left join employee_profile b on a.emp_code = b.emp_code  WHERE a.reporting_to = :reporting_to and status = 1 GROUP BY b.firstname,b.middlename,b.lastname,a.emp_code";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empCode);
            $stmt->execute($param);
            $result = $stmt->fetch();

            // var_dump($result);
            // // exit();

            echo "
                <table id='employeeOTSummaryList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Filed WFH Total (days )for Approval</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{
                    $wfhFiled = (isset($result['wfh']) ? $result['wfh'] : 0);
                    $wfhFiled = ($wfhFiled === ".00" ? 0 : $wfhFiled);
                    echo"
                        <tr>
                            <td>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</td>
                            <td>"."<button style='width: 9.375rem;' class='penLeave btnPending' id='".$result['emp_code']."' 
                            type='submit'>".$wfhFiled."</button>
                            <button id='alertwfh' value='".$wfhFiled."' hidden></button></td>
                        </tr>";
                } while($result = $stmt->fetch());

                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="2" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function GetWfhDetails($empReportingTo,$empId){

            global $connL;

            $query = "SELECT a.rowid,b.firstname,b.middlename,b.lastname,a.emp_code,a.wfh_date,a.wfh_task,a.wfh_output,a.wfh_percentage,a.date_filed,a.attachment,a.reporting_to from tr_workfromhome a left join employee_profile b on a.emp_code = b.emp_code WHERE a.reporting_to = :reporting_to AND a.emp_code = :emp_code and status = 1";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empReportingTo , ":emp_code" => $empId );
            $stmt->execute($param);
            $result = $stmt->fetch();

            echo "
                <table id='employeeWfhDetailList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th colspan ='6' class='text-center'>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</th>
                        </tr>
                        <tr>
                            <th>Date Filed</th>
                            <th>WFH Date</th>
                            <th>Task</th>
                            <th>Expected Output</th>
                            <th>Percentage %</th>
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
                            <td>".date('m-d-Y', strtotime($result['wfh_date']))."</td>
                            <td>".$result['wfh_task']."</td>
                            <td>".$result['wfh_output']."</td>
                            <td>".$result['wfh_percentage']."</td>
                            <td hidden>"."<input type='text' class='form-control' 
                            value='".$result['reporting_to']."' >"."</td>
                            <td>".
                                "<button class='chckbt btnApproved' id='".$result['rowid']."'><i class='fas fa-check'></i></button> &nbsp;".
                                "<button class='rejbt btnRejectd' id='".$result['rowid']."'><i class='fas fa-times'></i></button> &nbsp;";

                          if($result['reporting_to'] == 'OBN20000205') {

                           }else{
                            echo '<button class="fwdAppr btnFwd" id="'.$result['rowid'].'" value="'.$result['rowid'].'"><i class="fas fa-arrow-right"></i><button id="empcode" value="'.$result['emp_code'].'" hidden></button>';
                         } 
                         
                        "</td></tr>";                                
                } while($result = $stmt->fetch());
                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="6" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function ApproveWfh($empReportingTo,$empId,$rowId){

            global $connL;

                $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empReportingTo";
                $sparam = array(':empReportingTo' => $empReportingTo);
                $sstmt =$connL->prepare($squery);
                $sstmt->execute($sparam);
                $sresult = $sstmt->fetch();
                $sname = $sresult['fullname'];

                $querys = "INSERT INTO logs_wfh (wfh_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:wfh_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":wfh_id" => $rowId,
                    ":emp_code"=> $empId,
                    ":emp_name"=> $sname,
                    ":remarks" => 'Approved by '.$sname,
                    ":audituser" => $empReportingTo,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;

            $query = " UPDATE tr_workfromhome SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate 
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

        function RejectWfh($empReportingTo,$empId,$rjctRsn,$rowId){

            global $connL;


                $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empReportingTo";
                $sparam = array(':empReportingTo' => $empReportingTo);
                $sstmt =$connL->prepare($squery);
                $sstmt->execute($sparam);
                $sresult = $sstmt->fetch();
                $sname = $sresult['fullname'];

                $querys = "INSERT INTO logs_wfh (wfh_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:wfh_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":wfh_id" => $rowId,
                    ":emp_code"=> $empId,
                    ":emp_name"=> $sname,
                    ":remarks" => 'Rejected by '.$sname.'. Reason:'.$rjctRsn,
                    ":audituser" => $empReportingTo,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;

            $query = " UPDATE tr_workfromhome SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate, reject_reason = :reject_reason WHERE reporting_to = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

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

function FwdWfh($empReportingTo,$empId,$approver,$rowid){
        

        global $connL;

        $cmd = $connL->prepare("UPDATE dbo.tr_workfromhome SET reporting_to = :approval where rowid = :rowid");
        $cmd->bindValue('approval','OBN20000205');         
        $cmd->bindValue('rowid',$rowid);                           
        $cmd->execute();
    

        $query = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empcode";
        $param = array(':empcode' => $approver);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();
        $aprvname = $result['fullname'];

        $query = "INSERT INTO logs_wfh (wfh_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:wfh_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmt =$connL->prepare($query);
    
                $param = array(
                    ":wfh_id" => $rowid,
                    ":emp_code"=> $approver,
                    ":emp_name"=> $aprvname,
                    ":remarks" => 'Forwarded to Sir.Francis Calumba',
                    ":audituser" => $approver,
                    ":auditdate"=>date('m-d-Y')
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

            $query = 'SELECT employee, ot_date, reg_ot, sh_ot, rd_ot FROM ListApprovedOvertime WHERE emp_code = :emp_code';
            $param = array(':emp_code' => $employee);
            $stmt = $connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();
    
    
            echo '
            <table id="approvedList" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Date</th>
                    <th>Regular OT</th>
                    <th>Special Holiday OT</th>
                    <th>Restday OT</th>
                </tr>
            </thead>
            <tbody>';
    
            
            if($result){
                do { 
                    echo '
                    <tr>
                    <td>' . $result['employee'] . '</td>
                    <td>' . date('m-d-Y', strtotime($result['ot_date'])) . '</td>
                    <td>' . $result['reg_ot'] . '</td>
                    <td>' . $result['sh_ot'] . '</td>
                    <td>' . $result['rd_ot'] . '</td>
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