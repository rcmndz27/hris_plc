<?php

    function EmployeeList($empID){

        global $connL;

        $query = 'SELECT emp_code, Employee FROM view_employee WHERE reporting_to = :reportingto ORDER BY Employee';
        $param = array(':reportingto' => $empID);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = "";
        $result .= "<select class='form-control' id='employeeList' >";
        $result .= "<option value=></option>";
        while($row = $stmt->fetch()){
            $result .="<option  value=".$row['emp_code'].">".$row['Employee']."</option>";
        }
        $result .= "</select>";

        echo $result;
    }

    function LeaveList(){

        global $connL;

        $query = 'SELECT leavetype FROM mf_leavetype ORDER BY leavetype';
        $stmt =$connL->prepare($query);
        $stmt->execute();

        echo '<select class="form-control" id="leaveList">';
        echo '<option value=""></option>';
        while($row = $stmt->fetch()){
            echo '<option value="'.$row['leavetype'].'">'.$row['leavetype'].'</option>';
        }
        echo "</select>";
    }
    
    function ShowAllLeave($employee){
        global $connL;

        $query = "SELECT a.datefiled,date_from,date_to,leavetype,leave_desc,approved,approval,medicalfile,remarks,actl_cnt,a.rowid,a.emp_code,b.lastname+', '+b.firstname as [fullname] FROM tr_leave a left join employee_profile b on a.approval = b.emp_code WHERE approved = 1  AND a.emp_code =:empCode";
        $param = array(':empCode' => $employee);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        echo '<table id="employeeLeaveList" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="8" class="text-center">List of Pending Leave Request</th>';
        echo '</tr>
                <tr>
                    <th>Date Filed</th>
                    <th>Leave Date</th>
                    <th>Leave Type</th>
                    <th>Reason</th>
                    <th>Approver</th>
                    <th hidden>Approved Days</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';

        if($result){
          
			do { 
                $mf = $result['medicalfile'];
                echo "
        <tr id='clv".$result['rowid']."'>
            <td>" . date('Y-m-d',strtotime($result['datefiled'])) . "</td>
            <td>" . date('Y-m-d',strtotime($result['date_from'])) . "</td>
            <td class='text-left text-info'>" . $result['leavetype'] . "</td>
            <td>" . $result['leave_desc'] . "</td>
            <td>" . $result['fullname'] . "
            <button id='apr".$result['rowid']."' value=".$result['approval']." hidden></button></td>
            <td hidden id='ap".$result['rowid']."'>"."<input type='text' id='apc".$result['rowid']."' class='form-control text-center' value='".$result['actl_cnt']."'>".$result['actl_cnt']."</td>";
            

                echo "<td>";
                if(empty($mf)){
                }else {
                    echo"<button type='button' class='btnView atch'><a title='Attachment' href='../uploads/".$result['medicalfile']."' style='color:#ffff;font-weight:bold;'  
                                target='popup' onclick='window.open('../uploads/".$result['medicalfile']."' ','popup','width=600,height=600,scrollbars=no,resizable=no'); return false;'><i class='fas fa-paperclip'></i></a></button>";  
                }             
                echo'
                    <button class="chckbt btnApproved" id="'.$result['emp_code'].' '.$result['rowid'].'" value="'.$result['rowid'].'"><i class="fas fa-check"></i></button><button id="empcode" value="'.$result['emp_code'].'" hidden></button>
                    <button class="rejbt btnRejectd" id="'.$result['emp_code'].' '.$result['rowid'].'" value="'.$result['rowid'].'"><i class="fas fa-times"></i></button><button id="empcode" value="'.$result['emp_code'].'" hidden></button>
                    </td>';
            
        echo "</tr>";
            } while ($result = $stmt->fetch());
            echo "</tbody><tfoot>";
        }else{
            echo '<tr><td colspan="8" class="text-center">No Results Found</td></tr>';
        }

        echo "<tfoot></table>";

    }

    function ViewLeaveSummaryList($employee){
        global $connL;

        $query = 'SELECT 
        view_employee.emp_code, 
        view_employee.employee,
        10 leavebegbal, 
        used, 
        pending, 
        earned_sl, 
        earned_vl,
        pending_sum
        FROM view_employee
        INNER JOIN LeaveCount leavecount ON leavecount.emp_code = view_employee.emp_code  
        WHERE reporting_to = :reporting_to ORDER BY view_employee.employee';

        $param = array(':reporting_to' => $employee);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        echo '<table id="leaveSummaryList" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="3w" class="text-center">Balance</th>
                </tr>
                <tr>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Beginning</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Sick Leave</th>
                    <th class="text-center">Vacation Leave</th>
                    <th class="text-center">History</th>
                </tr>
            </thead>
            <tbody>';

        if($result){
            
			do { 

                $begbal = (isset($result['leavebegbal']) ? $result['leavebegbal'] : 0);
                $used = (isset($result['used']) ? $result['used'] : 0);
                $pending = (isset($result['pending']) ? floatval($result['pending']) : 0);
                $pending_sum = (isset($result['pending_sum']) ? floatval($result['pending_sum']) : 0);
                $earned_sl = (isset($result['earned_sl']) ? $result['earned_sl'] : 0);
                $earned_vl = (isset($result['earned_vl']) ? $result['earned_vl'] : 0);

                $totalPending = $pending+$pending_sum;

                echo'
                <tr>
                    <td>'.$result['employee'].'</td>'.
                    '<td class="text-center">'. round($begbal,2) .'</td>'.
                    '<td class="text-center">'. round($used,2) .'</td>'.
                    '<td><button class="penLeave btnPending" id="'.$result['emp_code'].'" type="submit">'. $totalPending .'</button>
                    <button id="alertleave" value="'. $totalPending .'" hidden></button></td></td>'.
                    '<td class="text-center">'. round($earned_sl,2) .'</td>'.
                    '<td class="text-center">'. round($earned_vl,2) .'</td>'.
                    '<td class="text-center"><button class="hstry btnViewing" id="'.$result['emp_code'].'" type="submit"><i class="fas fa-search"></button></td>'.
                '</tr>';
                
            } while ($result = $stmt->fetch());

            echo '</tbody><tfoot>';

        }else{
            echo '<tr><td colspan="9" class="text-center">No Results Found</td></tr>';
        }

        echo "</tfoot></table>";

    }

    function GetLeaveHistory($employee){

        global $connL;

        echo '
        <table id="dtrList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="9" class ="text-center">History</th>
            </tr>
            <tr>
                <th>Date Filed</th>
                <th>Leave Type</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Description</th>
                <th>Leave Count</th>
                <th>Approved (Days)</th>
                <th>Status</th>
                <th>Remarks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = 'SELECT datefiled, leave_desc, leavetype, date_from, date_to, actl_cnt, app_days, approved, emp_code, rowid, remarks FROM dbo.tr_leave where emp_code = :emp_code ORDER BY datefiled DESC, leavetype ';
        $stmt =$connL->prepare($query);
        $param = array(":emp_code" => $employee);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                echo '<tr>
                        <td>' . date('m-d-Y', strtotime($result['datefiled'])) . '</td>
                        <td>' . $result['leavetype'] . '</td>
                        <td>' . date('m-d-Y', strtotime($result['date_from'])) . '</td>
                        <td>' . date('m-d-Y', strtotime($result['date_to'])) . '</td>
                        <td>' . $result['leave_desc'] . '</td>
                        <td>' . $result['actl_cnt'] . '</td>
                        <td>' . $result['app_days'] . '</td>';
                
                switch((int)$result['approved'])
                {
                    case 1:
                        echo '<td><p class="text-warning">PENDING</p></td>';
                        break;
                    case 2:
                        echo '<td><p class="text-success">APPROVED</p></td>';
                        break;
                    case 3:
                        echo '<td><p class="text-danger">REJECTED</p></td>';
                        break;
                    case 4:
                        echo '<td><p class="text-danger">VOID</p></td>';
                        break;    
                    default:
                        break;
                }

                echo "<td>".$result['remarks']."</td>";

                switch((int)$result['approved'])
                {
                    case 1:
                        echo "<td colspan ='1'></td>";
                        break;
                    case 2:
                        echo '<td><button class="voidHstry btnVoid" id="'.$result['emp_code'].' '.$result['rowid'].'" type="submit"><i class="fas fa-ban"></i></button></td>';
                        break;
                    case 3:
                        echo "<td colspan ='1'></td>";
                        break;
                    case 4:
                        echo "<td colspan ='1'></td>";
                        break;    
                    default:
                        break;
                }
                
            } while ($result = $stmt->fetch());
            echo '</tr></tbody>';
        }else{
            echo '<tfoot><tr><td colspan="9" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
        
    }

    function VoidLeave($empCode,$creditleave,$leavetype,$remarks){
        global $connL;

        $empCode = explode(" ",$empCode);

        $balanceCount = GetBalanceCount($empCode[0],$leavetype);

        // echo $empCode[0]." : ".$creditleave." : ".$leavetype." : ".$balanceCount." : ".$remarks;

        UpdateLeaveCount($leavetype, $empCode[0], $balanceCount + $creditleave);

        $query = 'UPDATE tr_leave SET approved = 4, remarks = :remarks WHERE emp_code = :emp_code AND rowid = :rowid';
        $param = array(":rowid" => $empCode[1], ':emp_code'=> $empCode[0], ':remarks' => $remarks);
        $stmt =$connL->prepare($query);
        $result = $stmt->execute($param);
        
        return $result;

    }

    function GetNumberOfDays($dateTo,$dateFrom){
        $newDateTo = new DateTime($dateTo); 
        $newDateFrom = new DateTime($dateFrom);

        $diff = date_diff($newDateTo, $newDateFrom);

        $daysCount = $diff->format('%d') + 1;

        return $daysCount;
    }

    function GetInDates($rowArr){

        global $connL;
        
        $inDatesArr = array();

        foreach ($rowArr as $key => $value) {

            $query = 'SELECT inclusivedate FROM tr_leave WHERE rowid = :rowid';
            $param = array(":rowid" => $value);
            $stmt = $connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();

            $inDatesArr[] = $result['inclusivedate'];
        }

        return $inDatesArr;
    }

    function UpdateLeaves($rowid,$app_days, $dateFrom, $dateTo, $status, $remarks){
        
        global $connL;

        $query = 'UPDATE tr_leave SET approved = :status, app_days = :appdays, date_from = :datefrom, date_to = :dateto, remarks = :remarks WHERE rowid = :rowid';
        $param = array(":rowid" => $rowid, ':appdays'=> $app_days, ':datefrom' => $dateFrom, ':dateto' => $dateTo, ':status' => $status, ':remarks' => $remarks);
        $stmt =$connL->prepare($query);
        $result = $stmt->execute($param);
        
        return $result;
    }

    function UpdateLeaveCount($leavetype, $empid, $bal){
        
        // echo $leavetype.', '.$empid.', '.$bal;

        global $connL;

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave' || $leavetype === 'Emergency Leave'){
            $column = 'earned_vl = ';
        }elseif($leavetype === 'Sick Leave' ){
            $column = 'earned_sl = ';
        }

        if($bal === 10 ? $bal = 0 : $bal);

        $sql = 'UPDATE employee_leave SET '. $column . $bal .'  WHERE emp_code = :empcode';
        $stmt =$connL->prepare($sql);
        $param = array(":empcode"=> $empid);
        $stmt->execute($param);

    }

    function GetRows($series, $empname, $from, $to){

        global $connL;

        $query = 'SELECT rowid FROM employee_leave_list WHERE series = :series AND employee = :empname AND date_from = :datefrom AND date_to = :dateto';
        $param = array(':series' => $series, ':empname'=> $empname, ':datefrom'=> $from,':dateto'=> $to);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetch();

        $rowidArr = array();
    
            if($result){	
                do { 
                    $rowidArr[] = $result['rowid'];
                } while ($result = $stmt->fetch()); 	
            }
        return $rowidArr;
    }

    function GetActualCount($series, $empname, $from, $to){

        global $connL;

        $query = 'SELECT DISTINCT(actl_cnt) FROM tr_leave WHERE rowid = :rowid AND emp_code = :emp_code AND date_from = :datefrom AND date_to = :dateto';
        $param = array(':rowid' => $series, ':emp_code'=> $empname, ':datefrom'=> $from,':dateto'=> $to);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();
        return $result['actl_cnt'];
    }

    function GetBalanceCount($empcode,$leavetype){

        global $connL;

        $query = 'SELECT earned_vl, earned_sl FROM employee_leave WHERE emp_code = :emp_code';
        $param = array(":emp_code" => $empcode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetch();
        
        $earned_vl = (isset($result['earned_vl']) ? (float)$result['earned_vl'] : 0);
        $earned_sl = (isset($result['earned_sl']) ? (float)$result['earned_sl'] : 0);

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave' || $leavetype === 'Emergency Leave'){
            $balanceCount = $earned_vl;
        }elseif($leavetype === 'Sick Leave' ){
            $balanceCount = $earned_sl;
        }

        return $balanceCount;
    }

    function GetEmployeeCode($employeeName){

        global $connL;

        $query = 'SELECT DISTINCT(emp_code) FROM tr_leave WHERE employee = :empname';
        $param = array(':empname' => $employeeName);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        return $result['emp_code'];
    }

    function ApproveLeave($employee,$curApproved,$curDateFrom,$curDateTo,$curLeaveType,$rowid,$approver,$empcode){


        global $connL;

        $query = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :approver";
        $param = array(':approver' => $approver);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();
        $apprv_name = $result['fullname'];


        $querys = "INSERT INTO logs_leave (leave_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:leave_id,:emp_code,:emp_name,:remarks,:audituser,:auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":leave_id" => $rowid,
                    ":emp_code"=> $empcode,
                    ":emp_name"=> $apprv_name,
                    ":remarks" => 'Approved by '.$apprv_name,
                    ":audituser" => $approver,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;

            // exit();

        $employee = explode(" ",$employee);

        $balanceCount = GetBalanceCount($employee[0],$curLeaveType);
        $leaveCount = GetActualCount($employee[1], $employee[0], $curDateFrom, $curDateTo);

        if(floatval($leaveCount) === floatval($curApproved)){
            UpdateLeaves($employee[1], $curApproved, $curDateFrom, $curDateTo, 2,'');
        }else{
            $excess = $leaveCount - $curApproved;
            UpdateLeaves($employee[1], $curApproved, $curDateFrom, $curDateTo, 2,'');
            UpdateLeaveCount($curLeaveType, $employee[0], $balanceCount + $excess);
        }


      
    }

    function RejectLeave($employee,$curDateFrom,$curDateTo,$curLeaveType,$curRejected,$remarks,$rowid,$rejecter,$empcode){
        

        global $connL;

        $query = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :rejecter";
        $param = array(':rejecter' => $rejecter);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();
        $rjct_name = $result['fullname'];

        $query = "INSERT INTO logs_leave (leave_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:leave_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmt =$connL->prepare($query);
    
                $param = array(
                    ":leave_id" => $rowid,
                    ":emp_code"=> $empcode,
                    ":emp_name"=> $rjct_name,
                    ":remarks" => 'Rejected by '.$rjct_name,
                    ":audituser" => $rejecter,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

            // exit();

        $employee = explode(" ",$employee);

        $balanceCount = GetBalanceCount($employee[0],$curLeaveType);

        UpdateLeaves($employee[1], $curRejected, $curDateFrom, $curDateTo, 3,$remarks);

        UpdateLeaveCount($curLeaveType, $employee[0], $balanceCount + $curRejected);



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

        echo '
        <table id="approvedList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="8" class ="text-center">List of Approved Leaves</th>
            </tr>
            <tr>
                <th>Employee</th>
                <th>Date Filed</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Leave Type</th>
                <th>Approved Leave Count</th>
            </tr>
        </thead>
        <tbody>';

        $query = 'SELECT employee, datefiled, date_from, date_to, leavetype, app_days 
        FROM dbo.tr_leave WHERE emp_code = :emp_code and approved = 2';

        $param = array(':emp_code' => $employee);
        $stmt = $connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                echo '
                <tr>
                <td>' . $result['employee'] . '</td>
                <td>' . date('m-d-Y', strtotime($result['datefiled'])) . '</td>
                <td>' . date('m-d-Y', strtotime($result['date_from'])) . '</td>
                <td>' . date('m-d-Y', strtotime($result['date_to'])) . '</td>
                <td>' . $result['leavetype'] . '</td>
                <td>' . $result['app_days'] . '</td></tr>';

            } while ($result = $stmt->fetch());

            echo '</tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>';
    } 




    
        
?>