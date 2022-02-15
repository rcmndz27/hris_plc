<?php

    Class OvertimeApproval{

        function GetOTSummary($empCode){

            global $connL;
            
            $query = "SELECT SUM(a.ot_req_hrs) as ot_req_hrs,b.firstname,b.middlename,b.lastname,a.emp_code from tr_overtime a left join employee_profile b on a.emp_code = b.emp_code  WHERE b.reporting_to = :reporting_to and status = 1 GROUP BY b.firstname,b.middlename,b.lastname,a.emp_code";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empCode);
            $stmt->execute($param);
            $result = $stmt->fetch();

            echo "
                <table id='employeeOTSummaryList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th>Employee Name</th>
                            <th>Filed OT Total (Hrs)for Approval</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{
                    $otFiled = (isset($result['ot_req_hrs']) ? $result['ot_req_hrs'] : 0);
                    $otFiled = ($otFiled === ".00" ? 0 : $otFiled);
                    echo"
                        <tr>
                            <td>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</td>
                            <td>"."<button style='width: 9.375rem;' class='penLeave btnPending' id='".$result['emp_code']."' type='submit'>".$otFiled."</button>
                            <button id='alertot' value='".$otFiled."' hidden></button></td>
                        </tr>";
                } while($result = $stmt->fetch());

                echo "</tbody>";
            }else{
                echo '<tfoot><tr><td colspan="2" class="text-center">No Results Found</td></tr></tfoot>'; 
            }

            echo "</table>";
        }

        function GetOTDetails($empReportingTo,$empId){

            global $connL;

            $query = "SELECT a.ot_req_hrs,a.ot_date,a.ot_ren_hrs,b.firstname,b.middlename,b.lastname,a.emp_code,a.remarks,a.rowid from tr_overtime a left join employee_profile b on a.emp_code = b.emp_code WHERE a.reporting_to = :reporting_to AND a.emp_code = :emp_code and status = 1";
            $stmt =$connL->prepare($query);
            $param = array(":reporting_to" => $empReportingTo , ":emp_code" => $empId );
            $stmt->execute($param);
            $result = $stmt->fetch();

            echo "
                <table id='employeeOTDetailList' class='table table-striped table-sm'>
                    <thead>
                        <tr>
                            <th colspan ='6' class='text-center'>".$result['lastname'].",".$result['firstname']." ".$result['middlename']."</th>
                        </tr>
                        <tr>
                            <th>OT Date</th>
                            <th>Remarks</th>
                            <th>Plan OT</th>
                            <th>OT Rendered</th>
                            <th>OT Approved</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
            ";
            if($result){
                do{

                    $actualOT = (isset($result['ot_req_hrs']) ? $result['ot_req_hrs'] : 0);

                    echo"
                        <tr>
                            <td>".date('m-d-Y',strtotime($result['ot_date']))."</td>
                            <td>".$result['remarks']."</td>
                            <td>".$result['ot_req_hrs']."</td>
                            <td>".$result['ot_ren_hrs']."</td>
                            <td>"."<input type='number' style='width: 9.375rem;' class='form-control' value='".round($actualOT,2)."'>"."</td>
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

        function ApproveOT($empReportingTo,$empId,$apvdot,$rowid){

            global $connL;

            $query = " UPDATE tr_overtime SET ot_apprv_hrs = :ot_apvd,ot_req_hrs = :ot_rqd,  status = :apvd_stat, audituser = :audituser, auditdate = :auditdate 
            WHERE reporting_to = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

            $stmt =$connL->prepare($query);

            $param = array(
                ":ot_apvd" => $apvdot,
                ":ot_rqd" => $apvdot,
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

        function RejectOT($empReportingTo,$empId,$rjctRsn,$rowid){

            global $connL;

            $query = " UPDATE tr_overtime 
            SET status = :apvd_stat, audituser = :audituser, auditdate = :auditdate, reject_reason = :reject_reason
            WHERE reporting_to = :reporting_to AND emp_code = :emp_code AND rowid = :rowid";

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

            $query = 'SELECT b.firstname,b.middlename,b.lastname, a.datefiled, a.ot_date, a.ot_ren_hrs, a.ot_type FROM dbo.tr_overtime a left join employee_profile b on a.emp_code = b.emp_code WHERE a.emp_code = :emp_code and a.status = 2';
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
                    <th>OT Date</th>
                    <th>Rendererd OT</th>
                    <th>OT Type</th>
                </tr>
            </thead>
            <tbody>';
    
            
            if($result){
                do { 
                    echo '
                    <tr>
                    <td>'.$result['lastname'].",".$result['firstname']." ".$result['middlename'].'</td>
                    <td>' . date('m-d-Y', strtotime($result['datefiled'])) . '</td>
                    <td>' . date('m-d-Y', strtotime($result['ot_date'])) . '</td>
                    <td>' . $result['ot_ren_hrs'] . '</td>
                    <td>' . $result['ot_type'] . '</td>
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