<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

Class DtrCorrectApp{

    private $employeeCode;
    
    public function SetdtrcorrectAppParams($employeeCode){
        $this->employeeCode = $employeeCode;
    }


public function GetAlldtrcorrectAppHistory($date_from,$date_to,$status){
        global $connL;

        echo '
        <div class="form-row">  
                    <div class="col-lg-1">
                        <select class="form-select" name="state" id="maxRows">
                             <option value="5000">ALL</option>
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for dtr correction.." title="Type in dtr correction details"> 
                        </div>                     
                </div>         
        <table id="DtrcListTab" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>DTR Date</th>
                <th>Name</th>
                <th>Time-In</th>
                <th>Time-Out</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT (CASE when status = 1 then 'PENDING'
                    when   status = 2 then 'APPROVED'
                    when   status = 3 then 'REJECTED'
                    when   status = 4 then 'CANCELLED' ELSE 'N/A' END) as stats,b.lastname+','+b.firstname as fullname,a.rowid as dtrc_id,* FROM dbo.tr_dtrcorrect a
        left join employee_profile b on a.emp_code = b.emp_code
        where status = :status and dtrc_date between :startDate and :endDate";
        $param = array(":startDate" => date('Y-m-d', strtotime($date_from)),":endDate" => date('Y-m-d', strtotime($date_to)),":status" => $status);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                // dtrcdate,timein,timeout,remarks,stts
                $dtrcdate = "'".date('m-d-Y', strtotime($result['dtrc_date']))."'";
                $timein = "'".date('h:i a', strtotime($result['time_in']))."'";
                $timeout = "'".date('h:i a', strtotime($result['time_out']))."'";
                $rmrks = "'".$result['remarks']."'";
                $stts = "'".$result['stats']."'";
                $dtrcid = "'".$result['dtrc_id']."'";
                $empcode = "'".$result['emp_code']."'";
                echo '
                <tr>
                <td>'.date('F d,Y', strtotime($result['dtrc_date'])).'</td>
                <td>'.$result['fullname'] . '</td>
                <td>'.date('h:i a', strtotime($result['time_in'])).'</td>
                <td>'.date('h:i a', strtotime($result['time_out'])).'</td>
                <td>'.$result['remarks'] . '</td>
                <td id="st'.$result['dtrc_id'].'">'.$result['stats'].'</td>';
                echo'
                <td><button type="button" class="hactv" onclick="viewdtrcorrectModal('.$dtrcdate.','.$timein.','.$timeout.','.$rmrks.','.$stts.')" title="View DTR Correction">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewdtrcorrectHistoryModal('.$dtrcid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                       
                            </td>';                                


            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
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
      </div>';
    }

    public function GetAlldtrcorrectRepHistory($date_from,$date_to,$empCode){
        global $connL;

        echo '
        <div class="form-row">  
                    <div class="col-lg-1">
                        <select class="form-select" name="state" id="maxRows">
                             <option value="5000">ALL</option>
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunctionRep()" placeholder="Search for dtr correction.." title="Type in dtr correction details"> 
                        </div>                     
                </div>         
        <table id="DtrcListRepTab" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>DTR Date</th>
                <th>Name</th>
                <th>Time-In</th>
                <th>Time-Out</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT (CASE when status = 1 then 'PENDING'
                    when   status = 2 then 'APPROVED'
                    when   status = 3 then 'REJECTED'
                    when   status = 4 then 'CANCELLED' ELSE 'N/A' END) as stats,b.lastname+','+b.firstname as fullname,a.rowid as dtrc_id,* FROM dbo.tr_dtrcorrect a
        left join employee_profile b on a.emp_code = b.emp_code
        where a.emp_code = :empCode and dtrc_date between :startDate and :endDate";
        $param = array(":startDate" => date('Y-m-d', strtotime($date_from)),":endDate" => date('Y-m-d', strtotime($date_to)),":empCode" => $empCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                // dtrcdate,timein,timeout,remarks,stts
                $dtrcdate = "'".date('m-d-Y', strtotime($result['dtrc_date']))."'";
                $timein = "'".date('h:i a', strtotime($result['time_in']))."'";
                $timeout = "'".date('h:i a', strtotime($result['time_out']))."'";
                $rmrks = "'".$result['remarks']."'";
                $stts = "'".$result['stats']."'";
                $dtrcid = "'".$result['dtrc_id']."'";
                $empcode = "'".$result['emp_code']."'";
                echo '
                <tr>
                <td>'.date('F d,Y', strtotime($result['dtrc_date'])).'</td>
                <td>'.$result['fullname'] . '</td>
                <td>'.date('h:i a', strtotime($result['time_in'])).'</td>
                <td>'.date('h:i a', strtotime($result['time_out'])).'</td>
                <td>'.$result['remarks'] . '</td>
                <td id="st'.$result['dtrc_id'].'">'.$result['stats'].'</td>';
                echo'
                <td><button type="button" class="hactv" onclick="viewdtrcorrectModal('.$dtrcdate.','.$timein.','.$timeout.','.$rmrks.','.$stts.')" title="View DTR Correction">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewdtrcorrectHistoryModal('.$dtrcid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                       
                            </td>';                                


            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
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
      </div>';
    }



    public function GetdtrcorrectAppHistory(){
        global $connL;

        echo '
        <div class="form-row">  
                    <div class="col-lg-1">
                        <select class="form-select" name="state" id="maxRows">
                             <option value="5000">ALL</option>
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for dtr correction.." title="Type in dtr correction details"> 
                        </div>                     
                </div>         
        <table id="dtrcorrectList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>DTR Date</th>
                <th>Time-In</th>
                <th>Time-Out</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT (CASE when status = 1 then 'PENDING'
                    when   status = 2 then 'APPROVED'
                    when   status = 3 then 'REJECTED'
                    when   status = 4 then 'CANCELLED' ELSE 'N/A' END) as stats,* FROM dbo.tr_dtrcorrect where emp_code = :emp_code ORDER BY dtrc_date DESC";
        $param = array(':emp_code' => $this->employeeCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                // dtrcdate,timein,timeout,remarks,stts
                $dtrcdate = "'".date('m-d-Y', strtotime($result['dtrc_date']))."'";
                $t_in = (isset($result['time_in'])) ? date('h:i A', strtotime($result['time_in'])) : 'n/a';
                $t_out = (isset($result['time_out'])) ? date('h:i A', strtotime($result['time_out'])) : 'n/a';
                $timein = "'".$t_in ."'";
                $timeout = "'".$t_out."'";
                $rmrks = "'".$result['remarks']."'";
                $stts = "'".$result['stats']."'";
                $dtrcid = "'".$result['rowid']."'";
                $empcode = "'".$result['emp_code']."'";

                echo '
                <tr>
                <td>'.date('F d, Y', strtotime($result['dtrc_date'])).'</td>
                <td>'.$t_in.'</td>
                <td>'.$t_out.'</td>
                <td>'.$result['remarks'] .'</td>
                <td id="st'.$result['rowid'].'">'.$result['stats'].'</td>';
                if($result['stats'] == 'PENDING' || $result['stats'] == 'APPROVED'){
                echo'
                <td><button type="button" class="hactv" onclick="viewdtrcorrectModal('.$dtrcdate.','.$timein.','.$timeout.','.$rmrks.','.$stts.')" title="View DTR Correction">
                    <i class="fas fa-binoculars"></i>
                </button>
                <button type="button" class="hdeactv" onclick="viewdtrcorrectHistoryModal('.$dtrcid.')" title="View Logs">
                    <i class="fas fa-history"></i>
                </button>                           
                <button type="button" id="clv" class="voidBut" onclick="canceldtrcorrect('.$dtrcid.','.$empcode.')" title="Cancel DTR Correction">
                    <i class="fas fa-ban"></i>
                </button>
                </td>';
                }else{
                echo'
                <td><button type="button" class="hactv" onclick="viewdtrcorrectModal('.$dtrcdate.','.$timein.','.$timeout.','.$rmrks.','.$stts.')" title="View DTR Correction">
                        <i class="fas fa-binoculars"></i>
                    </button>
                    <button type="button" class="hdeactv" onclick="viewdtrcorrectHistoryModal('.$dtrcid.')" title="View Logs">
                        <i class="fas fa-history"></i>
                    </button>                       
                    </td>';
                }                            


            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="8" class="text-center">No Results Found</td></tr></tfoot>'; 
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
      </div>';
    }

    public function InsertAppliedDtrCorrectApp($empCode,$empReportingTo,$dtrc_date,$time_in,$time_out,$remarks,$e_req,$n_req,$e_appr,$n_appr){

            global $connL;

           if($time_in == ''){
            $timi = null;
           }else{
            $timi = date('m-d-Y H:i:s', strtotime($time_in));
           }

           if($time_out == ''){
            $timo = null;
           }else{
            $timo = date('m-d-Y H:i:s', strtotime($time_out));
           }

            // echo $timi;
            // echo nl2br('\r \n');
            // echo $timo;
       

            $query = "INSERT INTO tr_dtrcorrect(emp_code,dtrc_date,date_filed,time_in,time_out,remarks,reporting_to,audituser,auditdate) 
                VALUES(:emp_code,:dtrc_date,:date_filed,:time_in,:time_out,:remarks,:empReportingTo,:audituser,:auditdate) ";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":emp_code"=> $empCode,
                    ":dtrc_date" => $dtrc_date,
                    ":date_filed"=>date('m-d-Y'),
                    ":empReportingTo" => $empReportingTo,
                    ":time_in"=> $timi,
                    ":time_out"=> $timo,
                    ":remarks"=> $remarks,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y H:i:s')
                );

            $result = $stmt->execute($param);

            echo $result;

            $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empCode";
            $sparam = array(':empCode' => $empCode);
            $sstmt =$connL->prepare($squery);
            $sstmt->execute($sparam);
            $sresult = $sstmt->fetch();
            $sname = $sresult['fullname'];

            $qry = 'SELECT max(rowid) as maxid FROM tr_dtrcorrect WHERE emp_code = :emp_code';
            $prm = array(":emp_code" => $empCode);
            $stm =$connL->prepare($qry);
            $stm->execute($prm);
            $rst = $stm->fetch();

            $querys = "INSERT INTO logs_dtrc (dtrc_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:dtrc_id,:emp_code,:emp_name,:remarks,:audituser,:auditdate) ";
                $stmts =$connL->prepare($querys);    
                $params = array(
                    ":dtrc_id" => $rst['maxid'],
                    ":emp_code"=> $empCode,
                    ":emp_name"=> $sname,
                    ":remarks" => 'Apply DTR Correction for '.$dtrc_date,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y H:i:s')
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
        $mail->Subject = 'DTR Correction Request Sent to Approver: ';
        $mail->Body    = '<h1>Hi '.$napprover.' </b>,</h1>An employee has requested dtr correction(#'.$rst['maxid'].').<br><br>
                        <h2>From: '.$nrequester.' <br><br></h2>
                        <h2>Check the request in :
                        <a href="http://124.6.185.87:6868/dtrcorrect/dtrcorrect_app_view.php">DTR Correction Approval List</a> 
                        <br><br></h2>

                        Thank you for using our application! <br>
                        Regards, <br>
                        Human Resource Information System <br> <br>

                        <h6>If you are having trouble clicking the "DTR Correction Approval List" button, copy and paste the URL below into your web browser: http://124.6.185.87:6868/dtrcorrect/dtrcorrect_app_view.php <h6>
                       ';
            $mail->send();
            // echo 'Message has been sent';
            } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }                                 


    }
}

?>