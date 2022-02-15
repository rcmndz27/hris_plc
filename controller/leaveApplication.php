<?php

Class LeaveApplication{

    private $employeeCode;
    private $employeeType;
    
    public function SetLeaveApplicationParams($employeeCode,$employeeType){
        $this->employeeCode = $employeeCode;
        $this->employeeType = $employeeType;
    }

    

    public function GetLeaveSummary(){
        // $sql = 'SELECT earned_vl, earned_sl, status FROM dbo.employee_leave WHERE emp_code = :emp_code';

        // $sql = 'SELECT balance_count.emp_code, earned_vl,earned_sl, used_vl,used_sl,pending_vl,pending_sl 
        //         FROM employee_leave balance_count LEFT JOIN employee_leave_count leave_count ON leave_count.emp_code = balance_count.emp_code
        //         WHERE balance_count.emp_code = :emp_code';

        global $connL;

        $query = "SELECT * FROM LeaveCount WHERE emp_code = :empCode";
        
                $stmt =$connL->prepare($query);
                $param = array(":empCode" => $this->employeeCode);
                $stmt->execute($param);
                $result = $stmt->fetch();

                $used_vl = (isset($result['used_vl']) ? $result['used_vl'] : 0);
                $used_sl = (isset($result['used_sl']) ? $result['used_sl'] : 0);
                $pending_vl = (isset($result['pending_vl']) ? $result['pending_vl'] : 0);
                $pending_sl = (isset($result['pending_sl']) ? $result['pending_sl'] : 0);
                $earned_vl = (isset($result['earned_vl']) ? $result['earned_vl'] : 0);
                $earned_sl = (isset($result['earned_sl']) ? $result['earned_sl'] : 0);

        echo '
        <table id="earnedLeave" class="table table-dark table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="11" class ="text-center">Earned Leaves as of '. date('F') .'</th>
                </tr>
                <tr>
                    <th colspan="4" class ="text-center ">Vacation Leave</th>
                    <th colspan="4" class ="text-center ">Sick Leave</th>
                    <th colspan="3" class ="text-center ">Banked Sick Leave</th>
                </tr>
               
                <tr>
                    <th class="text-center">Beginning</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Remaining</th>

                    <th class="text-center">Beginning</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Remaining</th>
                    
                    <th class="text-center">Beginning</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Remaining</th>
                    
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <td class="text-center ">10</td>
                    <td class="text-center ">'.$used_vl.'</td>
                    <td class="text-center ">'. $pending_vl.'</td>
                    <td class="text-center ">'.$earned_vl.'</td>
                    
                    <td class="text-center ">10</td>
                    <td class="text-center ">'.$used_sl.'</td>
                    <td class="text-center ">'. $pending_sl .'</td>
                    <td class="text-center ">'.$earned_sl.'</td>

                    <td class="text-center ">45</td>
                    <td class="text-center ">0</td>
                    <td class="text-center ">0</td>
                </tr>
            </tbody>
        </table>';
        
       
        
    }

    public function GetLeaveHistory(){
        global $connL;

        $ctHistory = $connL->prepare('SELECT COUNT(*) FROM dbo.mf_leave where emp_code = :empCode');
        $ctHistory->bindValue(':empCode', $this->employeeCode);
        $ctHistory->execute();

        echo '
        <table id="dtrList" class="table table-dark table-striped table-sm">
        <thead>
            <tr>
                <th colspan="7" class ="text-center">History</th>
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
            </tr>
        </thead>
        <tbody>';

      
        if ($ctHistory->fetchColumn() >= 1){

            $query = 'SELECT datefiled,remarks,leavetype,date_from,date_to, actl_cnt,  app_days,approved FROM dbo.mf_leave where emp_code = :emp ORDER BY datefiled DESC, leavetype ';
            $getHistory = $connL->prepare($query);
            $getHistory->bindValue(':emp', $this->employeeCode);
            $getHistory->execute();

            while($r = $getHistory->fetch(PDO::FETCH_ASSOC))
            {
                echo '<tr>
                        <td>' . date('m-d-Y', strtotime($r['datefiled'])) . '</td>
                        <td>' . $r['leavetype'] . '</td>
                        <td>' . date('m-d-Y', strtotime($r['date_from'])) . '</td>
                        <td>' . date('m-d-Y', strtotime($r['date_to'])) . '</td>
                        <td>' . $r['remarks'] . '</td>
                        <td>' . $r['actl_cnt'] . '</td>
                        <td>' . $r['app_days'] . '</td>
                        <td>';

                switch((int)$r['approved'])
                {
                    case 0:
                        echo '<p class="text-warning">PENDING</p>';
                        break;
                    case 1:
                        echo '<p class="text-success">APPROVED</p>';
                        break;
                    case -1:
                        echo '<p class="text-danger">REJECTED</p>';
                        break;
                    default:
                        break;
                }

                echo '</td></tr>';
            }
            echo '</tbody>';
        }
        else { 
            echo '<tfoot><tr><td colspan="7" class="text-center">NO LEAVE HISTORY!</td></tr></tfoot>'; 
        }

        echo '</table>';
    }

    public function GetNumberOfDays($dateFrom,$dateTo) {
        $newDateTo = new DateTime($dateTo); 
        $newDateFrom = new DateTime($dateFrom);
        $diff = date_diff($newDateFrom, $newDateTo);
        $daysCount = $diff->format('%R%a') + 1;
        return $daysCount;
    }

    public function Countdays($dateFrom,$dateTo){

        $count = $this->GetNumberOfDays($dateFrom,$dateTo);

        $inclusiveDate = new DateTime($dateFrom);

        $dateArr = array();

        for($x=0; $x < $count; $x++){
            if($x === 0){
                if($inclusiveDate->format('D') !== 'Sat' && $inclusiveDate->format('D') !== 'Sun'){
                    $dateArr[] = $inclusiveDate->format('Y-m-d');
                }
            }elseif($x > 0){
                $inclusiveDate->modify('+1 day');
                if($inclusiveDate->format('D') !== 'Sat' && $inclusiveDate->format('D') !== 'Sun'){
                    $dateArr[] = $inclusiveDate->format('Y-m-d');
                }
            }
        }

        foreach ($dateArr as $key => $value) {

            global $connL;

            $query = 'SELECT holidaydate FROM dbo.mf_holiday WHERE CONVERT(DATE, holidaydate) = :currDate';
            $param = array(":currDate" => $value);
            $stmt =$connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();

            if((isset($result['holidaydate']) ? date('Y-m-d',strtotime($result['holidaydate'])) : '1970-01-01') !== '1970-01-01'){
                unset($dateArr[array_search(date('Y-m-d',strtotime($result['holidaydate'])), $dateArr)]);
            }
        }
        echo count($dateArr);
    }

    public function GetBalanceCount($empId, $leavetype){

        global $connL;

        $count = 0;

        $query = 'SELECT earned_vl, earned_sl FROM employee_leave WHERE emp_code = :emp_code';
        $param = array(":emp_code" =>$empId);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);

        $result = $stmt->fetch();
        
        $earned_vl = (isset($result['earned_vl']) ? (float)$result['earned_vl'] : 0);
        $earned_sl = (isset($result['earned_sl']) ? (float)$result['earned_sl'] : 0);

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave'){
            $count = $earned_vl;
        }elseif($leavetype === 'Sick Leave' || $leavetype === 'Emergency Leave'){
            $count = $earned_sl;
        }

        return $count;
    }

    public function GetLeaveType(){

        global $connL;

        $query = 'SELECT earned_vl, earned_sl FROM employee_leave WHERE emp_code = :emp_code';
        $param = array(":emp_code" => $this->employeeCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        $earned_vl = (isset($result['earned_vl']) ? (float)$result['earned_vl'] : 0);
        $earned_sl = (isset($result['earned_sl']) ? (float)$result['earned_sl'] : 0);

        

        echo '
        <div class="form-row mb-2">    
            <div class="col-md-2">
                <label for="leaveType">Leave Type</label>
            </div>
            <div class="col-md-8">
                <select class="form-control" name="leaveType" id="leaveType" >';

                 if($this->employeeType === 'Probationary'){
                    echo '
                        <option value="Leave Without Pay">Leave Without Pay</option>
                        <option value="Maternity Leave">Maternity Leave</option>
                        <option value="Paternity Leave">Paternity Leave</option>
                        <option value="Solo Parent Leave">Solo Parent Leave</option>
                        <option value="Magna Carta Leave">Magna Carta Leave</option>
                        <option value="Special Leave for Women">Special Leave for Women</option>
                        <option value="Military Service Leave">Military Service Leave</option>
                        <option value="Special Leave for Victim of Violence">Special Leave for Victim of Violence</option>

                    ';    
                }elseif($this->employeeType === 'Project-Based'){
                        echo '<option value="Incentive Leave">Incentive Leave</option>';
                }else{

                    if(($earned_vl === 0) && ($earned_sl === 0)){
                        echo '
                            <option value="Leave Without Pay">Leave Without Pay</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Solo Parent Leave">Solo Parent Leave</option>
                            <option value="Magna Carta Leave">Magna Carta Leave</option>
                            <option value="Special Leave for Women">Special Leave for Women</option>
                            <option value="Military Service Leave">Military Service Leave</option>
                            <option value="Special Leave for Victim of Violence">Special Leave for Victim of Violence</option>
                        ';  
                    }elseif(($earned_vl !== 0) && ($earned_sl === 0)){
                        echo '
                            <option value="Leave Without Pay">Leave Without Pay</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Solo Parent Leave">Solo Parent Leave</option>
                            <option value="Magna Carta Leave">Magna Carta Leave</option>
                            <option value="Vacation Leave">Vacation Leave</option>
                            <option value="Bereavement Leave">Bereavement Leave</option>
                            <option value="Special Leave for Women">Special Leave for Women</option>
                            <option value="Military Service Leave">Military Service Leave</option>
                            <option value="Special Leave for Victim of Violence">Special Leave for Victim of Violence</option>
                        ';
                    }elseif(($earned_vl === 0) && ($earned_sl !== 0)){
                        echo '
                            <option value="Leave Without Pay">Leave Without Pay</option>
                            <option value="Maternity Leave">Maternity Leave</option>
                            <option value="Paternity Leave">Paternity Leave</option>
                            <option value="Solo Parent Leave">Solo Parent Leave</option>
                            <option value="Magna Carta Leave">Magna Carta Leave</option>
                            <option value="Sick Leave">Sick Leave</option>
                            <option value="Emergency Leave">Emergency Leave</option>
                            <option value="Special Leave for Women">Special Leave for Women</option>
                            <option value="Military Service Leave">Military Service Leave</option>
                            <option value="Special Leave for Victim of Violence">Special Leave for Victim of Violence</option>
                        ';   
                    }else{

                        $cmd = $connL->prepare(@'SELECT leavetype FROM dbo.mf_leavetype');
                        $cmd->execute();

                        while ($r = $cmd->fetch(PDO::FETCH_ASSOC))
                        {
                            echo '<option value="'.$r['leavetype'].'">'.$r['leavetype'].'</option>';
                        }
                    }

                }
        echo '
                </select>
            </div>
        </div>';
    }

    public function GetDates($dateFrom,$dateTo){

        $count = $this->GetNumberOfDays($dateFrom,$dateTo);

        $inclusiveDate = new DateTime($dateFrom);

        $dateArr = array();

        for($x=0; $x < $count; $x++){
            if($x === 0){
                if($inclusiveDate->format('D') !== 'Sat' && $inclusiveDate->format('D') !== 'Sun'){
                    $dateArr[] = $inclusiveDate->format('Y-m-d');
                }
            }elseif($x > 0){
                $inclusiveDate->modify('+1 day');
                if($inclusiveDate->format('D') !== 'Sat' && $inclusiveDate->format('D') !== 'Sun'){
                    $dateArr[] = $inclusiveDate->format('Y-m-d');
                }
            }
        }

        foreach ($dateArr as $key => $value) {

            global $connL;

            $query = 'SELECT holidaydate FROM dbo.mf_holiday WHERE CONVERT(DATE, holidaydate) = :currDate';
            $param = array(":currDate" => $value);
            $stmt =$connL->prepare($query);
            $stmt->execute($param);
            $result = $stmt->fetch();

            if((isset($result['holidaydate']) ? date('Y-m-d',strtotime($result['holidaydate'])) : '1970-01-01') !== '1970-01-01'){
                unset($dateArr[array_search(date('Y-m-d',strtotime($result['holidaydate'])), $dateArr)]);
            }
        }
        
        // print_r($dateArr);

        return $dateArr;
    }

    public function UpdateLeaveCount($empId, $leavetype, $bal){
        
        global $connL;

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave'){
            $column = 'earned_vl = ';
        }elseif($leavetype === 'Sick Leave' || $leavetype === 'Emergency Leave'){
            $column = 'earned_sl = ';
        }

        if($bal === 10 ? $bal = 0 : $bal);

        $query = " UPDATE employee_leave SET ". $column . $bal ."  WHERE emp_code = :empcode ";
        $stmt =$connL->prepare($query);
        $param = array(":empcode"=> $empId);
        $stmt->execute($param);
    }

    public function InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $leaveCount){

        global $connL;

            $query = " INSERT INTO mf_leave (emp_code, employee, department, approval, datefiled, leavetype, medicalfile, date_from, date_to, remarks, actl_cnt, app_days, approved, audituser, auditdate ) 
                VALUES(:emp_code, :employee, :department, :approval, :datefiled, :leavetype, :medicalfile, :date_from, :date_to, :remarks,  :actl_cnt, :app_days, :approved, :audituser, :auditdate) ";
    
                $stmt =$connL->prepare($query);
    
                $param = array(
                    ":emp_code"=> $empCode,
                    ":employee" => $empName,
                    ":department" => $empDept,
                    ":approval"=> $empReportingTo,
                    ":datefiled"=> date('m-d-Y'),
                    ":leavetype"=> $leaveType,
                    ":medicalfile"=> $medicalFile,
                    ":date_from"=> $dateStart,
                    ":date_to"=> $dateEnd,
                    ":remarks"=> $leaveDesc,
                    ":actl_cnt"=> $leaveCount,
                    ":app_days"=> 0,
                    ":approved"=> 0,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

        // $em = $connL->prepare(@"exec dbo.sp_autoemail_leave :emp, :type, :dt");
        // $em->bindValue(':emp', $empID);
        // $em->bindValue(':type', $leaveType);
        // $em->bindValue(':dt', $inclusivedates);
        // $em->execute();
    }

    public function InsertExcessAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $excess){
        global $connL;

            $query = " INSERT INTO mf_leave (emp_code, employee, department, approval, datefiled, leavetype, medicalfile, date_from, date_to, remarks, actl_cnt, app_days, approved, audituser, auditdate ) 
                VALUES(:emp_code, :employee, :department, :approval, :datefiled, :leavetype, :medicalfile, :date_from, :date_to, :remarks,  :actl_cnt, :app_days, :approved, :audituser, :auditdate) ";
    
                $stmt =$connL->prepare($query);
    
                $param = array(
                    ":emp_code"=> $empCode,
                    ":employee" => $empName,
                    ":department" => $empDept,
                    ":approval"=> $empReportingTo,
                    ":datefiled"=> date('m-d-Y'),
                    ":leavetype"=> 'Leave Without Pay',
                    ":medicalfile"=> $medicalFile,
                    ":date_from"=> $dateStart,
                    ":date_to"=> $dateEnd,
                    ":remarks"=> $leaveDesc,
                    ":actl_cnt"=> $excess,
                    ":app_days"=> 0,
                    ":approved"=> 0,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;
    }

    public function ApplyLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $dateFrom, $dateTo, $leaveDesc, $medicalFile, $leaveCount, $allhalfdayMark){

        $leaveCount = ($dateFrom === $dateTo && $leaveCount === 0) ? 1 : $leaveCount;

        $allowedDays = 0;

        $inDates = array();

        $inDates = $this->GetDates($dateFrom, $dateTo);

        $excessDateArr = array();

        if($leaveType === "Vacation Leave" || $leaveType === "Bereavement Leave" || $leaveType === "Sick Leave" || $leaveType === "Emergency Leave"){

            $balanceCount = $this->GetBalanceCount($empCode, $leaveType);

            if($balanceCount >= $leaveCount){

                // echo 'Count : '.$leaveCount.' : ';
                // print_r($inDates);

                $dateStart = date('Y-m-d',strtotime(reset($inDates)));
                $dateEnd = date('Y-m-d',strtotime(end($inDates)));

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $leaveCount);
                $this->UpdateLeaveCount($empCode, $leaveType, $balanceCount - $leaveCount);

            }elseif($balanceCount < $leaveCount){

                $excess = $leaveCount - $balanceCount;

                print('Day Count : '.count($inDates).' , Leave Count : '.$leaveCount.' , Excess : '.$excess.' : BalanceCount : '.$balanceCount);
                print_r($inDates);

                $balanceDatesArr = array_splice($inDates, 0, round($balanceCount) * $allhalfdayMark);
                $dateStart = date('Y-m-d',strtotime(reset($balanceDatesArr)));
                $dateEnd = date('Y-m-d',strtotime(end($balanceDatesArr)));

                print_r($balanceDatesArr);

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $balanceCount);
                $this->UpdateLeaveCount($empCode, $leaveType, $balanceCount - $balanceCount);

                $excessDateArr = array_splice($inDates, 0, round($excess) * $allhalfdayMark);
                $dateStart = date('Y-m-d',strtotime(reset($excessDateArr)));
                $dateEnd = date('Y-m-d',strtotime(end($excessDateArr)));

                print_r($excessDateArr);

                $this->InsertExcessAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $excess);

            }

        }elseif($leaveType === "Leave Without Pay"){

            // print_r($inDates);

            $dateStart = date('Y-m-d',strtotime(reset($inDates)));
            $dateEnd = date('Y-m-d',strtotime(end($inDates)));

            // echo "LWP : ". $leaveCount;

            $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $leaveCount);

        }else{

            // echo $leaveType;

            switch($leaveType){
                case 'Maternity Leave':
                    $allowedDays = 105;
                break;
                case 'Paternity Leave':
                    $allowedDays = 7;
                break;
                case 'Solo Parent Leave':
                    $allowedDays = 7;
                break;
                case 'Magna Carta Leave':
                $allowedDays = 60;
                break;
            }

            if($allowedDays >= $leaveCount){

                // echo 'A';

                // print_r($inDates);
    
                $dateStart = date('Y-m-d',strtotime(reset($inDates)));
                $dateEnd = date('Y-m-d',strtotime(end($inDates)));
    
                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $leaveCount);
    
            }else{

                // echo 'B';

                $excess = $leaveCount - $allowedDays;

                $inDates = $this->GetDates($dateFrom, $dateTo);

                // print('Day Count : '.count($inDates).' , Leave Count : '.$leaveCount.' , Excess : '.$excess.' ; ');
                // print_r($inDates);

                $balanceDatesArr = array_splice($inDates, 0, round($allowedDays) * $allhalfdayMark);
                $dateStart = date('Y-m-d',strtotime(reset($balanceDatesArr)));
                $dateEnd = date('Y-m-d',strtotime(end($balanceDatesArr)));

                // print_r($balanceDatesArr);

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $allowedDays);

                $excessDateArr = array_splice($inDates, 0, round($excess) * $allhalfdayMark);
                $dateStart = date('Y-m-d',strtotime(reset($excessDateArr)));
                $dateEnd = date('Y-m-d',strtotime(end($excessDateArr)));

                // print_r($excessDateArr);

                $this->InsertExcessAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $medicalFile, $dateStart, $dateEnd, $leaveDesc, $excess);

            }
        }

    }

}


?>