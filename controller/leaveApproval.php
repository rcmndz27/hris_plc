<?php

    function EmployeeList($empID)
    {

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

    function LeaveList()
    {

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
    
    function ShowAllLeave($employee)
    {
        global $connL;

        $query = 'SELECT DISTINCT(datefiled), employee, department, leavetype, datefiled, date_from, date_to, remarks, actl_cnt, app_days, approved, series as rowid 
                    FROM employee_leave_list WHERE approved = 0 AND emp_code =:empCode';
        $param = array(':empCode' => $employee);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        echo '<table id="employeeLeaveList" class="table table-dark table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="7" class="text-center">List of Pending Leave Request</th>';
                // if ($result['approved'] == 1)
                // {
                //     echo '<th colspan="6" class="text-center">'.$result['leavetype'].'</th>';
                // }
                // else if ($result['approved'] == -1)
                // {
                //     echo '<th colspan="6" class="text-center text-warning">'.$result['leavetype'].'</th>';
                // }
                // else {
                //     echo '<th colspan="6" class="text-center text-info">'.$result['leavetype'].'</th>';
                // }
        echo '</tr>
                <tr>
                    <th>Date Filed</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Leave Type</th>
                    <th>Remarks</th>
                    <th class="text-center">Approved Days</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';

        if($result){

			do { 
                echo "
                <tr>
                    <td>" . date('Y-m-d',strtotime($result['datefiled'])) . "</td>
                    <td>" . date('Y-m-d',strtotime($result['date_from'])) . "</td>
                    <td>" . date('Y-m-d',strtotime($result['date_to'])) . "</td>
                    <td class='text-left text-info'>" . $result['leavetype'] . "</td>
                    <td>" . $result['remarks'] . "</td>";

                if ($result['approved'] == 1)
                {
                    echo '<td class="text-center">' . $result['actl_cnt'] . '</td>'.
                    '<td class="align-middle"><p class="text-success align-middle">APPROVED</p></td>';
                }
                else if ($result['approved'] == -1)
                {
                    echo '<td class="text-center">' . $result['actl_cnt'] . '</td>'.
                    '<td class="align-middle"><p class="text-warning">REJECTED</p></td>';
                }
                else
                {
                    echo '
                        <td><input type="number" id="' . $result['rowid'] . '-app" class="form-control text-center" value="'. $result['actl_cnt'] .'"></td>
                        <td>';

                        if($result['leavetype'] !=='Sick Leave'){
                            echo'
                                <button class="btnApprove" id="'.$result['rowid'] .'-approve"><i class="fas fa-check"></i></button>
                                <button class="btnReject" id="'. $result['rowid'] . '-reject"><i class="fas fa-times"></i></button>';
                        }else{
                            echo'
                                <button class="btnView" id="'. $result['rowid'] . '-reject"><i class="fas fa-search"></i></button>    
                                <button class="btnApprove" id="'.$result['rowid'] .'-approve"><i class="fas fa-check"></i></button>
                                <button class="btnReject" id="'. $result['rowid'] . '-reject"><i class="fas fa-times"></i></button>';

                        }

                    echo '</td>';    
                }
                
                echo "</tr>";
            } while ($result = $stmt->fetch());

        }else{
            echo '<tr><td colspan="9" class="text-center">There is nothing to view.</td></tr>';
        }

        echo "</tbody></table>";

    }

    function ViewLeaveSummaryList($employee)
    {
        global $connL;

        // switch($type){

        //     case '0':
        //         $clause = ' WHERE leave.approval = :empcode ';
        //     break;
        //     case '1':
        //         $clause = ' WHERE leave.emp_code = :empcode AND leavetype = :leavetype ';
        //     break;
        //     case '2':
        //         $clause = ' WHERE leave.approval = :empcode AND leavetype = :leavetype ';
        //     break;
        //     case '3': 
        //         $clause = '  WHERE leave.emp_code = :empcode ';
        //     break;

        // }

        // $query = 'SELECT leave.emp_code, employee, leavetype, approved, leavebegbal, 
        // CASE approved WHEN 1 THEN SUM(app_days) ELSE 0 END AS used, CASE approved WHEN 0 THEN SUM(app_days)ELSE 0 END AS pending,
        // [sick leave] AS balsl, [vacation leave] AS balvl
        // FROM employee_leave_summary AS leave
        // LEFT JOIN employee_leave AS leave_bal ON leave.emp_code = leave_bal.emp_code'.$clause
        // .'GROUP BY leave.emp_code, employee, leavetype, approved, leavebegbal, [sick leave],[vacation leave]
        // ORDER BY employee, approved, leavetype';

        // if($type === '0' || $type === '3'){
        //     $param = array(':empcode' => $employee);
        // }else{
        //     $param = array(':empcode' => $employee, ':leavetype' => $leavetype);
        // }

        // $query = 'SELECT emp_code, employee, leavebegbal, used, pending,  balsl, balvl FROM employee_leave_summary WHERE reporting_to = :empcode ORDER BY employee';

        

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

        echo '<table id="leaveSummaryList" class="table table-dark table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="4"></th>
                    <th colspan="2" class="text-center">Balance</th>
                </tr>
                <tr>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Beginning</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Sick Leave</th>
                    <th class="text-center">Vaction Leave</th>
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
                    '<td class="text-center">'. $begbal .'</td>'.
                    '<td class="text-center">'.$used .'</td>'.
                    '<td><button class="btn btn-primary form-control btnPending" id="'.$result['emp_code'].'" type="submit">'. $totalPending .'</button></td>',
                    '<td class="text-center">'. $earned_sl .'</td>'.
                    '<td class="text-center">'. $earned_vl .'</td>'.
                '</tr>';
                
            } while ($result = $stmt->fetch());

            echo '</tbody><tfoot>';

        }else{
            echo '<tr><td colspan="9" class="text-center">There is nothing to view.</td></tr>';
        }

        echo "</tfoot></table>";

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

            $query = 'SELECT inclusivedate FROM mf_leave WHERE rowid = :rowid';
            $param = array(":rowid" => $value);
            $stmt = $connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();

            $inDatesArr[] = $result['inclusivedate'];
        }

        return $inDatesArr;
    }

    function UpdateLeaves($rowid,$app_days, $dateFrom, $dateTo, $status){
        
        global $connL;

        $query = 'UPDATE mf_leave SET approved = :status, app_days = :appdays, date_from = :datefrom, date_to = :dateto WHERE rowid = :rowid';
        $param = array(":rowid" => $rowid, ':appdays'=> $app_days, ':datefrom' => $dateFrom, ':dateto' => $dateTo, ':status' => $status);
        $stmt =$connL->prepare($query);
        $result = $stmt->execute($param);
        
        return $result;
    }

    function UpdateLeaveCount($leavetype, $empid, $bal){
        
        // echo $leavetype.', '.$empid.', '.$bal;

        global $connL;

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave'){
            $column = 'earned_vl = ';
        }elseif($leavetype === 'Sick Leave' || $leavetype === 'Emergency Leave'){
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

        $query = 'SELECT DISTINCT(actl_cnt) FROM employee_leave_list WHERE series = :series AND employee = :empname AND date_from = :datefrom AND date_to = :dateto';
        $param = array(':series' => $series, ':empname'=> $empname, ':datefrom'=> $from,':dateto'=> $to);
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

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave'){
            $balanceCount = $earned_vl;
        }elseif($leavetype === 'Sick Leave' || $leavetype === 'Emergency Leave'){
            $balanceCount = $earned_sl;
        }

        return $balanceCount;
    }

    
    function GetEmployeeCode($employeeName){

        global $connL;

        $query = 'SELECT DISTINCT(emp_code) FROM mf_leave WHERE employee = :empname';
        $param = array(':empname' => $employeeName);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        return $result['emp_code'];
    }

    function ApproveLeave($thisID, $app_days, $noOfDays, $dateFrom, $dateTo, $leaveType, $empName)
    {
        echo $thisID.', '.$app_days.', '.$noOfDays.', '.$dateFrom.', '.$dateTo.', '.$leaveType.', '.$empName;

        $empCode = GetEmployeeCode($empName);

        $balanceCount = GetBalanceCount($empCode,$leaveType);

        $rowid = GetRows($thisID, $empName, $dateFrom, $dateTo);

        $leaveCount = GetActualCount($thisID, $empName, $dateFrom, $dateTo);

        if($leaveCount === $app_days){

            UpdateLeaves(implode(" ",$rowid), $app_days, $dateFrom, $dateTo, 1);

        }else{

            $balanceCount = GetBalanceCount($empCode,$leaveType);

            $excess = $leaveCount - $app_days;

            UpdateLeaves(implode(" ",$rowid), $app_days, $dateFrom, $dateTo, 1);
            UpdateLeaveCount($leaveType, $empCode, $balanceCount + $excess);
        }


    }

    function RejectLeave($thisID, $leaveType, $app_days, $noOfDays, $dateFrom, $dateTo, $empName)
    {

        $empCode = GetEmployeeCode($empName);

        $balanceCount = GetBalanceCount($empCode,$leaveType);

        $rowid = GetRows($thisID, $empName, $dateFrom, $dateTo);

        UpdateLeaves(implode(" ",$rowid), $app_days, $dateFrom, $dateTo, -1);
        UpdateLeaveCount($leaveType, $empCode, $balanceCount + $app_days);

    }
?>