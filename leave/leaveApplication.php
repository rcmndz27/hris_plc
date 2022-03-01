<?php

Class LeaveApplication{

    private $employeeCode;
    private $employeeType;
    
    public function SetLeaveApplicationParams($employeeCode,$employeeType){
        $this->employeeCode = $employeeCode;
        $this->employeeType = $employeeType;
    }

    public function GetLeaveSummary(){
        global $connL;

        $query = "SELECT * FROM LeaveCount WHERE emp_code = :empCode";
        
                $stmt =$connL->prepare($query);
                $param = array(":empCode" => $this->employeeCode);
                $stmt->execute($param);
                $result = $stmt->fetch();

                $used_vl = (isset($result['used_vl']) ? round(10.00,1) - $result['earned_vl']: 0);
                $used_sl = (isset($result['used_sl']) ? round(10.00,1) - round($result['earned_sl'],1): 0);
                $pending_vl = (isset($result['pending_vl']) ? $result['pending_vl'] : 0);
                $pending_sl = (isset($result['pending_sl']) ? $result['pending_sl'] : 0);
                $earned_vl = (isset($result['earned_vl']) ? round($result['earned_vl'],2) : 0);
                $earned_sl = (isset($result['earned_sl']) ? round($result['earned_sl'],2) : 0);

        echo '
        <table id="earnedLeave" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="8" class ="text-center">Earned Leaves as of '. date('F') .'</th>
                </tr>
                <tr>
                    <th colspan="4" class ="text-center ">Vacation Leave</th>
                    <th colspan="4" class ="text-center ">Sick Leave</th>
                </tr>
               
                <tr>
                    <th class="text-center">Earned Leave</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Remaining</th>

                    <th class="text-center">Earned Leave</th>
                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Remaining</th>
        
                    
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <td class="text-center ">10.0</td>
                    <td class="text-center ">'.$used_vl.'</td>
                    <td class="text-center ">'. $pending_vl.'</td>
                    <td class="text-center ">'.$earned_vl.'</td>
                    
                    <td class="text-center ">10.0</td>
                    <td class="text-center ">'.$used_sl.'</td>
                    <td class="text-center ">'. $pending_sl .'</td>
                    <td class="text-center ">'.$earned_sl.'</td>
                </tr>
            </tbody>
        </table>';
        
       
        
    }

    public function GetLeaveHistory(){
        
        global $connL;

        echo '
        <table id="dtrList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th colspan="10" class ="text-center">History of Leave</th>
            </tr>
            <tr>
                <th>Date Filed</th>
                <th>Leave Type</th>
                <th>Date From</th>
                <th>Date To</th>
                <th>Description</th>
                <th>Leave Count</th>
                <th>Approved (Days)</th>
                <th>Remarks</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT rowid,datefiled,leave_desc,leavetype,date_from,date_to, actl_cnt,remarks,app_days,
                    (CASE when approved = 1 then 'PENDING'
                    when   approved = 2 then 'APPROVED'
                    when   approved = 3 then 'REJECTED'
                    when   approved = 4 then 'VOID' ELSE 'N/A' END) as approved FROM dbo.tr_leave where emp_code = :emp_code ORDER BY datefiled DESC, leavetype";
        $param = array(':emp_code' => $this->employeeCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 

                $datefl = "'".date('m-d-Y', strtotime($result['datefiled']))."'";
                $leavedesc = "'".$result['leave_desc']."'";
                $leavetyp = "'".$result['leavetype']."'";
                $datefr = "'".date('m-d-Y', strtotime($result['date_from']))."'";
                $dateto = "'".date('m-d-Y', strtotime($result['date_to']))."'";
                $remark = "'".(isset($result['remarks']) ? $result['remarks'] : 'n/a')."'";
                $appdays = "'".$result['app_days']."'";
                $appr_oved = "'".$result['approved']."'";
                $actlcnt = "'".$result['actl_cnt']."'";
                $leaveid = "'".$result['rowid']."'";
                echo '
                <tr>
                <td>' . date('m-d-Y', strtotime($result['datefiled'])) . '</td>
                <td>' . $result['leavetype'] . '</td>
                <td>' . date('m-d-Y', strtotime($result['date_from'])) . '</td>
                <td>' . date('m-d-Y', strtotime($result['date_to'])) . '</td>
                <td>' . $result['leave_desc'] . '</td>
                <td>' . $result['actl_cnt'] . '</td>
                <td>' . $result['app_days'] . '</td>
                <td>' . $result['remarks'] . '</td>
                <td>' . $result['approved'] . '</td>
                <td><button type="button" class="hactv" onclick="viewLeaveModal('.$datefl.','.$leavedesc.','.$leavetyp.','.$datefr.','.$dateto.','.$remark.','.$appdays.','.$appr_oved.','.$actlcnt.')" title="View Leave">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewLeaveHistoryModal('.$leaveid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>
                            </td>';

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="10" class="text-center">No Results Found</td></tr></tfoot>'; 
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

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave' || $leavetype === 'Emergency Leave'){
            $count = $earned_vl;
        }elseif($leavetype === 'Sick Leave'){
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
                <label for="leaveType">Leave Type:</label>
            </div>
            <div class="col-md-5">
                <select class="form-select" name="leaveType" id="leaveType" >';

                if($this->employeeType === 'Probationary'){
                    echo '
                        <option value="Vacation Leave">Vacation Leave</option>
                        <option value="Sick Leave">Sick Leave</option>
                        <option value="Maternity Leave">Maternity Leave</option>
                        <option value="Paternity Leave">Paternity Leave</option>
                        <option value="Solo Parent Leave">Solo Parent Leave</option>
                        <option value="Magna Carta Leave">Magna Carta Leave</option>
                        <option value="Special Leave for Women">Special Leave for Women</option>
                        <option value="Military Service Leave">Military Service Leave</option>
                        <option value="Special Leave for Victim of Violence">Special Leave for Victim of Violence</option>

                    ';    
                }else if($this->employeeType === 'Project Based'){
                        echo '<option value="Incentive Leave">Incentive Leave</option>';
                }else{

                    if(($earned_vl === 0) && ($earned_sl === 0)){
                        echo '
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

        if($leavetype === 'Vacation Leave' || $leavetype === 'Bereavement Leave' || $leavetype === 'Emergency Leave'){
            $column = 'earned_vl = ';
        }elseif($leavetype === 'Sick Leave' ){
            $column = 'earned_sl = ';
        }

        if($bal === 10 ? $bal = 0 : $bal);

        $query = " UPDATE employee_leave SET ". $column . $bal ."  WHERE emp_code = :empcode ";
        $stmt =$connL->prepare($query);
        $param = array(":empcode"=> $empId);
        $stmt->execute($param);
    }

    public function InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity,$dateStart, $dateEnd, 
        $leaveDesc, $leaveCount){

        global $connL;

            $query = "INSERT INTO tr_leave (emp_code, employee, department, approval, datefiled, leavetype, medicalfile,date_birth,dateStartMaternity,date_from, date_to, leave_desc, actl_cnt, app_days, approved, audituser, auditdate ) 
                VALUES(:emp_code, :employee, :department, :approval, :datefiled, :leavetype, :medicalfile,:date_birth,:dateStartMaternity,:date_from, :date_to, :leave_desc,  :actl_cnt, :app_days, :approved, :audituser, :auditdate) ";
    
                $stmt =$connL->prepare($query);
    
                $param = array(
                    ":emp_code"=> $empCode,
                    ":employee" => $empName,
                    ":department" => $empDept,
                    ":approval"=> $empReportingTo,
                    ":datefiled"=> date('m-d-Y'),
                    ":leavetype"=> $leaveType,
                    ":medicalfile"=> $medicalFile,
                    ":date_birth"=> $dateBirth,
                    ":dateStartMaternity"=> $dateStartMaternity,
                    ":date_from"=> $dateStart,
                    ":date_to"=> $dateEnd,
                    ":leave_desc"=> $leaveDesc,
                    ":actl_cnt"=> $leaveCount,
                    ":app_days"=> 0,
                    ":approved"=> 1,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

            $qry = 'SELECT max(rowid) as maxid FROM tr_leave WHERE emp_code = :emp_code';
            $prm = array(":emp_code" => $empCode);
            $stm =$connL->prepare($qry);
            $stm->execute($prm);
            $rst = $stm->fetch();

            $querys = "INSERT INTO logs_leave (leave_id,emp_code,remarks,audituser,auditdate) 
                VALUES(:leave_id, :emp_code, :remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":leave_id" => $rst['maxid'],
                    ":emp_code"=> $empCode,
                    ":remarks" => 'Apply '.$leaveType,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;

    }

    public function InsertExcessAppliedLeave($empCode, $empName, $empDept, $empReportingTo,$medicalFile,$dateBirth, $dateStart,$dateStartMaternity, $dateEnd, $leaveDesc, $excess){

        global $connL;

            $query = " INSERT INTO tr_leave (emp_code, employee, department, approval, datefiled, leavetype, medicalfile,date_birth,dateStartMaternity,date_from, date_to, leave_desc, actl_cnt, app_days, approved, audituser, auditdate ) 
                VALUES(:emp_code, :employee, :department, :approval, :datefiled, :leavetype, :medicalfile,:date_birth,:date_from,:dateStartMaternity, :date_to, :leave_desc,  :actl_cnt, :app_days, :approved, :audituser, :auditdate) ";
    
                $stmt =$connL->prepare($query);
    
                $param = array(
                    ":emp_code"=> $empCode,
                    ":employee" => $empName,
                    ":department" => $empDept,
                    ":approval"=> $empReportingTo,
                    ":datefiled"=> date('m-d-Y'),
                    ":leavetype"=> 'Leave Without Pay',
                    ":medicalfile"=> $medicalFile,
                    ":dateStartMaternity"=> $dateStartMaternity,
                    ":date_birth"=> $dateBirth,
                    ":date_from"=> $dateStart,
                    ":date_to"=> $dateEnd,
                    ":leave_desc"=> $leaveDesc,
                    ":actl_cnt"=> $excess,
                    ":app_days"=> 0,
                    ":approved"=> 1,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

            $qry = 'SELECT max(rowid) as maxid FROM tr_leave WHERE emp_code = :emp_code';
            $prm = array(":emp_code" => $empCode);
            $stm =$connL->prepare($qry);
            $stm->execute($prm);
            $rst = $stm->fetch();

            $querys = "INSERT INTO logs_leave (leave_id,emp_code,remarks,audituser,auditdate) 
                VALUES(:leave_id, :emp_code, :remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":leave_id" => $rst['maxid'],
                    ":emp_code"=> $empCode,
                    ":remarks" => 'Apply '.$leaveType,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

            echo $results;
    }

    public function ApplyLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType,$dateBirth,$dateStartMaternity,$dateFrom, $dateTo, $leaveDesc, 
        $medicalFile, $leaveCount, $allhalfdayMark){

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
               

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType,$medicalFile,$dateBirth,$dateStartMaternity, $dateStart, $dateEnd, $leaveDesc, $leaveCount);
                $this->UpdateLeaveCount($empCode, $leaveType, $balanceCount - $leaveCount);

            }elseif($balanceCount < $leaveCount){

                $excess = $leaveCount - $balanceCount;

                print('Day Count : '.count($inDates).' , Leave Count : '.$leaveCount.' , Excess : '.$excess.' : BalanceCount : '.$balanceCount);
                print_r($inDates);

                $balanceDatesArr = array_splice($inDates, 0, round($balanceCount) * $allhalfdayMark);
                $dateStart = date('Y-m-d',strtotime(reset($balanceDatesArr)));
                $dateEnd = date('Y-m-d',strtotime(end($balanceDatesArr)));

                print_r($balanceDatesArr);

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity, $dateStart, $dateEnd, $leaveDesc, $balanceCount);
                $this->UpdateLeaveCount($empCode, $leaveType, $balanceCount - $balanceCount);


                $excessDateArr = array_splice($inDates, 0, round($excess) * $allhalfdayMark);
                $dateStart = date('Y-m-d',strtotime(reset($excessDateArr)));
                $dateEnd = date('Y-m-d',strtotime(end($excessDateArr)));

                print_r($excessDateArr);

                $this->InsertExcessAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $medicalFile,$dateBirth,$dateStartMaternity,$dateStart, $dateEnd, $leaveDesc, $excess);

            }
           

        }else if($leaveType === "Sick Leave without Pay" || $leaveType === "Vacation Leave without Pay" ){

            // print_r($inDates);

            $dateStart = date('Y-m-d',strtotime(reset($inDates)));
            $dateEnd = date('Y-m-d',strtotime(end($inDates)));

            // echo "LWP : ". $leaveCount;

            $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity,$dateStart, $dateEnd, $leaveDesc, $leaveCount);

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
                case 'Incentive Leave':
                    $allowedDays = 5;
                break;
            }

            if($allowedDays >= $leaveCount){


                $dateStart = date('Y-m-d',strtotime(reset($inDates)));
                $dateEnd = date('Y-m-d',strtotime(end($inDates)));
    
                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,
                    $dateStartMaternity,$dateFrom, $dateEnd, $leaveDesc, $leaveCount);
    
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

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity,$dateStart, $dateEnd, $leaveDesc, $allowedDays);

                $excessDateArr = array_splice($inDates, 0, round($excess) * $allhalfdayMark);
                $dateStart = date('Y-m-d',strtotime(reset($excessDateArr)));
                $dateEnd = date('Y-m-d',strtotime(end($excessDateArr)));

                // print_r($excessDateArr);

                $this->InsertExcessAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $medicalFile,$dateBirth,$dateStartMaternity,$dateStart, $dateEnd, $leaveDesc, $excess);

            }
        }

    }

   

}


?>