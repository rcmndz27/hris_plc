<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

Class ObApp{

    private $employeeCode;
    
    public function SetObAppParams($employeeCode){
        $this->employeeCode = $employeeCode;
    }


    public function GetObAppHistory(){
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
                    <input type="text" id="myInput" class="form-control" onkeyup="myFunction()" placeholder="Search for official business.." title="Type in official business details"> 
                        </div>                     
                </div>          
        <table id="obList" class="table table-striped table-sm">
        <thead>
            <tr>
                <th>Date Filed</th>
                <th>Destination</th>
                <th>OB Date</th>
                <th>Time</th>
                <th>Purpose</th>
                <th>Person/Company to See</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>';

        $query = "SELECT (CASE when status = 1 then 'PENDING'
                    when   status = 2 then 'APPROVED'
                    when   status = 3 then 'REJECTED'
                    when   status = 4 then 'VOID' ELSE 'N/A' END) as stats,* FROM dbo.tr_offbusiness where emp_code = :emp_code ORDER BY date_filed DESC";
        $param = array(':emp_code' => $this->employeeCode);
        $stmt =$connL->prepare($query);
        $stmt->execute($param);
        $result = $stmt->fetch();

        if($result){
            do { 
                $datefiled = "'".date('m-d-Y', strtotime($result['date_filed']))."'";
                $obdestination = "'".(isset($result['ob_destination']) ? $result['ob_destination'] : 'n/a')."'";
                $obdate = "'".date('m-d-Y', strtotime($result['ob_date']))."'";
                $obtime = "'".date('h:i a', strtotime($result['ob_time']))."'";
                $obpurpose = "'".$result['ob_purpose']."'";
                $obpercmp = "'".$result['ob_percmp']."'";
                $stats = "'".$result['stats']."'";
                $obid = "'".$result['rowid']."'";
                $empcode = "'".$result['emp_code']."'";
                echo '
                <tr>
                <td>' . date('m-d-Y', strtotime($result['date_filed'])) . '</td>
                <td>' . $result['ob_destination'] . '</td>
                <td>' . date('m-d-Y', strtotime($result['ob_date'])). '</td>
                <td>' . date('h:i a', strtotime($result['ob_time'])) . '</td>
                <td>' . $result['ob_purpose'] . '</td>
                <td>' . $result['ob_percmp'] . '</td>
                <td id="st'.$result['rowid'].'">' . $result['stats'] . '</td>';
                if($result['stats'] == 'PENDING'){
                echo'
                <td><button type="button" class="hactv" onclick="viewObModal('.$obdestination.','.$obdate.','.$obtime.','.$obpurpose.','.$obpercmp.','.$stats.')" title="View Overtime">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewObHistoryModal('.$obid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                         
                            <button type="button" id="clv" class="voidBut" onclick="cancelOb('.$obid.','.$empcode.')" title="Cancel Work From Home">
                                <i class="fas fa-ban"></i>
                            </button>
                            </td>';
                }else{
                echo'
                <td><button type="button" class="hactv" onclick="viewObModal('.$obdestination.','.$obdate.','.$obtime.','.$obpurpose.','.$obpercmp.','.$stats.')" title="View Overtime">
                                <i class="fas fa-binoculars"></i>
                            </button>
                            <button type="button" class="hdeactv" onclick="viewObHistoryModal('.$obid.')" title="View Logs">
                                <i class="fas fa-history"></i>
                            </button>                      
                            </td>';
                }                             

            } while ($result = $stmt->fetch());

            echo '</tr></tbody>';

        }else { 
            echo '<tfoot><tr><td colspan="9" class="text-center">No Results Found</td></tr></tfoot>'; 
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

    public function InsertAppliedObApp($empCode,$empReportingTo,$ob_time,$ob_destination,$ob_purpose,$ob_percmp, 
            $obDate,$e_req,$n_req,$e_appr,$n_appr){

        global $connL;

            $query = "INSERT INTO tr_offbusiness (emp_code,date_filed,ob_date,ob_reporting,ob_time,ob_destination,ob_purpose,ob_percmp,audituser,auditdate) 
                VALUES(:emp_code,:date_filed,:ob_date,:ob_reporting,:ob_time,:ob_destination,:ob_purpose,:ob_percmp,:audituser,:auditdate) ";
    
                $stmt =$connL->prepare($query);

                $param = array(
                    ":emp_code"=> $empCode,
                    ":ob_date" => $obDate,
                    ":date_filed"=>date('m-d-Y'),
                    ":ob_reporting" => $empReportingTo,
                    ":ob_time" => $ob_time,
                    ":ob_destination"=> $ob_destination,
                    ":ob_purpose"=> $ob_purpose,
                    ":ob_percmp"=> $ob_percmp,
                    ":audituser" => $empCode,
                    ":auditdate"=>date('m-d-Y')
                );

            $result = $stmt->execute($param);

            echo $result;

            $squery = "SELECT lastname+', '+firstname as [fullname] FROM employee_profile WHERE emp_code = :empCode";
            $sparam = array(':empCode' => $empCode);
            $sstmt =$connL->prepare($squery);
            $sstmt->execute($sparam);
            $sresult = $sstmt->fetch();
            $sname = $sresult['fullname'];            

            $qry = 'SELECT max(rowid) as maxid FROM tr_offbusiness WHERE emp_code = :emp_code';
            $prm = array(":emp_code" => $empCode);
            $stm =$connL->prepare($qry);
            $stm->execute($prm);
            $rst = $stm->fetch();

            $querys = "INSERT INTO logs_ob (ob_id,emp_code,emp_name,remarks,audituser,auditdate) 
                VALUES(:ob_id,:emp_code,:emp_name,:remarks,:audituser,:auditdate) ";
    
                $stmts =$connL->prepare($querys);
    
                $params = array(
                    ":ob_id" => $rst['maxid'],
                    ":emp_code"=> $empCode,
                    ":emp_name"=> $sname,
                    ":remarks" => 'Apply OB for '.$obDate,
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
        $mail->Subject = 'Official Business Request Sent to Approver: ';
        $mail->Body    = '<h1>Hi '.$napprover.' </b>,</h1>An employee has requested official business(#'.$rst['maxid'].').<br><br>
                        <h2>From: '.$nrequester.' <br><br></h2>
                        <h2>Check the request in :
                        <a href="http://203.177.143.61:8080/hris_obanana/ob/ob-approval-view.php">Official Business Approval List</a> 
                        <br><br></h2>

                        Thank you for using our application! <br>
                        Regards, <br>
                        Human Resource Information System <br> <br>

                        <h6>If you are having trouble clicking the "Official Business Approval List" button, copy and paste the URL below into your web browser: http://203.177.143.61:8080/hris_obanana/ob/ob-approval-view.php <h6>
                       ';
            $mail->send();
            // echo 'Message has been sent';
            } catch (Exception $e) {
            // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }                                 


    }

}

?>