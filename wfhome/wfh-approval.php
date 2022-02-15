<?php

    Class WfhApproval{

        function GetWfhSummary($empCode){

            global $connL;
            
            $query = "SELECT count(wfh_date) as [wfh],b.firstname,b.middlename,b.lastname,a.emp_code from tr_workfromhome a left join employee_profile b on a.emp_code = b.emp_code  WHERE b.reporting_to = :reporting_to and status = 1 GROUP BY b.firstname,b.middlename,b.lastname,a.emp_code";
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
                            type='submit'>".$wfhFiled."</button></td>
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

            $query = "SELECT a.rowid,b.firstname,b.middlename,b.lastname,a.emp_code,a.wfh_date,a.remarks,a.attachment from tr_workfromhome a left join employee_profile b on a.emp_code = b.emp_code WHERE a.reporting_to = :reporting_to AND a.emp_code = :emp_code and status = 1";
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
                            <th>WFH Date</th>
                            <th>Remarks</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{
                    $mf = $result['attachment'];
                    echo"
                        <tr>
                            <td>".date('m-d-Y',strtotime($result['wfh_date']))."</td>
                            <td>".$result['remarks']."</td>";
      
                        echo "<td>";
                        if(empty($mf)){
                        }else {
                            echo"<button type='button' class='btnView'><a title='Attachment' href='../uploads/".$result['attachment']."' style='color:#ffff;font-weight:bold;'  
                                        target='popup' onclick='window.open('../uploads/".$result['attachment']."' ','popup','width=600,height=600,scrollbars=no,resizable=no'); return false;'><i class='fas fa-paperclip'></i></a></button>";  
                        }             
                        echo'
                            <button class="chckbt btnApproved" id="'.$result['rowid'].'"><i class="fas fa-check"></i></button>
                            <button class="rejbt btnRejectd" id="'.$result['rowid'].'"><i class="fas fa-times"></i></button></td>
                            </tr>';
                } while($result = $stmt->fetch());
                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="6" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function ApproveWfh($empReportingTo,$empId,$rowId){

            global $connL;

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

            $query = " UPDATE tr_workfromhome 
            SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate, reject_reason = :reject_reason
            WHERE reporting_to = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

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