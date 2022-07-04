<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

Class LeaveApplication{

    private $employeeCode;
    private $employeeType;
    
    public function SetLeaveApplicationParams($employeeCode,$employeeType){
        $this->employeeCode = $employeeCode;
        $this->employeeType = $employeeType;
    }

    public function GetLeaveSummary(){
        global $connL;

        $query = "SELECT b.used_sl,b.used_vl,b.pending_sl,b.pending_vl,a.earned_sl,a.earned_vl FROM employee_leave a left join LeaveCount b on a.emp_code = b.emp_code  where a.emp_code =:empCode";
        
                $stmt =$connL->prepare($query);
                $param = array(":empCode" => $this->employeeCode);
                $stmt->execute($param);
                $result = $stmt->fetch();  

                $used_vl = (isset($result['earned_vl']) ? round(10.00,1) - round($result['earned_vl'],1) : 0);
                $used_sl = (isset($result['earned_sl']) ? round(10.00,1) - round($result['earned_sl'],1) : 0);
                $pending_vl = (isset($result['pending_vl']) ? $result['pending_vl'] : 0);
                $pending_sl = (isset($result['pending_sl']) ? $result['pending_sl'] : 0);
                $earned_vl = (isset($result['earned_vl']) ? round($result['earned_vl'],2) : 0);
                $earned_sl = (isset($result['earned_sl']) ? round($result['earned_sl'],2) : 0);

        echo '
        <table id="earnedLeave" class="table table-striped table-sm">
            <thead>
                <tr>
                    <th colspan="8" class ="text-center">Earned Leaves as of '. date('F Y') .'</th>
                </tr>
                <tr>
                    <th colspan="3" class ="text-center ">Vacation Leave</th>
                    <th colspan="3" class ="text-center ">Sick Leave</th>
                </tr>
               
                <tr>

                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Balance</th>

                    <th class="text-center">Used</th>
                    <th class="text-center">Pending</th>
                    <th class="text-center">Balance</th>
        
                    
                </tr>
                
            </thead>
            <tbody>
                <tr>
                    <td class="text-center ">'.$used_vl.'</td>
                    <td class="text-center ">'. $pending_vl.'</td>
                    <td class="text-center ">'.$earned_vl.'</td>
                    
                    <td class="text-center ">'.$used_sl.'</td>
                    <td class="text-center ">'. $pending_sl .'</td>
                    <td class="text-center ">'.$earned_sl.'</td>
                </tr>
            </tbody>
        </table>';
        
       
        
    }

public function GetAllLeaveHistory($date_from,$date_to){
        
        global $connL;

        echo '
        <div class="form-row">  
                    <div class="col-lg-1">
                        <select class="form-select" name="state" id="maxRows">
                             <option value="5000">ALL</option>
                             <option value="1">1</option>
                             <option value="5">5</option>
                             <option value="10">10</option>
                             <option value="15">15</option>
                             <option value="20">20</option>
                             <option value="50">50</option>
                             <option value="70">70</option>
                             <option value="100">100</option>
                        </select> 
                </div>         
                <div class="col-lg-8">
                </div>                               
                <div class="col-lg-3">        
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for leave.." title="Type in leave details"> 
                </div>                     
        </div>         
        <table id="LeaveListTab" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Leave Date</th>
                <th>Name</th>
                <th>Leave Type</th>
                <th>Description</th>
                <th>Leave Count</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT a.rowid,a.datefiled,leave_desc,leavetype,date_from,date_to, actl_cnt,remarks,app_days,a.emp_code,
                    (CASE when approved = 1 then 'PENDING'
                    when   approved = 2 then 'APPROVED'
                    when   approved = 3 then 'REJECTED'
                    when   approved = 4 then 'CANCELLED' ELSE 'N/A' END) as approved, b.lastname+','+b.firstname as fullname,a.rowid as lv_rowid FROM dbo.tr_leave a
        left join employee_profile b on a.emp_code = b.emp_code
        where a.approved = 2 and a.date_from between :startDate and :endDate";
        $param = array(":startDate" => date('Y-m-d', strtotime($date_from)),":endDate" => date('Y-m-d', strtotime($date_to)));
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
                $leaveid = "'".$result['lv_rowid']."'";
                $empcode = "'".$result['emp_code']."'";
                echo '
                <tr>
                <td id="ld'.$result['lv_rowid'].'">' . date('F d,Y', strtotime($result['date_from'])) . '</td>
                <td>' . $result['fullname'] . '</td>
                <td id="lt'.$result['lv_rowid'].'">' . $result['leavetype'] . '</td>
                <td id="ds'.$result['lv_rowid'].'">' . $result['leave_desc'] . '</td>
                <td id="lc'.$result['lv_rowid'].'">' . $result['actl_cnt'] . '</td>
                <td id="st'.$result['lv_rowid'].'">' . $result['approved'] . '</td>';
                echo'
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
        echo '</table>
        <div class="pagination-container">
        <nav>
          <ul class="pagination">
            
            <li data-page="prev" >
                <span> << <span class="sr-only">(current)</span></span></li>
    
          <li data-page="next" id="prev">
                  <span> >> <span class="sr-only">(current)</span></span>
            </li>
          </ul>
        </nav>
      </div>        ';
    }    

    public function GetLeaveHistory(){
        
        global $connL;

        echo '
        <div class="form-row">  
                    <div class="col-lg-1">
                        <select class="form-select" name="state" id="maxRows">
                             <option value="5000">ALL</option>
                             <option value="1">1</option>
                             <option value="5">5</option>
                             <option value="10">10</option>
                             <option value="15">15</option>
                             <option value="20">20</option>
                             <option value="50">50</option>
                             <option value="70">70</option>
                             <option value="100">100</option>
                        </select> 
                </div>         
                <div class="col-lg-8">
                </div>                               
                <div class="col-lg-3">        
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for leave.." title="Type in leave details"> 
                </div>                     
        </div>         
        <table id="leaveList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Leave Date</th>
                <th>Leave Type</th>
                <th>Description</th>
                <th>Leave Count</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT rowid,datefiled,leave_desc,leavetype,date_from,date_to, actl_cnt,remarks,app_days,emp_code,(CASE when approved = 1 then 'PENDING'
                    when   approved = 2 then 'APPROVED'
                    when   approved = 3 then 'REJECTED'
                    when   approved = 4 then 'CANCELLED' ELSE 'N/A' END) as approved FROM dbo.tr_leave where emp_code = :emp_code ORDER BY date_from DESC, leavetype";
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
                $empcode = "'".$result['emp_code']."'";
                echo '
                <tr>
                <td id="ld'.$result['rowid'].'">' . date('F d, Y', strtotime($result['date_from'])) . '</td>
                <td id="lt'.$result['rowid'].'">' . $result['leavetype'] . '</td>
                <td id="ds'.$result['rowid'].'">' . $result['leave_desc'] . '</td>
                <td id="lc'.$result['rowid'].'">' . $result['actl_cnt'] . '</td>
                <td id="st'.$result['rowid'].'">' . $result['approved'] . '</td>';

                // <button type="button" class="editL" onclick="updateLeaveModal('.$leaveid.')" title="View Leave"><i class="fas fa-edit"></i></button>
    
                if($result['approved'] == 'PENDING' || $result['approved'] == 'APPROVED'){
                echo'
                <td><button type="button" class="hactv" onclick="viewLeaveModal('.$datefl.','.$leavedesc.','.$leavetyp.','.$datefr.','.$dateto.','.$remark.','.$appdays.','.$appr_oved.','.$actlcnt.')" title="View Leave">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewLeaveHistoryModal('.$leaveid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                           
                            <button type="button" id="clv" class="voidBut" onclick="cancelLeave('.$leaveid.','.$empcode.')" title="Cancel Leave">
                                <i class="fas fa-ban"></i>
                            </button>
                            </td>';
                }else{
                echo'
                <td><button type="button" class="hactv" onclick="viewLeaveModal('.$datefl.','.$leavedesc.','.$leavetyp.','.$datefr.','.$dateto.','.$remark.','.$appdays.','.$appr_oved.','.$actlcnt.')" title="View Leave">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewLeaveHistoryModal('.$leaveid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                        
                            </td>';
                }

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="10" class="text-center">No Results Found</td></tr></tfoot>'; 
        }
        echo '</table>
        <div class="pagination-container">
        <nav>
          <ul class="pagination">
            
            <li data-page="prev" >
                <span> << <span class="sr-only">(current)</span></span></li>
    
          <li data-page="next" id="prev">
                  <span> >> <span class="sr-only">(current)</span></span>
            </li>
          </ul>
        </nav>
      </div>        ';
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

    public function EditLeaveType(){

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
                <label for="leaveType">Leave Type:</label><span class="req">*</span>
            </div>
            <div class="col-md-5">
                <select class="form-select" name="eleaveType" id="eleaveType" >';

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
                <label for="leaveType">Leave Type:</label><span class="req">*</span>
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

    public function InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity,$leaveDate,$leaveDesc, $leaveCount,$e_req,$n_req,$e_appr,$n_appr){

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
                    ":date_from"=> $leaveDate,
                    ":date_to"=> $leaveDate,
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

            $querys = "INSERT INTO logs_leave (leave_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:leave_id, :emp_code,:emp_name,:remarks,:audituser, :auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":leave_id" => $rst['maxid'],
                    ":emp_code"=> $empCode,
                    ":emp_name"=> $empName,
                    ":remarks" => 'Apply '.$leaveType,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $results = $stmts->execute($params);

        echo $results;

        $erequester = $e_req;
        $nrequester = $n_req;
        $eapprover = $e_appr;
        $napprover = $n_appr;

        $mail = new PHPMailer(true);
        try {
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;      
        $mail->isSMTP();                                           
        $mail->Host       = 'mail.obanana.com'; 
        $mail->SMTPAuth   = true;                                   
        $mail->Username   = 'hris-support@obanana.com';        
        $mail->Password   = '@dmin123@dmin123';                              
        $mail->SMTPSecure = 'tls';            
        $mail->Port       = 587;                                   

        $mail->setFrom('hris-support@obanana.com','HRIS-NOREPLY');
        $mail->addAddress($eapprover,'Approver');    

        $mail->isHTML(true);                          
        $mail->Subject = 'Leave Request Sent to Approver: ';
        $mail->Body    = '<h1>Hi '.$napprover.' </b>,</h1>An employee has requested a leave.<br><br>
                        <h2>From: '.$nrequester.' <br><br></h2>
                        <h2>Check the request in :
                        <a href="http://124.6.185.87:6868/hris_obanana/leave/leaveApproval_view.php">Leave Approval List</a> 
                        <br><br></h2>

                        Thank you for using our application! <br>
                        Regards, <br>
                        Human Resource Information System <br> <br>

                        <h6>If you are having trouble clicking the "Leave Approval List" button, copy and paste the URL below into your web browser: http://124.6.185.87:6868/hris_obanana/leave/leaveApproval_view.php <h6>
                       ';
            $mail->send();
            // echo 'Message has been sent';
            } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }


    }

    public function ApplyLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType,$dateBirth,$dateStartMaternity,$leaveDate,$leaveDesc, $medicalFile, $leaveCount, $allhalfdayMark,$e_req,$n_req,$e_appr,$n_appr){

        $allowedDays = 0;

        if($leaveType === "Vacation Leave" || $leaveType === "Bereavement Leave" || $leaveType === "Sick Leave" || $leaveType === "Emergency Leave"){

            $balanceCount = $this->GetBalanceCount($empCode, $leaveType);

            if($balanceCount >= $leaveCount){

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType,$medicalFile,$dateBirth,$dateStartMaternity, $leaveDate, $leaveDesc, $leaveCount,$e_req,$n_req,$e_appr,$n_appr);
                $this->UpdateLeaveCount($empCode, $leaveType, $balanceCount - $leaveCount);

            }elseif($balanceCount < $leaveCount){

                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity, $leaveDate,$leaveDesc, $balanceCount,$e_req,$n_req,$e_appr,$n_appr);
                $this->UpdateLeaveCount($empCode, $leaveType, $balanceCount - $balanceCount);
            }
           

        }else if($leaveType === "Sick Leave without Pay" || $leaveType === "Vacation Leave without Pay" ){



            $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity,$leaveDate,$leaveDesc, $leaveCount,$e_req,$n_req,$e_appr,$n_appr);

        }else{

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

    
                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,
                    $dateStartMaternity,$leaveDate, $leaveDesc, $leaveCount,$e_req,$n_req,$e_appr,$n_appr);
    
            }else{


                $this->InsertAppliedLeave($empCode, $empName, $empDept, $empReportingTo, $leaveType, $medicalFile,$dateBirth,$dateStartMaternity,$leaveDate, $leaveDesc, $allowedDays,$e_req,$n_req,$e_appr,$n_appr);


            }
        }

    }

   

}


?>